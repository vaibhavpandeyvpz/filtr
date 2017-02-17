<?php

/*
 * This file is part of vaibhavpandeyvpz/filtr package.
 *
 * (c) Vaibhav Pandey <contact@vaibhavpandey.com>
 *
 * This source file is subject to the MIT license that is bundled
 * with this source code in the file LICENSE.md.
 */

namespace Filtr;

use Filtr\Rule\Builder;

/**
 * Class Validator
 * @package Filtr
 */
class Validator implements ValidatorInterface
{
    /**
     * @var array
     */
    protected $assertions = array();

    /**
     * @var array
     */
    protected $required = array();

    /**
     * @var bool
     */
    protected $strict;

    /**
     * Validator constructor.
     * @param bool $strict
     */
    public function __construct($strict = true)
    {
        $this->strict = $strict;
    }

    /**
     * {@inheritdoc}
     */
    public function key($name)
    {
        return $this->required($name, false);
    }

    /**
     * {@inheritdoc}
     */
    public function required($key, $message = 'This value is required.')
    {
        $assertion = new Builder();
        $this->assertions[$key] = $assertion;
        $this->required[$key] = $message;
        return $assertion;
    }

    /**
     * {@inheritdoc}
     */
    public function validate(array $data = null, $message = 'This value was unexpected.')
    {
        $data = (array)$data;
        $result = new Result();
        if ($this->strict) {
            $extras = array_diff_key($data, array_flip(array_keys($this->assertions)));
            if (!empty($extras)) {
                foreach ($extras as $key) {
                    $result->error($key, $message);
                }
            }
        }
        /**
         * @var string $key
         * @var RuleInterface $assertion
         */
        foreach ($this->assertions as $key => $assertion) {
            if (array_key_exists($key, $data)) {
                if (!$assertion->validate($data[$key])) {
                    $result->error($key, $assertion->message());
                }
            } elseif (false !== ($message = $this->required[$key])) {
                $result->error($key, $message);
            }
        }
        return $result;
    }
}

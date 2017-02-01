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
    public function validate(array $data)
    {
        $result = new Result();
        /**
         * @var string $key
         * @var RuleInterface $assertion
         */
        foreach ($this->assertions as $key => $assertion) {
            if (array_key_exists($key, $data)) {
                if (false === $assertion->validate($data[$key])) {
                    $result->error($key, $assertion->message());
                }
            } elseif (is_string($message = $this->required[$key])) {
                $result->error($key, $message);
            }
        }
        return $result;
    }
}

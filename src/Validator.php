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
     * @param array $haystack
     * @param string $needle
     * @return mixed
     */
    protected static function fetch(array $haystack, $needle)
    {
        if (isset($haystack[$needle])) {
            return $haystack[$needle];
        }
        foreach (explode('.', $needle) as $segment) {
            if (is_array($haystack) && array_key_exists($segment, $haystack)) {
                $haystack = $haystack[$segment];
                continue;
            }
            return null;
        }
        return $haystack;
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
        /**
         * @var string $key
         * @var RuleInterface $assertion
         */
        foreach ($this->assertions as $key => $assertion) {
            if (null !== ($value = self::fetch($data, $key))) {
                if (!$assertion->validate($value)) {
                    $result->error($key, $assertion->message());
                }
            } elseif (false !== ($message = $this->required[$key])) {
                $result->error($key, $message);
            }
        }
        return $result;
    }
}

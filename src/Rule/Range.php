<?php

/*
 * This file is part of vaibhavpandeyvpz/filtr package.
 *
 * (c) Vaibhav Pandey <contact@vaibhavpandey.com>
 *
 * This source file is subject to the MIT license that is bundled
 * with this source code in the file LICENSE.md.
 */

namespace Filtr\Rule;

use Filtr\Rule;

/**
 * Class Range
 * @package Filtr\Rule
 */
class Range extends Rule
{
    /**
     * @var int
     */
    protected $max;

    /**
     * @var string
     */
    protected $message = 'This value should be %d to %d range.';

    /**
     * @var int
     */
    protected $min;

    /**
     * Range constructor.
     * @param int $min
     * @param int $max
     */
    public function __construct($min, $max)
    {
        $this->min = $min;
        $this->max = $max;
    }

    /**
     * {@inheritdoc}
     */
    public function message()
    {
        return sprintf($this->message, $this->min, $this->max);
    }

    /**
     * {@inheritdoc}
     */
    public function validate($value)
    {
        if (null === $value) {
            return true;
        }
        $value = (int)$value;
        if ($value >= $this->min) {
            return is_int($this->max) ? ($value <= $this->max) : true;
        }
        return false;
    }
}

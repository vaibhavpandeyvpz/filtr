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
 * Class Length
 * @package Filtr\Rule
 */
class Length extends Rule
{
    /**
     * @var int|null
     */
    protected $max;

    /**
     * @var string
     */
    protected $message = 'This value should contain a minimum of %d characters.';

    /**
     * @var string
     */
    protected $message2 = 'This value should contain a minimum of %d and a maximum of %d characters.';

    /**
     * @var int
     */
    protected $min;

    /**
     * Length constructor.
     * @param int $min
     * @param int|null $max
     */
    public function __construct($min, $max = null)
    {
        $this->min = $min;
        $this->max = $max;
    }

    /**
     * {@inheritdoc}
     */
    public function message()
    {
        if (is_int($this->max)) {
            return sprintf($this->message2, $this->min, $this->max);
        }
        return sprintf($this->message, $this->min);
    }

    /**
     * {@inheritdoc}
     */
    public function validate($value)
    {
        if ((null === $value) || ('' === $value)) {
            return true;
        }
        $value = strlen($value);
        if ($value >= $this->min) {
            return is_int($this->max) ? ($value <= $this->max) : true;
        }
        return false;
    }
}

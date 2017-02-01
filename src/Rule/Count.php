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
 * Class Count
 * @package Filtr\Rule
 */
class Count extends Rule
{
    /**
     * @var string
     */
    protected $message = 'This should only contain %s value(s).';

    /**
     * @var int
     */
    protected $number;

    /**
     * Count constructor.
     * @param int $number
     */
    public function __construct($number)
    {
        $this->number = $number;
    }

    /**
     * @return string
     */
    public function message()
    {
        return sprintf($this->message, $this->number);
    }

    /**
     * {@inheritdoc}
     */
    public function validate($value)
    {
        return $this->number === count($value);
    }
}

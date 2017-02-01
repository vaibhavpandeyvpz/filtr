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
 * Class Number
 * @package Filtr\Rule
 */
class Number extends Rule
{
    /**
     * @var string
     */
    protected $message = 'This value must be a number.';

    /**
     * {@inheritdoc}
     */
    public function validate($value)
    {
        if ((null === $value) || ('' === $value)) {
            return true;
        }
        return is_numeric($value);
    }
}

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
 * Class Url
 * @package Filtr\Rule
 */
class Url extends Rule
{
    /**
     * @var string
     */
    protected $message = 'This value is not a valid URL.';

    /**
     * {@inheritdoc}
     */
    public function validate($value)
    {
        if (null === $value) {
            return true;
        }
        return filter_var($value, FILTER_VALIDATE_URL);
    }
}

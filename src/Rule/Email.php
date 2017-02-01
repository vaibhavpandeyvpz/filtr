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
 * Class Email
 * @package Filtr\Rule
 */
class Email extends Rule
{
    /**
     * @var string
     */
    protected $message = 'This value is not a valid email address.';

    /**
     * {@inheritdoc}
     */
    public function validate($value)
    {
        return filter_var($value, FILTER_VALIDATE_EMAIL);
    }
}

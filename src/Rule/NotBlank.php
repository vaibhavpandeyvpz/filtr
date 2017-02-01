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
 * Class NotBlank
 * @package Filtr\Rule
 */
class NotBlank extends Rule
{
    /**
     * @var string
     */
    protected $message = 'This value should not be blank.';

    /**
     * {@inheritdoc}
     */
    public function validate($value)
    {
        return (false === empty($value)) || ($value == '0');
    }
}

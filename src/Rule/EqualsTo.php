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
 * Class EqualsTo
 * @package Filtr\Rule
 */
class EqualsTo extends Rule
{
    /**
     * @var mixed
     */
    protected $value;

    /**
     * EqualsTo constructor.
     * @param mixed $value
     */
    public function __construct($value)
    {
        $this->value = $value;
    }

    /**
     * {@inheritdoc}
     */
    public function validate($value)
    {
        return $this->value == $value;
    }
}

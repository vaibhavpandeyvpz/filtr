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
 * Class Type
 * @package Filtr\Rule
 */
class Type extends Rule
{
    /**
     * @var string
     */
    protected $type;

    /**
     * Type constructor.
     * @param string $type
     */
    public function __construct($type)
    {
        $this->type = $type;
    }

    /**
     * {@inheritdoc}
     */
    public function validate($value)
    {
        if (null === $value) {
            return true;
        }
        return $this->type === gettype($value);
    }
}

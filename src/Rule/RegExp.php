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
 * Class RegExp
 * @package Filtr\Rule
 */
class RegExp extends Rule
{
    /**
     * @var string
     */
    protected $pattern;

    /**
     * RegExp constructor.
     * @param string $pattern
     */
    public function __construct($pattern)
    {
        $this->pattern = $pattern;
    }

    /**
     * {@inheritdoc}
     */
    public function validate($value)
    {
        if ((null === $value) || ('' === $value)) {
            return true;
        }
        return preg_match($this->pattern, $value) === 1;
    }
}

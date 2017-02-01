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
 * Class Callback
 * @package Filtr\Rule
 */
class Callback extends Rule
{
    /**
     * @var int
     */
    protected $callback;

    /**
     * Callback constructor.
     * @param callable $callback
     */
    public function __construct($callback)
    {
        $this->callback = $callback;
    }

    /**
     * {@inheritdoc}
     */
    public function validate($value)
    {
        return true === call_user_func($this->callback, $value);
    }
}

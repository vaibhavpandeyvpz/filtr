<?php

/*
 * This file is part of vaibhavpandeyvpz/filtr package.
 *
 * (c) Vaibhav Pandey <contact@vaibhavpandey.com>
 *
 * This source file is subject to the MIT license that is bundled
 * with this source code in the file LICENSE.md.
 */

namespace Filtr;

/**
 * Class Rule
 * @package Filtr
 */
abstract class Rule implements RuleInterface
{
    /**
     * @var string
     */
    protected $message = 'This value is not valid.';

    /**
     * @return string
     */
    public function message()
    {
        return $this->message;
    }
}

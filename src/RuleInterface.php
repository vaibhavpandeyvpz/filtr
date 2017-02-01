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
 * Interface RuleInterface
 * @package Filtr
 */
interface RuleInterface
{
    /**
     * @return string
     */
    public function message();

    /**
     * @param mixed $input
     * @return bool
     */
    public function validate($input);
}

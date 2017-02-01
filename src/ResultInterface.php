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
 * Interface ResultInterface
 * @package Filtr
 */
interface ResultInterface
{
    /**
     * @param string $field
     * @param string $message
     */
    public function error($field, $message);

    /**
     * @return array
     */
    public function errors();

    /**
     * @return bool
     */
    public function valid();
}

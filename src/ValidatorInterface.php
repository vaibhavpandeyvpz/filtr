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

use Filtr\Rule\Builder;

/**
 * Interface ValidatorInterface
 * @package Filtr
 */
interface ValidatorInterface
{
    /**
     * @param string $name
     * @return Builder
     */
    public function key($name);

    /**
     * @param string $key
     * @param string $message
     * @return Builder
     */
    public function required($key, $message = 'This value is required.');

    /**
     * @param array|null $data
     * @return ResultInterface
     */
    public function validate(array $data = null);
}

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
 * Class Result
 * @package Filtr
 */
class Result implements ResultInterface
{
    /**
     * @var array
     */
    protected $errors = array();

    /**
     * {@inheritdoc}
     */
    public function error($field, $message)
    {
        $this->errors[$field] = $message;
    }

    /**
     * {@inheritdoc}
     */
    public function errors()
    {
        return $this->errors;
    }

    /**
     * {@inheritdoc}
     */
    public function valid()
    {
        return empty($this->errors);
    }
}

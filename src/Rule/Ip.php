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
 * Class Ip
 * @package Filtr\Rule
 */
class Ip extends Rule
{
    /**
     * @var int
     */
    protected $flags;

    /**
     * @var string
     */
    protected $message = 'This value is not a valid IP address.';

    /**
     * Ip constructor.
     * @param int $flags
     */
    public function __construct($flags = 0)
    {
        $this->flags = $flags;
    }

    /**
     * {@inheritdoc}
     */
    public function validate($value)
    {
        return filter_var($value, FILTER_VALIDATE_IP, $this->flags);
    }
}

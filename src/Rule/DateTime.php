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
 * Class DateTime
 * @package Filtr\Rule
 */
class DateTime extends Rule
{
    /**
     * @var string
     */
    protected $message = 'This value is not a valid date or time.';

    /**
     * @var string
     */
    protected $format = 'Y-m-d H:i:s';

    /**
     * DateTime constructor.
     * @param string|null $format
     */
    public function __construct($format = null)
    {
        if (is_string($format)) {
            $this->format = $format;
        }
    }

    /**
     * {@inheritdoc}
     */
    public function validate($value)
    {
        if ((null === $value) || ('' === $value) || ($value instanceof \DateTime)) {
            return true;
        }
        return false !== \DateTime::createFromFormat($this->format, $value);
    }
}

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
 * Class OneOf
 * @package Filtr\Rule
 */
class OneOf extends Rule
{
    /**
     * @var string
     */
    protected $message = 'This value should be one of %s.';

    /**
     * @var array|null
     */
    protected $values;

    /**
     * OneOf constructor.
     * @param array $values
     */
    public function __construct(array $values)
    {
        $this->values = $values;
    }

    /**
     * {@inheritdoc}
     */
    public function message()
    {
        return sprintf($this->message, implode(', ', $this->values));
    }

    /**
     * {@inheritdoc}
     */
    public function validate($value)
    {
        if (null === $value) {
            return true;
        }
        return in_array($value, $this->values);
    }
}

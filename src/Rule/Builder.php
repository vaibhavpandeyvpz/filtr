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
use Filtr\RuleInterface;

/**
 * Class Builder
 * @package Filtr\Rule
 */
class Builder extends Rule
{
    /**
     * @var RuleInterface[]
     */
    protected $rules = array();

    /**
     * @param callable $callback
     * @return static
     */
    public function is($callback)
    {
        $this->rules[] = new Callback($callback);
        return $this;
    }

    /**
     * @return static
     */
    public function isBlank()
    {
        $this->rules[] = new Blank();
        return $this;
    }

    /**
     * @return static
     */
    public function isBoolean()
    {
        return $this->isOfType('boolean');
    }

    /**
     * @param string|array|null $types
     * @return static
     */
    public function isCreditCard($types = null)
    {
        $this->rules[] = new CreditCard($types);
        return $this;
    }

    /**
     * @param string|null $format
     * @return static
     */
    public function isDateTime($format = null)
    {
        $this->rules[] = new DateTime($format);
        return $this;
    }

    /**
     * @return static
     */
    public function isEmailAddress()
    {
        $this->rules[] = new Email();
        return $this;
    }

    /**
     * @param mixed $value
     * @return static
     */
    public function isEqualTo($value)
    {
        $this->rules[] = new EqualsTo($value);
        return $this;
    }

    /**
     * @return static
     */
    public function isFalse()
    {
        return $this->isEqualTo(false);
    }

    /**
     * @param int $number
     * @return static
     */
    public function isHavingCount($number)
    {
        $this->rules[] = new Count($number);
        return $this;
    }

    /**
     * @param int $min
     * @param int|null $max
     * @return static
     */
    public function isHavingLength($min, $max = null)
    {
        $this->rules[] = new Length($min, $max);
        return $this;
    }

    /**
     * @param int $min
     * @param int $max
     * @return static
     */
    public function isInRange($min, $max)
    {
        $this->rules[] = new Range($min, $max);
        return $this;
    }

    /**
     * @return static
     */
    public function isInteger()
    {
        return $this->isOfType('integer');
    }

    /**
     * @param int $flags
     * @return static
     */
    public function isIpAddress($flags = 0)
    {
        $this->rules[] = new Ip($flags);
        return $this;
    }

    /**
     * @return static
     */
    public function isIpv4Address()
    {
        return $this->isIpAddress(FILTER_FLAG_IPV4);
    }

    /**
     * @return static
     */
    public function isIpv6Address()
    {
        return $this->isIpAddress(FILTER_FLAG_IPV6);
    }

    /**
     * @return static
     */
    public function isMacAddress()
    {
        return $this->isMatchingWith('~^(?:[a-fA-F0-9]{2}[:-]?){6}$~');
    }

    /**
     * @param string $regexp
     * @return static
     */
    public function isMatchingWith($regexp)
    {
        $this->rules[] = new RegExp($regexp);
        return $this;
    }

    /**
     * @return static
     */
    public function isNotBlank()
    {
        $this->rules[] = new NotBlank();
        return $this;
    }

    /**
     * @param mixed $value
     * @return static
     */
    public function isNotEqualTo($value)
    {
        $this->rules[] = new NotEqualsTo($value);
        return $this;
    }

    /**
     * @param mixed $value
     * @return static
     */
    public function isNotSameAs($value)
    {
        $this->rules[] = new NotSameAs($value);
        return $this;
    }

    /**
     * @return static
     */
    public function isNumber()
    {
        $this->rules[] = new Number();
        return $this;
    }

    /**
     * @param string $type
     * @return static
     */
    public function isOfType($type)
    {
        $this->rules[] = new Type($type);
        return $this;
    }

    /**
     * @param array $values
     * @return static
     */
    public function isOneOf(array $values)
    {
        $this->rules[] = new OneOf($values);
        return $this;
    }

    /**
     * @param mixed $value
     * @return static
     */
    public function isSameAs($value)
    {
        $this->rules[] = new SameAs($value);
        return $this;
    }

    /**
     * @return static
     */
    public function isString()
    {
        return $this->isOfType('string');
    }

    /**
     * @return static
     */
    public function isTrue()
    {
        return $this->isEqualTo(true);
    }

    /**
     * @return static
     */
    public function isUrl()
    {
        $this->rules[] = new Url();
        return $this;
    }

    /**
     * {@inheritdoc}
     */
    public function validate($value)
    {
        foreach ($this->rules as $rule) {
            if (false === ($valid = $rule->validate($value))) {
                $this->message = $rule->message();
                return $valid;
            }
        }
        return true;
    }
}

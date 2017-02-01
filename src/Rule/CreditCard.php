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
 * Class CreditCard
 * @package Filtr\Rule
 */
class CreditCard extends Rule
{
    const TYPE_AMEX = 'amex';

    const TYPE_MAESTRO = 'maestro';

    const TYPE_MASTERCARD = 'mc';

    const TYPE_VISA = 'visa';

    /**
     * @var string
     */
    protected $message = 'This value is not a valid card number.';

    /**
     * @var array
     */
    protected $types = array(
        'amex' => array('~^3[47][0-9]{13}$~'),
        'maestro' => array(
            '~^(6759[0-9]{2})[0-9]{6,13}$~',
            '~^(50[0-9]{4})[0-9]{6,13}$~',
            '~^5[6-9][0-9]{10,17}$~',
            '~^6[0-9]{11,18}$~',
        ),
        'mc' => array(
            '~^5[1-5][0-9]{14}$~',
            '~^2(22[1-9][0-9]{12}|2[3-9][0-9]{13}|[3-6][0-9]{14}|7[0-1][0-9]{13}|720[0-9]{12})$~',
        ),
        'visa' => array('~^4([0-9]{12}|[0-9]{15})$~'),
    );

    /**
     * @var array
     */
    protected $types2;

    /**
     * CreditCard constructor.
     * @param string|array|null $types
     */
    public function __construct($types = null)
    {
        $this->types2 = (array)$types;
    }

    /**
     * {@inheritdoc}
     */
    public function validate($value)
    {
        if (empty($this->types2)) {
            $types = &$this->types;
        } else {
            $types = array_intersect_key($this->types, array_flip($this->types2));
        }
        foreach ($types as $regexps) {
            foreach ($regexps as $regexp) {
                if (preg_match($regexp, $value)) {
                    return true;
                }
            }
        }
        return false;
    }
}

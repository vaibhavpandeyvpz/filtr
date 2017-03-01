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

use Filtr\Rule\CreditCard;

/**
 * Class ValidatorTest
 * @package Filtr
 */
class ValidatorTest extends \PHPUnit_Framework_TestCase
{
    public function testRequired()
    {
        $v = new Validator();
        $v->key('subject')->isNotBlank();
        $result = $v->validate(array());
        $this->assertTrue($result->valid());
        $v->required('subject')->isNotBlank();
        $result = $v->validate(array());
        $this->assertFalse($result->valid());
        $this->assertNotEmpty($result->errors());
        $this->assertArrayHasKey('subject', $result->errors());
    }

    public function testAliases()
    {
        $v = new Validator();
        // isBoolean
        $v->key('subject')->isBoolean();
        $result = $v->validate(array('subject' => true));
        $this->assertTrue($result->valid());
        $result = $v->validate(array('subject' => 'vaibhav'));
        $this->assertFalse($result->valid());
        // isInteger
        $v->key('subject')->isInteger();
        $result = $v->validate(array('subject' => 60600));
        $this->assertTrue($result->valid());
        $result = $v->validate(array('subject' => 'vaibhav'));
        $this->assertFalse($result->valid());
        // isString
        $v->key('subject')->isString();
        $result = $v->validate(array('subject' => 'vaibhav'));
        $this->assertTrue($result->valid());
        $result = $v->validate(array('subject' => 60600));
        $this->assertFalse($result->valid());
        // isTrue
        $v->key('subject')->isTrue();
        $result = $v->validate(array('subject' => true));
        $this->assertTrue($result->valid());
        $result = $v->validate(array('subject' => false));
        $this->assertFalse($result->valid());
        // isFalse
        $v->key('subject')->isFalse();
        $result = $v->validate(array('subject' => false));
        $this->assertTrue($result->valid());
        $result = $v->validate(array('subject' => true));
        $this->assertFalse($result->valid());
        // isIPv4Address
        $v->key('subject')->isIpv4Address();
        $result = $v->validate(array('subject' => '127.0.0.1'));
        $this->assertTrue($result->valid());
        $result = $v->validate(array('subject' => '2001:0db8:85a3:08d3:1319:8a2e:0370:7334'));
        $this->assertFalse($result->valid());
        // isIPv6Address
        $v->key('subject')->isIpv6Address();
        $result = $v->validate(array('subject' => '2001:0db8:85a3:08d3:1319:8a2e:0370:7334'));
        $this->assertTrue($result->valid());
        $result = $v->validate(array('subject' => '127.0.0.1'));
        $this->assertFalse($result->valid());
    }

    public function testDotNotation()
    {
        // Named Key
        $v = new Validator();
        $v->required('post.title')->isNotBlank()->isHavingLength(8, 128);
        $result = $v->validate(array('post' => array('title' => 'Post Title')));
        $this->assertTrue($result->valid());
        // Numeric Key
        $v = new Validator();
        $v->required('post.0.title')->isNotBlank()->isHavingLength(8, 128);
        $v->required('post.1.title')->isNotBlank()->isHavingLength(8, 128);
        $result = $v->validate(array(
            'post' => array(
                array('title' => 'Post Title #1'),
                array('title' => 'Post Title #2'),
            ),
        ));
        $this->assertTrue($result->valid());
    }

    /**
     * @param mixed $subject
     * @param bool $valid
     * @dataProvider providesBlank
     */
    public function testBlank($subject, $valid)
    {
        $v = new Validator();
        $v->key('subject')->isBlank();
        $result = $v->validate(array('subject' => $subject));
        $this->assertEquals($valid, $result->valid());
    }

    /**
     * @return array
     */
    public function providesBlank()
    {
        return array(
            array('', true),
            array(array(), true),
            array(0, false),
            array('0', false),
            array('one', false),
            array(array('one'), false),
        );
    }

    /**
     * @param mixed $subject
     * @param callable $callback
     * @param bool $valid
     * @dataProvider providesCallback
     */
    public function testCallback($subject, $callback, $valid)
    {
        $v = new Validator();
        $v->key('subject')->is($callback);
        $result = $v->validate(array('subject' => $subject));
        $this->assertEquals($valid, $result->valid());
    }

    /**
     * @return array
     */
    public function providesCallback()
    {
        return array(
            array('vaibhav', function ($value) {
                return is_string($value);
            }, true),
            array(60600, function ($value) {
                return is_int($value);
            }, true),
            array('vaibhav', function ($value) {
                return is_int($value);
            }, false),
            array(60600, function ($value) {
                return is_string($value);
            }, false),
        );
    }

    /**
     * @param mixed $subject
     * @param int $number
     * @param bool $valid
     * @dataProvider providesCount
     */
    public function testCount($subject, $number, $valid)
    {
        $v = new Validator();
        $v->key('subject')->isHavingCount($number);
        $result = $v->validate(array('subject' => $subject));
        $this->assertEquals($valid, $result->valid());
    }

    /**
     * @return array
     */
    public function providesCount()
    {
        return array(
            array('one', 1, true),
            array(array('one'), 1, true),
            array(array('one', 'two'), 2, true),
            array(array('one', 'two', 'three'), 3, true),
            array(array('one', 'two', 'three'), 1, false),
            array(array('one'), 3, false),
        );
    }

    /**
     * @param string $subject
     * @param string $type
     * @param bool $valid
     * @dataProvider providesCreditCard
     */
    public function testCreditCard($subject, $type, $valid)
    {
        $v = new Validator();
        $v->key('subject')->isCreditCard($type);
        $result = $v->validate(array('subject' => $subject));
        $this->assertEquals($valid, $result->valid());
    }

    /**
     * @return array
     */
    public function providesCreditCard()
    {
        return array(
            array('340000000000009', null, true),
            array('340000000000009', CreditCard::TYPE_AMEX, true),
            array('6759649826438453', null, true),
            array('6759649826438453', CreditCard::TYPE_MAESTRO, true),
            array('5500000000000004', null, true),
            array('5500000000000004', CreditCard::TYPE_MASTERCARD, true),
            array('4111111111111111', null, true),
            array('4111111111111111', CreditCard::TYPE_VISA, true),
            array('4111111111111111', CreditCard::TYPE_AMEX, false),
            array('340000000000009', CreditCard::TYPE_MAESTRO, false),
            array('6759649826438453', CreditCard::TYPE_MASTERCARD, false),
            array('5500000000000004', CreditCard::TYPE_VISA, false),
        );
    }

    /**
     * @param string $subject
     * @param string|null $format
     * @param bool $valid
     * @dataProvider providesDateTime
     */
    public function testDateTime($subject, $format, $valid)
    {
        $v = new Validator();
        $v->key('subject')->isDateTime($format);
        $result = $v->validate(array('subject' => $subject));
        $this->assertEquals($valid, $result->valid());
    }

    /**
     * @return array
     */
    public function providesDateTime()
    {
        return array(
            array('2017-02-01 07:10:00', null, true),
            array('2017-02-01 07:10:00', 'Y-m-d H:i:s', true),
            array('2017-02-01', 'Y-m-d', true),
            array('2017-02-01 07:10:00', 'Y-m-d', false),
            array('2017-02-01', null, false),
        );
    }

    /**
     * @param string $subject
     * @param bool $valid
     * @dataProvider providesEmail
     */
    public function testEmail($subject, $valid)
    {
        $v = new Validator();
        $v->key('subject')->isEmailAddress();
        $result = $v->validate(array('subject' => $subject));
        $this->assertEquals($valid, $result->valid());
    }

    /**
     * @return array
     */
    public function providesEmail()
    {
        return array(
            array('contact@vaibhavpandey.com', true),
            array('vaibhavpandeyvpz', false),
        );
    }

    /**
     * @param mixed $lhs
     * @param mixed $rhs
     * @param bool $valid
     * @dataProvider providesEqualsTo
     */
    public function testEqualsTo($lhs, $rhs, $valid)
    {
        $v = new Validator();
        $v->key('subject')->isEqualTo($rhs);
        $result = $v->validate(array('subject' => $lhs));
        $this->assertEquals($valid, $result->valid());
    }

    /**
     * @return array
     */
    public function providesEqualsTo()
    {
        return array(
            array(true, true, true),
            array(1, 1, true),
            array(true, 'true', true),
            array(1, '1', true),
        );
    }

    /**
     * @param string $subject
     * @param bool $valid
     * @dataProvider providesIpAddress
     */
    public function testIpAddress($subject, $valid)
    {
        $v = new Validator();
        $v->key('subject')->isIpAddress();
        $result = $v->validate(array('subject' => $subject));
        $this->assertEquals($valid, $result->valid());
    }

    /**
     * @return array
     */
    public function providesIpAddress()
    {
        return array(
            array('127.0.0.1', true),
            array('2001:0db8:85a3:08d3:1319:8a2e:0370:7334', true),
            array('vaibhavpandey.com', false),
        );
    }

    /**
     * @param int $min
     * @param int|null $max
     * @param string $subject
     * @param bool $valid
     * @dataProvider providesLength
     */
    public function testLength($min, $max, $subject, $valid)
    {
        $v = new Validator();
        $v->key('subject')->isHavingLength($min, $max);
        $result = $v->validate(array('subject' => $subject));
        $this->assertEquals($valid, $result->valid());
    }

    /**
     * @return array
     */
    public function providesLength()
    {
        return array(
            array(5, 10, 'Vaibhav', true),
            array(8, 10, 'VPZ', false),
            array(8, null, 'VPZ', false),
        );
    }

    /**
     * @param string $subject
     * @param bool $valid
     * @dataProvider providesMacAddress
     */
    public function testMacAddress($subject, $valid)
    {
        $v = new Validator();
        $v->key('subject')->isMacAddress();
        $result = $v->validate(array('subject' => $subject));
        $this->assertEquals($valid, $result->valid());
    }

    /**
     * @return array
     */
    public function providesMacAddress()
    {
        return array(
            array('00:a0:c9:14:c8:29', true),
            array('00:A0:C9:14:C8:29', true),
            array('00-1C-b3-09-85-15', true),
            array('00-1C-B3-09-85-15', true),
            array('00:a0:c9:14:c8', false),
            array('2001:0db8:85a3:08d3:1319:8a2e', false),
        );
    }

    /**
     * @param mixed $subject
     * @param bool $valid
     * @dataProvider providesNotBlank
     */
    public function testNotBlank($subject, $valid)
    {
        $v = new Validator();
        $v->key('subject')->isNotBlank();
        $result = $v->validate(array('subject' => $subject));
        $this->assertEquals($valid, $result->valid());
    }

    /**
     * @return array
     */
    public function providesNotBlank()
    {
        return array(
            array(0, true),
            array('0', true),
            array('one', true),
            array(array('one'), true),
            array('', false),
            array(array(), false),
        );
    }

    /**
     * @param mixed $lhs
     * @param mixed $rhs
     * @param bool $valid
     * @dataProvider providesNotEqualsTo
     */
    public function testNotEqualsTo($lhs, $rhs, $valid)
    {
        $v = new Validator();
        $v->key('subject')->isNotEqualTo($rhs);
        $result = $v->validate(array('subject' => $lhs));
        $this->assertEquals($valid, $result->valid());
    }

    /**
     * @return array
     */
    public function providesNotEqualsTo()
    {
        return array(
            array(true, '0', true),
            array(1, 2, true),
            array(true, '1', false),
            array(1, '1', false),
        );
    }

    /**
     * @param mixed $lhs
     * @param mixed $rhs
     * @param bool $valid
     * @dataProvider providesNotSameAs
     */
    public function testNotSameAs($lhs, $rhs, $valid)
    {
        $v = new Validator();
        $v->key('subject')->isNotSameAs($rhs);
        $result = $v->validate(array('subject' => $lhs));
        $this->assertEquals($valid, $result->valid());
    }

    /**
     * @return array
     */
    public function providesNotSameAs()
    {
        return array(
            array(new \stdClass(), new \stdClass(), true),
            array(true, 'true', true),
            array(1, '1', true),
            array(true, true, false),
            array(1, 1, false),
        );
    }

    /**
     * @param mixed $subject
     * @param bool $valid
     * @dataProvider providesNumber
     */
    public function testNumber($subject, $valid)
    {
        $v = new Validator();
        $v->key('subject')->isNumber();
        $result = $v->validate(array('subject' => $subject));
        $this->assertEquals($valid, $result->valid());
    }

    /**
     * @return array
     */
    public function providesNumber()
    {
        return array(
            array('10', true),
            array(1, true),
            array(0x1, true),
            array('VPZ', false),
            array(false, false),
        );
    }

    /**
     * @param mixed $needle
     * @param array $haystack
     * @param bool $valid
     * @dataProvider providesOneOf
     */
    public function testOneOf($needle, array $haystack, $valid)
    {
        $v = new Validator();
        $v->key('subject')->isOneOf($haystack);
        $result = $v->validate(array('subject' => $needle));
        $this->assertEquals($valid, $result->valid());
    }

    /**
     * @return array
     */
    public function providesOneOf()
    {
        return array(
            array('one', array('one', 'two', 'three'), true),
            array('four', array('one', 'two', 'three'), false),
        );
    }

    /**
     * @param int $subject
     * @param int $min
     * @param int $max
     * @param bool $valid
     * @dataProvider providesRange
     */
    public function testRange($subject, $min, $max, $valid)
    {
        $v = new Validator();
        $v->key('subject')->isInRange($min, $max);
        $result = $v->validate(array('subject' => $subject));
        $this->assertEquals($valid, $result->valid());
    }

    /**
     * @return array
     */
    public function providesRange()
    {
        return array(
            array(999, 99, 999, true),
            array(69, 99, 999, false),
        );
    }

    /**
     * @param string $subject
     * @param string $regexp
     * @param bool $valid
     * @dataProvider providesRegExp
     */
    public function testRegExp($subject, $regexp, $valid)
    {
        $v = new Validator();
        $v->key('subject')->isMatchingWith($regexp);
        $result = $v->validate(array('subject' => $subject));
        $this->assertEquals($valid, $result->valid());
    }

    /**
     * @return array
     */
    public function providesRegExp()
    {
        return array(
            array('/user/12/posts', '~^/user/(\d+)/posts$~', true),
        );
    }

    /**
     * @param mixed $lhs
     * @param mixed $rhs
     * @param bool $valid
     * @dataProvider providesSameAs
     */
    public function testSameAs($lhs, $rhs, $valid)
    {
        $v = new Validator();
        $v->key('subject')->isSameAs($rhs);
        $result = $v->validate(array('subject' => $lhs));
        $this->assertEquals($valid, $result->valid());
    }

    /**
     * @return array
     */
    public function providesSameAs()
    {
        return array(
            array(true, true, true),
            array(1, 1, true),
            array(true, 'true', false),
            array(1, '1', false),
        );
    }

    /**
     * @param mixed $subject
     * @param string $type
     * @param bool $valid
     * @dataProvider providesType
     */
    public function testType($subject, $type, $valid)
    {
        $v = new Validator();
        $v->key('subject')->isOfType($type);
        $result = $v->validate(array('subject' => $subject));
        $this->assertEquals($valid, $result->valid());
    }

    /**
     * @return array
     */
    public function providesType()
    {
        return array(
            array('vaibhav', 'string', true),
            array(true, 'boolean', true),
            array(999, 'integer', true),
            array(9.9, 'double', true),
            array(array('vpz'), 'array', true),
            array('vaibhav', 'boolean', false),
            array(true, 'integer', false),
            array(999, 'double', false),
            array(9.9, 'array', false),
            array(array('vpz'), 'string', false),
        );
    }

    /**
     * @param mixed $subject
     * @param bool $valid
     * @dataProvider providesUrl
     */
    public function testUrl($subject, $valid)
    {
        $v = new Validator();
        $v->key('subject')->isUrl();
        $result = $v->validate(array('subject' => $subject));
        $this->assertEquals($valid, $result->valid());
    }

    /**
     * @return array
     */
    public function providesUrl()
    {
        return array(
            array('http://www.vaibhavpandey.com', true),
            array('https://github.com/vaibhapandeyvpz', true),
            array('/vaibhapandeyvpz?tab=repositories', false),
        );
    }
}

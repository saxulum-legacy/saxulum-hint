<?php

namespace Saxulum\Tests\Hint;

use Saxulum\Hint\Hint;

class HintTest extends \PHPUnit_Framework_TestCase
{
    public function testValidateBool()
    {
        $this->assertTrue(Hint::validateBool(false));
        $this->assertTrue(Hint::validateBool(null));
        $this->assertFalse(Hint::validateBool(1));
        $this->assertFalse(Hint::validateBool(null, false));
    }

    public function testValidateInt()
    {
        $this->assertTrue(Hint::validateInt(1));
        $this->assertTrue(Hint::validateInt(null));
        $this->assertFalse(Hint::validateInt(1.0));
        $this->assertFalse(Hint::validateInt(null, false));
    }

    public function testValidateFloat()
    {
        $this->assertTrue(Hint::validateFloat(1.0));
        $this->assertTrue(Hint::validateFloat(null));
        $this->assertFalse(Hint::validateFloat(1));
        $this->assertFalse(Hint::validateFloat(null, false));
    }

    public function testValidateNumeric()
    {
        $this->assertTrue(Hint::validateNumeric(1));
        $this->assertTrue(Hint::validateNumeric(1.0));
        $this->assertTrue(Hint::validateNumeric('1.0'));
        $this->assertTrue(Hint::validateNumeric(null));
        $this->assertFalse(Hint::validateNumeric(null, false));
    }

    public function testValidateString()
    {
        $this->assertTrue(Hint::validateString('test'));
        $this->assertTrue(Hint::validateString(null));
        $this->assertFalse(Hint::validateString(1));
        $this->assertFalse(Hint::validateString(null, false));
    }

    public function testValidateArray()
    {
        $this->assertTrue(Hint::validateArray(array()));
        $this->assertTrue(Hint::validateArray(null, true));
        $this->assertFalse(Hint::validateArray('test'));
        $this->assertFalse(Hint::validateArray(null));
    }

    public function testValidateObject()
    {
        $this->assertTrue(Hint::validateObject(new \stdClass(), '\stdClass'));
        $this->assertTrue(Hint::validateObject(null, '\stdClass', true));
        $this->assertFalse(Hint::validateObject('test', '\stdClass', true));
        $this->assertFalse(Hint::validateObject(null, '\stdClass'));
    }

    public function testValidate()
    {
        // bool
        $this->assertTrue(Hint::validate(false));
        $this->assertTrue(Hint::validate(false, Hint::BOOL));
        $this->assertTrue(Hint::validate(null, Hint::BOOL));
        $this->assertFalse(Hint::validate(1, Hint::BOOL));
        $this->assertFalse(Hint::validate(null, Hint::BOOL, false));

        // int
        $this->assertTrue(Hint::validate(1));
        $this->assertTrue(Hint::validate(1, Hint::INT));
        $this->assertTrue(Hint::validate(null, Hint::INT));
        $this->assertFalse(Hint::validate(1.0, Hint::INT));
        $this->assertFalse(Hint::validate(null, Hint::INT, false));

        // float
        $this->assertTrue(Hint::validate(1.0));
        $this->assertTrue(Hint::validate(1.0, Hint::FLOAT));
        $this->assertTrue(Hint::validate(null, Hint::FLOAT));
        $this->assertFalse(Hint::validate(1, Hint::FLOAT));
        $this->assertFalse(Hint::validate(null, Hint::FLOAT, false));

        // numeric
        $this->assertTrue(Hint::validate(1.0));
        $this->assertTrue(Hint::validate(1.0, Hint::NUMERIC));
        $this->assertTrue(Hint::validate(null, Hint::NUMERIC));
        $this->assertFalse(Hint::validate('test', Hint::NUMERIC));
        $this->assertFalse(Hint::validate(null, Hint::NUMERIC, false));

        // string
        $this->assertTrue(Hint::validate('test'));
        $this->assertTrue(Hint::validate('test', Hint::STRING));
        $this->assertTrue(Hint::validate(null, Hint::STRING));
        $this->assertFalse(Hint::validate(1, Hint::STRING));
        $this->assertFalse(Hint::validate(null, Hint::STRING, false));

        // array
        $this->assertTrue(Hint::validate(array()));
        $this->assertTrue(Hint::validate(array(), Hint::ARR));
        $this->assertTrue(Hint::validate(null, Hint::ARR, true));
        $this->assertFalse(Hint::validate('test', Hint::ARR));
        $this->assertFalse(Hint::validate(null, Hint::ARR));

        // object
        $this->assertTrue(Hint::validate(new \stdClass()));
        $this->assertTrue(Hint::validate(new \stdClass(), '\stdClass'));
        $this->assertTrue(Hint::validate(null, '\stdClass', true));
        $this->assertFalse(Hint::validate('test', '\stdClass'));
        $this->assertFalse(Hint::validate(null, '\stdClass'));

        // many objects
        $this->assertTrue(Hint::validate(array(new \stdClass()), '\stdClass[]'));
        $this->assertTrue(Hint::validate(array(new \stdClass(), new \stdClass()), '\stdClass[]'));
        $this->assertTrue(Hint::validate(array(new \stdClass(), null), '\stdClass[]', true));
        $this->assertFalse(Hint::validate(array(new \stdClass(), null, 'test'), '\stdClass[]', true));
    }
}

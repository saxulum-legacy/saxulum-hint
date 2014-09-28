<?php

namespace Saxulum\Hint;

class Hint
{
    const BOOL = 'bool';
    const INT = 'int';
    const FLOAT = 'float';
    const NUMERIC = 'numeric';
    const STRING = 'string';
    const ARR = 'array';

    /**
     * @param  string      $varname
     * @param  mixed       $value
     * @param  string|null $hint
     * @param  bool|null   $nullable
     * @throws \Exception
     */
    public static function validateOrException($varname, $value, $hint = null, $nullable = null)
    {
        if (!self::validate($value, $hint, $nullable)) {
            $type = gettype($value);
            throw new \Exception("Invalid type '{$type}' for hint '{$hint}' on property '{$varname}'!");
        }
    }

    /**
     * @param  mixed       $value
     * @param  string|null $hint
     * @param  bool|null   $nullable
     * @return bool
     */
    public static function validate($value, $hint = null, $nullable = null)
    {
        if (null === $hint) {
            return true;
        }

        $isIteratableHint = self::isIteratableHint($hint);
        $hint = self::getHint($hint);

        if (!$isIteratableHint || !self::isIteratableValue($value)) {
            return self::validateOne($value, $hint, $nullable);
        }

        return self::validateMany($value, $hint, $nullable);
    }

    /**
     * @param  string $hint
     * @return bool
     */
    protected static function isIteratableHint($hint)
    {
        return substr($hint, -2) === '[]';
    }

    /**
     * @param  string $hint
     * @return string
     */
    protected static function getHint($hint)
    {
        if (self::isIteratableHint($hint)) {
            return substr($hint, 0, -2);
        }

        return $hint;
    }

    /**
     * @param  mixed $value
     * @return bool
     */
    protected static function isIteratableValue($value)
    {
        return is_array($value) || $value instanceof \Traversable;
    }

    /**
     * @param  mixed     $value
     * @param  string    $hint
     * @param  bool|null $nullable
     * @return bool
     */
    protected static function validateOne($value, $hint, $nullable)
    {
        $method = 'validate' . ucfirst($hint);

        if (method_exists(__CLASS__, $method)) {
            return self::$method($value, $nullable);
        }

        return self::validateObject($value, $hint, $nullable);
    }

    /**
     * @param  mixed     $value
     * @param  string    $hint
     * @param  bool|null $nullable
     * @return bool
     */
    protected static function validateMany($value, $hint, $nullable)
    {
        foreach ($value as $element) {
            if (!self::validateOne($element, $hint, $nullable)) {
                return false;
            }
        }

        return true;
    }

    /**
     * @param  mixed     $value
     * @param  bool|null $nullable
     * @return bool
     */
    public static function validateBool($value, $nullable = null)
    {
        return self::validateByCallable(
            'is_bool',
            $value,
            self::isNullableScalar($nullable)
        );
    }

    /**
     * @param  mixed     $value
     * @param  bool|null $nullable
     * @return bool
     */
    public static function validateInt($value, $nullable = null)
    {
        return self::validateByCallable(
            'is_int',
            $value,
            self::isNullableScalar($nullable)
        );
    }

    /**
     * @param  mixed     $value
     * @param  bool|null $nullable
     * @return bool
     */
    public static function validateFloat($value, $nullable = null)
    {
        return self::validateByCallable(
            'is_float',
            $value,
            self::isNullableScalar($nullable)
        );
    }

    /**
     * @param  mixed     $value
     * @param  bool|null $nullable
     * @return bool
     */
    public static function validateNumeric($value, $nullable = null)
    {
        return self::validateByCallable(
            'is_numeric',
            $value,
            self::isNullableScalar($nullable)
        );
    }

    /**
     * @param  mixed     $value
     * @param  bool|null $nullable
     * @return bool
     */
    public static function validateString($value, $nullable = null)
    {
        return self::validateByCallable(
            'is_string',
            $value,
            self::isNullableScalar($nullable)
        );
    }

    /**
     * @param  mixed     $value
     * @param  bool|null $nullable
     * @return bool
     */
    public static function validateArray($value, $nullable = null)
    {
        return self::validateByCallable(
            'is_array',
            $value,
            self::isNullableArrayOrObject($nullable)
        );
    }

    /**
     * @param  mixed     $value
     * @param  string    $hint
     * @param  bool|null $nullable
     * @return bool
     */
    public static function validateObject($value, $hint, $nullable = null)
    {
        return self::validateByCallable(
            function () use ($value, $hint) {
                return is_object($value) && is_a($value, $hint);
            },
            $value,
            self::isNullableArrayOrObject($nullable)
        );
    }

    /**
     * @param  bool|null $nullable
     * @return bool
     */
    protected static function isNullableScalar($nullable = null)
    {
        return null === $nullable || true === $nullable;
    }

    /**
     * @param  bool|null $nullable
     * @return bool
     */
    protected static function isNullableArrayOrObject($nullable = null)
    {
        return true === $nullable;
    }

    /**
     * @param  callable  $method
     * @param  string    $value
     * @param  bool|null $nullable
     * @return bool
     */
    protected static function validateByCallable($method, $value, $nullable)
    {
        if (null === $value && true === $nullable) {
            return true;
        }

        return $method($value);
    }
}

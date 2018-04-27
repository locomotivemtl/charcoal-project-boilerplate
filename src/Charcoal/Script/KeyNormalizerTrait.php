<?php

namespace Charcoal\Script;

/**
 * Provides string-manipulation helpers.
 */
trait KeyNormalizerTrait
{
    /**
     * The cache of snake-cased words.
     *
     * @var array
     */
    protected static $snakeCache = [];

    /**
     * The cache of camel-cased words.
     *
     * @var array
     */
    protected static $camelCache = [];

    /**
     * The cache of studly-cased words.
     *
     * @var array
     */
    protected static $studlyCache = [];

    /**
     * Convert a value to studly caps case.
     *
     * @param  string $value The value to convert.
     * @return string
     */
    public static function studly($value)
    {
        $key = $value;

        if (isset(static::$studlyCache[$key])) {
            return static::$studlyCache[$key];
        }

        $value = ucwords(str_replace(['-', '_'], ' ', $value));
        $value = str_replace(' ', '', $value);

        static::$studlyCache[$key] = $value;
        return $value;
    }

    /**
     * Convert a value to camel case.
     *
     * @param string $value The value to convert.
     * @return string
     */
    public static function camel($value)
    {
        $key = $value;

        if (isset(static::$camelCache[$key])) {
            return static::$camelCache[$key];
        }

        $value = lcfirst(static::studly($value));

        static::$camelCache[$key] = $value;
        return $value;
    }

    /**
     * Convert a string to snake case.
     *
     * @param  string $value     The value to convert.
     * @param  string $delimiter The word delimiter.
     * @return string
     */
    public static function snake($value, $delimiter = '-')
    {
        $key = $value;

        if (isset(static::$snakeCache[$key][$delimiter])) {
            return static::$snakeCache[$key][$delimiter];
        }

        if (!ctype_lower($value)) {
            $value = preg_replace('/\s+/u', '', $value);
            $value = mb_strtolower(preg_replace('/(.)(?=[A-Z])/u', '$1'.$delimiter, $value), 'UTF-8');
        }

        static::$snakeCache[$key][$delimiter] = $value;
        return $value;
    }
}

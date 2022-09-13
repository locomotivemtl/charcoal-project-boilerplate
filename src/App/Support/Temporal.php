<?php

namespace App\Support;

/**
 * Date/time utility functions and constants.
 */
class Temporal
{
    /** @const string e.g., "2017-09-29" */
    public const SQL_DATE_FORMAT = 'Y-m-d';

    /** @const string e.g., "00:00:00" */
    public const SQL_TIME_FORMAT = 'H:i:s';

    /** @const string e.g., "2017-09-29 00:00:00" */
    public const SQL_DATETIME_FORMAT = self::SQL_DATE_FORMAT . ' ' . self::SQL_TIME_FORMAT;

    /**
     * This class should not be instantiated.
     */
    private function __construct()
    {
    }
}

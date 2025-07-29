<?php

namespace App\Traits;

trait ProvidesEnumValues
{
    /**
     * Get all the values for the given enum.
     *
     * @return string[]
     */
    public static function getValues(): array
    {
        return array_column(self::cases(), 'value');
    }

    /**
     * Get all the values for the given enum as key value pairs.
     *
     * @return string[]
     */
    public static function getValuesAsKeyValuePairs(): array
    {
        return array_combine(self::getValues(), self::getValues());
    }
}

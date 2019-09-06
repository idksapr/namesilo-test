<?php

namespace App\Utils;

use InvalidArgumentException;

class ObjectArrays
{
    public static function filterEqualOne(array $items, string $fieldName, $value)
    {
        $values = self::filterEqual($items, $fieldName, $value);
        return !empty($values) ? $values[0] : null;
    }

    public static function filterEqual(array $items, string $fieldName, $value): array
    {
        self::validateObjectField($items, $fieldName);

        return self::filter($items, function ($item) use ($fieldName, $value) {
            return $item->$fieldName == $value;
        });
    }

    public static function filter(array $items, \Closure $filter)
    {
        $result = [];
        foreach ($items as $item) {
            if ($filter($item)) {
                $result[] = $item;
            }
        }
        return $result;
    }

    /**
     * Create array of entity field values
     *
     * @param array  $items
     * @param string $fieldName
     * @param bool   $unique
     * @return array
     */
    public static function createFieldArray(array $items, string $fieldName, bool $unique = false): array
    {
        self::validateObjectField($items, $fieldName);

        $fields = array_map(function ($i) use ($fieldName) {
            return $i->$fieldName;
        }, $items);

        return $unique ? array_unique($fields) : $fields;
    }

    /**
     * @param object[] $items
     * @param string   $fieldName
     */
    private static function validateObjectField(array $items, string $fieldName): void
    {
        $first = reset($items);
        if ($first !== false && !property_exists($first, $fieldName)) {
            throw new InvalidArgumentException("Object does not have field: $fieldName");
        }
    }
}

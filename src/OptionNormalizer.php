<?php

namespace Tenthfeet\SelectOptions;

use Generator;

class OptionNormalizer
{
    /**
     * Lazily normalize iterable data to ['id' => ..., 'text' => ...]
     *
     * @param iterable $data
     * @param string|callable $textKey
     * @param string|callable|null $valueKey
     * @return Generator
     */
    public static function normalize(
        iterable $data,
        string|callable $textKey = 'text',
        string|callable|null $valueKey = null
    ): Generator {

        foreach ($data as $key => $val) {
            // Scalar key/value
            if (is_scalar($val)) {
                yield ['id' => (string)$key, 'text' => (string)$val];
                continue;
            }

            // Array
            if (is_array($val)) {
                $id = (string) ($valueKey !== null
                    ? (is_callable($valueKey) ? $valueKey((object)$val, $key) : ($val[$valueKey] ?? $key))
                    : ($val['id'] ?? $key));

                $text = is_callable($textKey)
                    ? (string) $textKey((object)$val, $id)
                    : (string) ($val[$textKey] ?? $val['text'] ?? $id);

                yield ['id' => $id, 'text' => $text];
                continue;
            }

            // Object/Model
            if (is_object($val)) {
                $id = (string) ($valueKey !== null
                    ? (is_callable($valueKey) ? $valueKey($val, $key) : ($val->$valueKey ?? $key))
                    : ($val->id ?? $key));

                $text = is_callable($textKey)
                    ? (string) $textKey($val, $id)
                    : (string) ($val->$textKey ?? $val->name ?? $val->title ?? $id);

                yield ['id' => $id, 'text' => $text];
            }
        }
    }
}

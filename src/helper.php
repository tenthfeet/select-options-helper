<?php

use Tenthfeet\SelectOptions\OptionNormalizer;

if (! function_exists('e')) {
    function e(mixed $value, bool $doubleEncode = true): string
    {
        return htmlspecialchars((string) ($value ?? ''), ENT_QUOTES, 'UTF-8', $doubleEncode);
    }
}


if (! function_exists('generate_options')) {

    function generate_options(
        iterable $data,
        string|array $selected = [],
        string $placeholder = '',
        bool $readonly = false,
        string|callable $textKey = 'text',
        string|callable|null $valueKey = null
    ): string {
        $options = '';

        if ($placeholder !== '') {
            $safePlaceholder = e($placeholder);
            $disabledAttribute = $readonly ? ' disabled' : '';
            $options .= "<option value=\"\"$disabledAttribute>$safePlaceholder</option>";
        }

        $selected = is_array($selected) ? array_map('strval', $selected) : [$selected];

        foreach (OptionNormalizer::normalize($data, $textKey, $valueKey) as $item) {
            $id = e($item['id']);
            $text = e($item['text']);
            $isSelected = in_array($item['id'], $selected, true) ? ' selected' : '';

            $options .= "<option value=\"$id\"$isSelected>$text</option>";
        }

        return $options;
    }
}

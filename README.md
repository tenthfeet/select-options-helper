
# Select Options Helper

Flexible and reusable PHP helper to generate HTML <option> elements from arrays, collections, or models. Works in Laravel and plain PHP.


## Features

- Accepts **arrays, collections, objects, and models**.
- Supports **callables** for customizing option text and value.
- Lazy normalization for **memory-efficient** iteration.
- Optional **Laravel integration**: Blade directives, collection macros, and config defaults.
- Framework-agnostic — works outside Laravel too.


## Installation

Via Composer:

```bash
    composer require tenthfeet/select-options-helper
```
    
## Usage/Examples

**Signature:**

```php
    generate_options(
        iterable $data,
        array $selected = [],
        string $placeholder = '',
        bool $readonly = false,
        string|callable $textKey = 'text',
        string|callable|null $valueKey = null
    ): string
```

**Parameters:**

- `$data` – Array, collection, or objects/models.
- `$selected` – Array of values to mark selected.
- `$placeholder` – Optional placeholder text for `<option value="">`.
- `$readonly` – Whether to disable the placeholder option.

- `$textKey` – Property name or callable to generate option text.

- `$valueKey` – Property name or callable to override option value.

**Plain PHP:**

```php

// Simple key/value array
echo generate_options(['1' => 'One', '2' => 'Two'], ['2'], 'Select an option');

// Array of id/text
$data = [
    ['id' => 1, 'text' => 'Option 1'],
    ['id' => 2, 'text' => 'Option 2']
];
echo generate_options($data, [1]);

// Object/Model array
$users = [
    (object) ['id' => 1, 'first_name' => 'John', 'last_name' => 'Doe'],
    (object) ['id' => 2, 'first_name' => 'Jane', 'last_name' => 'Smith']
];
echo generate_options($users, [], 'Choose user', false, fn($u) => "{$u->first_name} {$u->last_name}");
```

**Laravel**

```blade
<select>
    @options($users, [1,2], 'Choose user')
</select>

```
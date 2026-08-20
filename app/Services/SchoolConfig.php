<?php

namespace App\Services;

class SchoolConfig
{
    protected array $data;

    protected function __construct(array $data)
    {
        $this->data = $data;
    }

    /**
     * Load, validate, and wrap a school's config JSON file.
     * Throws an exception with a clear message if the file is missing or invalid.
     */
    public static function load(string $schoolCode): self
    {
        $path = storage_path("app/schools/{$schoolCode}.json");

        if (!file_exists($path)) {
            throw new \Exception("No config found for school code {$schoolCode}");
        }

        $json = file_get_contents($path);
        $data = json_decode($json, true);

        if (json_last_error() !== JSON_ERROR_NONE) {
            throw new \Exception("Config for {$schoolCode} is not valid JSON: " . json_last_error_msg());
        }

        static::validate($schoolCode, $data);

        return new self($data);
    }

    /**
     * Validate the structure and business rules of a config array.
     * Throws with a specific, human-readable reason on failure.
     */
    protected static function validate(string $schoolCode, array $data): void
    {
        // 1. Required top-level keys
        foreach (['school_name', 'school_code', 'language', 'field_visibility', 'field_options'] as $key) {
            if (!array_key_exists($key, $data)) {
                throw new \Exception("Config for {$schoolCode} is missing required key: {$key}");
            }
        }

        // 2. Types
        if (!is_string($data['language']) || !in_array($data['language'], ['en', 'mr'], true)) {
            throw new \Exception("Config for {$schoolCode}: language must be 'en' or 'mr'");
        }

        if (!is_array($data['field_visibility'])) {
            throw new \Exception("Config for {$schoolCode}: field_visibility must be an object");
        }

        if (!is_array($data['field_options'])) {
            throw new \Exception("Config for {$schoolCode}: field_options must be an object");
        }

        // 3. Dropdown options must not be empty
        foreach (['standard', 'division'] as $field) {
            if (empty($data['field_options'][$field] ?? [])) {
                throw new \Exception("Config for {$schoolCode}: field_options.{$field} must not be empty");
            }
        }

        // 4a. first_name and last_name are always mandatory
        if (empty($data['field_visibility']['first_name']) || empty($data['field_visibility']['last_name'])) {
            throw new \Exception("Config for {$schoolCode}: first_name and last_name must both be true");
        }

        // 4b. photo_capture requires roll_no
        if (!empty($data['field_visibility']['photo_capture']) && empty($data['field_visibility']['roll_no'])) {
            throw new \Exception("Config for {$schoolCode}: photo_capture is true but roll_no is false — not allowed");
        }
    }

    /**
     * Maps config field names to actual Student model column names.
     * Any field not listed here is assumed to already match the column name.
     */
    protected static array $columnMap = [
        'erp_id' => 'erpid',
        'roll_no' => 'rollno',
        'first_name' => 'fname',
        'middle_name' => 'mname',
        'last_name' => 'lname',
        'standard' => 'class',
        'division' => 'div',
        'blood_group' => 'bloodgroup',
        'parent_name' => 'pname',
        'mobile_number' => 'pcontact',
        'address' => 'address1',
    ];

    public static function columnFor(string $configField): string
    {
        return static::$columnMap[$configField] ?? $configField;
    }

    public function isVisible(string $field): bool
    {
        return (bool) ($this->data['field_visibility'][$field] ?? false);
    }

    public function visibleFields(): array
    {
        return array_keys(array_filter($this->data['field_visibility']));
    }

    public function options(string $field): array
    {
        return $this->data['field_options'][$field] ?? [];
    }

    public function language(): string
    {
        return $this->data['language'];
    }

    public function schoolName(): string
    {
        return $this->data['school_name'];
    }

    public function schoolCode(): string
    {
        return $this->data['school_code'];
    }
}
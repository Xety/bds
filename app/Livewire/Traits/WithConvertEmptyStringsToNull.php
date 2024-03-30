<?php

namespace BDS\Livewire\Traits;

trait WithConvertEmptyStringsToNull
{
    /**
     * A list of fields to exclude from conversion to null.
     *
     * @var array
     */
    protected $convertEmptyStringsExcept = [
        //
    ];

    /**
     * A list of value to exclude from conversion to null.
     *
     * @var array
     */
    protected $excludeTrimAndNullValues = [
        '__rm__'
    ];

    /**
     * Convert empty string into null in Form.
     *
     * @param string $name
     * @param mixed $value
     */
    public function updatedForm(mixed $name, mixed $value): void
    {
        if (! is_string($value) || in_array($name, $this->convertEmptyStringsExcept) || in_array($value, $this->excludeTrimAndNullValues)) {
            return;
        }

        $value = trim($value);
        $value = $value === '' ? null : $value;

        data_set($this->form, $name, $value);
    }
}

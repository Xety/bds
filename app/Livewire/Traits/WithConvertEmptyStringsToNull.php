<?php

namespace BDS\Livewire\Traits;

trait WithConvertEmptyStringsToNull
{
    /**
     * A list of fields to exclude from conversion to null.
     * @var string[]
     */
    protected $convertEmptyStringsExcept = [
        //
    ];

    /**
     * Convert empty string into null in Form.
     *
     * @param mixed $value
     * @param string $name
     */
    public function updatedForm(mixed $value, string $name): void
    {
        if (! is_string($value) || in_array($name, $this->convertEmptyStringsExcept)) {
            return;
        }

        $value = trim($value);
        $value = $value === '' ? null : $value;

        data_set($this->form, $name, $value);
    }
}

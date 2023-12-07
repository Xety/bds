<?php

namespace BDS\Livewire\Forms;

use BDS\Models\Part;
use Illuminate\Validation\Rule;
use Livewire\Form;

class PartForm extends Form
{
    public ?Part $part = null;

    public ?string $name = null;

    /**
     *  What ever the warning is enabled or not. Used to show/hide the related count field.
     *
     * @var boolean
     */
    public bool $numberWarningEnabled = false;

    /**
     *  What ever the critical warning is enabled or not. Used to show/hide the related count field.
     *
     * @var boolean
     */
    public bool $numberCriticalEnabled = false;

    /**
     * Rules used for validating the model.
     *
     * @return array
     */
    public function rules(): array
    {
        return [
            'name'  => [
                "required",
                "min:2",
           ]
        ];
    }

    /**
     * Translated attribute used in failed messages.
     *
     * @return array
     */
    public function validationAttributes(): array
    {
        return [
            'name' => 'nom',
        ];
    }

    public function setPart(Part $part): void
    {
        $this->fill([
            'part' => $part,
            'name' => $part->name,
        ]);
    }

    /**
     *
     * Function to store the model.
     *
     * @return Part
     */
    public function store(): Part
    {
        return Part::create($this->only([
            'name',
        ]));
    }

    /**
     * Function to update the model.
     *
     * @return Part
     */
    public function update(): Part
    {
        return tap($this->part)->update($this->only([
            'name',
        ]));
    }
}

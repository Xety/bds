<?php

namespace BDS\Livewire\Forms;

use BDS\Models\Part;
use Illuminate\Validation\Rule;
use Livewire\Form;

class PartForm extends Form
{
    public ?Part $part = null;

    public ?string $name = null;

    public ?string $description = null;

    public ?string $reference = null;

    public array $materials = [];

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
                Rule::unique('parts')->ignore($this->part?->id)->where(fn ($query) => $query->where('site_id', getPermissionsTeamId()))
            ],
            'description' => 'required|min:3',
            'reference' => [
                'min:2',
                'max:30',
                Rule::unique('parts')->ignore($this->part?->id)->where(fn ($query) => $query->where('site_id', getPermissionsTeamId()))
            ],
            'supplier_id' => 'present|numeric|exists:suppliers,id|nullable',
            'price' => 'float',
            'number_warning_enabled' => 'required|boolean',
            'number_warning_minimum' => 'exclude_if:model.number_warning_enabled,false|required|numeric',
            'number_critical_enabled' => 'required|boolean',
            'number_critical_minimum' => 'exclude_if:model.number_critical_enabled,false|required|numeric',
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
            'reference' => 'référence',
            'supplier_id' => 'fournisseur',
            'price' => 'prix',
            'number_warning_enabled' => 'alerte de stock',
            'number_warning_minimum' => 'quantité pour l\'alerte',
            'number_critical_enabled' => 'alerte de stock critique',
            'number_critical_minimum' => 'quantité pour l\'alerte critique',
        ];
    }

    public function setPart(Part $part, array $materials): void
    {
        $this->fill([
            'part' => $part,
            'materials' => $materials,
            'name' => $part->name,
            'supplier_id' => $part->supplier_id,
            'price' => $part->price,
            'number_warning_enabled' => $part->number_warning_enabled,
            'number_warning_minimum' => $part->number_warning_minimum,
            'number_critical_enabled' => $part->number_critical_enabled,
            'number_critical_minimum' => $part->number_critical_minimum
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
        $part = Part::create($this->only([
            'name'
        ]));

        $part->materials()->sync($this->materials);

        return $part;
    }

    /**
     * Function to update the model.
     *
     * @return Part
     */
    public function update(): Part
    {
        $part = tap($this->part)->update($this->only([
            'name',
        ]));

        $part->materials()->sync($this->materials);

        return $part;
    }
}

<?php

namespace BDS\Livewire\Forms;

use BDS\Models\Cleaning;
use BDS\Models\Material;
use BDS\Models\Supplier;
use Illuminate\Validation\Rule;
use Livewire\Form;

class SupplierForm extends Form
{
    public ?Supplier $supplier;

    public ?string $name = null;

    public ?string $description = null;

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
                "min:1",
                "max:150",
                Rule::unique('suppliers')->where(fn ($query) => $query->where('site_id', getPermissionsTeamId())),
            ],
            'description' => 'nullable',
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
            'description' => 'description'
        ];
    }

    /**
     * Set the model and all his fields.
     *
     * @param Supplier $supplier
     *
     * @return void
     */
    public function setSupplier(Supplier $supplier): void
    {
        $this->fill([
            'supplier' => $supplier,
            'name' => $supplier->name,
            'description' => $supplier->description
        ]);
    }

    /**
     * Function to store the model.
     *
     * @return Supplier
     */
    public function store(): Supplier
    {
        return Supplier::create($this->only([
            'name',
            'description'
        ]));
    }

    /**
     * Function to update the model and return it after.
     *
     * @return Supplier
     */
    public function update(): Supplier
    {
        return tap($this->supplier)->update($this->only([
            'name',
            'description'
        ]));
    }
}

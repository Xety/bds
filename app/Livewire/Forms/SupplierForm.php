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
        $supplier = Supplier::create($this->only([
            'name',
            'description'
        ]));

        // Log Activity
        if (settings('activity_log_enabled', true)) {
            activity()
                ->performedOn($supplier)
                ->event('created')
                ->withProperties(['attributes' => $supplier->toArray()])
                ->log('L\'utilisateur :causer.full_name à créé le fournisseur :subject.name.');
        }

        return $supplier;
    }

    /**
     * Function to update the model and return it after.
     *
     * @return Supplier
     */
    public function update(): Supplier
    {
        // Get the old data before tap it.
        $activityLog['old'] = $this->supplier->toArray();

        $supplier = tap($this->supplier)->update($this->only([
            'name',
            'description'
        ]));

        // Log Activity
        if (settings('activity_log_enabled', true)) {
            activity()
                ->performedOn($supplier)
                ->event('updated')
                ->withProperties(['old' => $activityLog['old'], 'attributes' => $supplier->toArray()])
                ->log('L\'utilisateur :causer.full_name à mis à jour le fournisseur :subject.name.');
        }

        return $supplier;
    }
}

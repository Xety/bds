<?php

namespace BDS\Livewire\Forms;

use BDS\Models\PartEntry;
use Livewire\Form;
use BDS\Models\Permission;

class PartEntryForm extends Form
{
    public ?PartEntry $partEntry = null;

    public ?int $part_id = null;

    public ?string $number = null;

    public ?int $order_id = null;

    /**
     * Rules used for validating the model.
     *
     * @return array
     */
    public function rules(): array
    {
        $rules = [
            'order_id' => 'nullable',
        ];

        if ($this->isCreating) {
            $rules = array_merge($rules, [
                'part_id' => 'required|numeric|exists:parts,id',
                'number' => 'required|numeric|min:0|max:1000000|not_in:0'
            ]);
        }
    }

    /**
     * Translated attribute used in failed messages.
     *
     * @return array
     */
    public function validationAttributes(): array
    {
        return [
            'part_id' => 'pièce détachée',
            'number' => 'nombre de pièce',
            'order_id' => 'N° de commande'
        ];
    }

    public function setPermission(Permission $permission): void
    {
        $this->fill([
            'permission' => $permission,
            'name' => $permission->name,
            'description' => $permission->description
        ]);
    }

    /**
     * Function to store the model.
     *
     * @return Permission
     */
    public function store(): Permission
    {
        return Permission::create($this->only([
            'name',
            'description'
        ]));
    }

    /**
     * Function to update the model.
     *
     * @return Permission
     */
    public function update(): Permission
    {
        return tap($this->permission)->update($this->only([
            'name',
            'description',
            'color',
            'level'
        ]));
    }
}

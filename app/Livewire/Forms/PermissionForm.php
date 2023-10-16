<?php

namespace BDS\Livewire\Forms;

use Livewire\Form;
use BDS\Models\Permission;

class PermissionForm extends Form
{
    public ?Permission $permission = null;

    public ?string $name = null;

    public ?string $description = null;

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

<?php

namespace BDS\Livewire\Forms;

use Livewire\Form;
use BDS\Models\Role;

class RoleForm extends Form
{
    public ?Role $role = null;

    public ?string $name = null;

    public ?string $description = null;

    public ?string $color = null;

    public ?int $level = null;

    public array $permissions = [];

    public function setRole(Role $role, array $permissions): void
    {
        $this->fill([
            'role' => $role,
            'name' => $role->name,
            'description' => $role->description,
            'color' => $role->color,
            'level' => $role->level,
            'permissions' => $permissions
        ]);
    }

    /**
     * Function to store the model.
     *
     * @return Role
     */
    public function store(): Role
    {
        $role = Role::create($this->only([
            'name',
            'description',
            'color',
            'level'
        ]));
        // Link the selected roles to the user in the current site.
        $role->syncPermissions($this->permissions);

        return $role;
    }

    /**
     * Function to update the model.
     *
     * @return Role
     */
    public function update(): Role
    {
        $role = tap($this->role)->update($this->only([
            'name',
            'description',
            'color',
            'level'
        ]));
        $role->syncPermissions($this->permissions);

        return $role;
    }
}

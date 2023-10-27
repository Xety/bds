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

    public ?int $site_id = null;

    public ?bool $site = false;

    public array $permissions = [];

    public function setRole(Role $role): void
    {
        $this->fill([
            'role' => $role,
            'name' => $role->name,
            'description' => $role->description,
            'color' => $role->color,
            'level' => $role->level,
            'site' => !is_null($role->site_id) ? true : false,
            // Set the related permissions of the role.
            'permissions' => $role->permissions()->pluck('id')->toArray(),
        ]);
    }

    /**
     * Function to store the model.
     *
     * @return Role
     */
    public function store(): Role
    {
        $this->fill([
            'site_id' => $this->site === true ? getPermissionsTeamId() : null,
        ]);

        $role = Role::create($this->only([
            'name',
            'description',
            'color',
            'level',
            'site_id'
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
        $this->fill([
            'site_id' => $this->site === true ? getPermissionsTeamId() : null,
        ]);

        $role = tap($this->role)->update($this->only([
            'name',
            'description',
            'color',
            'level',
            'site_id'
        ]));
        $role->syncPermissions($this->permissions);

        return $role;
    }
}

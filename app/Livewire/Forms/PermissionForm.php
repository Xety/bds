<?php

namespace BDS\Livewire\Forms;

use Livewire\Form;
use BDS\Models\Permission;

class PermissionForm extends Form
{
    public ?Permission $permission = null;

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
            'name' => 'required|min:5|max:30|unique:permissions,name,' . $this->permission?->id,
            'description' => 'required|min:5|max:150'
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
        $permission = Permission::create($this->only([
            'name',
            'description'
        ]));

        // Log Activity
        if (settings('activity_log_enabled', true)) {
            activity()
                ->performedOn($permission)
                ->event('created')
                ->withProperties(['attributes' => $permission->toArray()])
                ->log('L\'utilisateur :causer.full_name à créé la permission :subject.name.');
        }

        return $permission;
    }

    /**
     * Function to update the model.
     *
     * @return Permission
     */
    public function update(): Permission
    {
        // Get the old data before tap it.
        $activityLog['old'] = $this->permission->toArray();

        $permission = tap($this->permission)->update($this->only([
            'name',
            'description',
            'color',
            'level'
        ]));

        // Log Activity
        if (settings('activity_log_enabled', true)) {
            activity()
                ->performedOn($permission)
                ->event('updated')
                ->withProperties(['old' => $activityLog['old'], 'attributes' => $permission->toArray()])
                ->log('L\'utilisateur :causer.full_name à mis à jour la permission :subject.name.');
        }

        return $permission;
    }
}

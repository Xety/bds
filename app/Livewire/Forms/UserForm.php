<?php

namespace BDS\Livewire\Forms;

use BDS\Models\User;
use Livewire\Form;

class UserForm extends Form
{
    public ?User $user = null;

    public ?string $username = null;

    public ?string $first_name = null;

    public ?string $last_name = null;

    public ?string $email = null;

    public ?string $office_phone = null;

    public ?string $cell_phone = null;

    public ?string $end_employment_contract = null;

    public array $roles = [];

    public array $permissions = [];

    public ?int $current_site_id = null;

    /**
     * Rules used for validating the model.
     *
     * @return array
     */
    public function rules(): array
    {
        return [
            'username' => 'required|regex:/^[\w.]*$/|min:4|max:40|unique:users,username,' . $this->user?->id,
            'email' => 'required|email|unique:users,email,' . $this->user?->id,
            'first_name' => 'required|min:2|alpha_num',
            'last_name' => 'required|min:2|alpha_num',
            'end_employment_contract' => 'nullable|date_format:"d-m-Y H:i"'
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
            'username' => 'nom d\'utilisateur',
            'first_name' => 'prénom',
            'last_name' => 'nom',
            'email' => 'email',
            'office_phone' => 'téléphone bureau',
            'cell_phone' => 'téléphone portable',
            'roles' => 'rôles'
        ];
    }

    /**
     * Set the model and all his fields.
     *
     * @param User $user The user model.
     * @param array $roles All roles of the user.
     * @param array $permissions All permissions of the user.
     *
     * @return void
     */
    public function setUser(User $user, array $roles, array $permissions): void
    {
        $this->fill([
            'user' => $user,
            'roles' => $roles,
            'permissions' => $permissions,
            'username' => $user->username,
            'first_name' => $user->first_name,
            'last_name' => $user->last_name,
            'email' => $user->email,
            'office_phone' => $user->office_phone,
            'cell_phone' => $user->cell_phone,
            'end_employment_contract' => $user->end_employment_contract
        ]);
    }

    /**
     * Function to store the model.
     *
     * @return User
     */
    public function store(): User
    {
        // Set the current site id to the new user so he will log in to the right site the first time.
        $this->current_site_id = getPermissionsTeamId();

        $user = User::create($this->only([
            'username',
            'first_name',
            'last_name',
            'email',
            'office_phone',
            'cell_phone',
            'end_employment_contract',
            'current_site_id'
        ]));
        // Link the new user to the current site.
        $user->sites()->attach(session('current_site_id'));

        // Link the selected roles to the user in the current site.
        $user->syncRoles($this->roles);

        // Link the selected permissions to the user in the current site.
        if (auth()->user()->can('assignDirectPermission', User::class)) {
            $user->syncPermissions($this->permissions);
        }

        return $user;
    }

    /**
     * Function to update the model.
     *
     * @return User
     */
    public function update(): User
    {
        $user = tap($this->user)->update($this->only([
            'username',
            'first_name',
            'last_name',
            'email',
            'office_phone',
            'cell_phone',
            'end_employment_contract'
        ]));

        $user->syncRoles($this->roles);

        if (auth()->user()->can('assignDirectPermission', User::class)) {
            $user->syncPermissions($this->permissions);
        }

        return $user;
    }
}

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

    /**
     * Set the model and all his fields.
     *
     * @param User $user The user model.
     * @param array $roles All roles of the user.
     *
     * @return void
     */
    public function setUser(User $user, array $roles): void
    {
        $this->fill([
            'user' => $user,
            'roles' => $roles,
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
        $user = User::create($this->only([
            'username',
            'first_name',
            'last_name',
            'email',
            'office_phone',
            'cell_phone',
            'end_employment_contract'
        ]));
        // Link the new user to the current site.
        $user->sites()->attach(session('current_site_id'));

        // Link the selected roles to the user in the current site.
        $user->syncRoles($this->roles);

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

        return $user;
    }
}

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

    /**
     * The selected roles for the edited user.
     *
     * @var array
     */
    public array $rolesSelected = [];

    public function setUser(User $user, array $roles): void
    {
        $this->user = $user;

        $this->rolesSelected = $roles;
        $this->username = $user->username;
        $this->first_name = $user->first_name;
        $this->last_name = $user->last_name;
        $this->email = $user->email;
        $this->office_phone = $user->office_phone;
        $this->cell_phone = $user->cell_phone;
    }

    /**
     * Function to store the user.
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
            'cell_phone'
        ]));

        $user->syncRoles($this->rolesSelected);

        return $user;
    }

    /**
     * Function to update the user.
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
            'cell_phone'
        ]));

        $user->syncRoles($this->rolesSelected);

        return $user;
    }
}

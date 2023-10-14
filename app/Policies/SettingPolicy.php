<?php
namespace BDS\Policies;

use Illuminate\Auth\Access\HandlesAuthorization;
use BDS\Models\Setting;
use BDS\Models\User;

class SettingPolicy
{
    use HandlesAuthorization;

    /**
     * Determine whether the user can view any models.
     */
    public function viewAny(User $user): bool
    {
        return $user->can('viewAny setting');
    }

    /**
     * Determine whether the user can view the model.
     */
    public function view(User $user, Setting $setting): bool
    {
        return $user->can('view setting');
    }

    /**
     * Determine whether the user can create models.
     */
    public function create(User $user): bool
    {
        return $user->can('create setting');
    }

    /**
     * Determine whether the user can update the model.
     */
    public function update(User $user): bool
    {
        // Give update access to all settings, remove to only allow created setting,
        // false to not allow any update.
        return $user->can('update setting');

        //return $user->id === $setting->user_id;
    }

    /**
     * Determine whether the user can delete the model.
     */
    public function delete(User $user): bool
    {
        return $user->can('delete setting');
    }
}

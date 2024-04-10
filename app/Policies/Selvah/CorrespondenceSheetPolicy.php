<?php
namespace BDS\Policies\Selvah;

use BDS\Models\Selvah\CorrespondenceSheet;
use Illuminate\Auth\Access\HandlesAuthorization;
use BDS\Models\User;

class CorrespondenceSheetPolicy
{
    use HandlesAuthorization;

    /**
     * Determine whether the user can view any models.
     */
    public function viewAny(User $user): bool
    {
        return $user->can('viewAny selvah correspondence sheet') && getPermissionsTeamId() === settings('site_id_selvah');
    }

    /**
     * Determine whether the user can view the model.
     */
    public function view(User $user, CorrespondenceSheet $sheet): bool
    {
        return $user->can('view selvah correspondence sheet') && getPermissionsTeamId() === settings('site_id_selvah');
    }

    /**
     * Determine whether the user can create models.
     */
    public function create(User $user): bool
    {
        return $user->can('create selvah correspondence sheet');
    }

    /**
     * Determine whether the user can update the model.
     */
    public function update(User $user, ?CorrespondenceSheet $sheet = null): bool
    {
        if($user->can('update selvah correspondence sheet') && !is_null($sheet)) {
            return $sheet->site_id === getPermissionsTeamId();
        }
        return $user->can('update selvah correspondence sheet');
    }

    /**
     * Determine whether the user can delete the model(s).
     */
    public function delete(User $user, ?CorrespondenceSheet $sheet = null): bool
    {
        if($user->can('delete selvah correspondence sheet') && !is_null($sheet)) {
            return $sheet->site_id === getPermissionsTeamId();
        }
        return $user->can('delete selvah correspondence sheet');
    }

    /**
     * Determine whether the user can export models.
     */
    public function export(User $user): bool
    {
        return $user->can('export selvah correspondence sheet');
    }

    /**
     * Determine whether the user can search in the model.
     */
    public function search(User $user): bool
    {
        return $user->can('search selvah correspondence sheet');
    }

    /**
     * Determine whether the user can sign the model.
     */
    public function sign(User $user, ?CorrespondenceSheet $sheet = null): bool
    {
        if($user->can('sign selvah correspondence sheet') && !is_null($sheet)) {
            return $sheet->site_id === getPermissionsTeamId();
        }
        return $user->can('sign selvah correspondence sheet');
    }
}

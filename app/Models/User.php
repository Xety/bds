<?php

namespace BDS\Models;

use BackedEnum;
use BDS\Http\Controllers\Auth\Traits\MustSetupPassword;
use BDS\Models\Presenters\UserPresenter;
use BDS\Observers\UserObserver;
use Illuminate\Auth\Authenticatable;
use Illuminate\Auth\Passwords\CanResetPassword;
use Illuminate\Contracts\Auth\Access\Authorizable as AuthorizableContract;
use Illuminate\Contracts\Auth\Authenticatable as AuthenticatableContract;
use Illuminate\Contracts\Auth\CanResetPassword as CanResetPasswordContract;
use Illuminate\Database\Eloquent\Attributes\ObservedBy;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\HasOne;
use Illuminate\Database\Eloquent\Relations\MorphMany;
use Illuminate\Database\Eloquent\SoftDeletingScope;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Foundation\Auth\Access\Authorizable;
use Illuminate\Notifications\DatabaseNotification;
use Illuminate\Notifications\Notifiable;
use Illuminate\Support\Arr;
use Illuminate\Support\Collection;
use Spatie\Permission\PermissionRegistrar;
use Spatie\Permission\Traits\HasRoles;

#[ObservedBy([UserObserver::class])]
class User extends Model implements
    AuthenticatableContract,
    AuthorizableContract,
    CanResetPasswordContract
{
    use Authenticatable;
    use Authorizable;
    use CanResetPassword;
    use HasRoles;
    use HasFactory;
    use MustSetupPassword;
    use Notifiable;
    use UserPresenter;
    use SoftDeletes;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'username',
        'password',
        'first_name',
        'last_name',
        'email',
        'office_phone',
        'cell_phone',
        'end_employment_contract',
        'current_site_id'
    ];

    /**
     * The accessors to append to the model's array form.
     *
     * @var array
     */
    protected $appends = [
        'avatar',
        'full_name',

        // Session Model
        'online',

        // Role Model
        'level'
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array
     */
    protected $casts = [
        'password_setup_at' => 'datetime',
        'password' => 'hashed',
        'last_login_date' => 'datetime',
        'end_employment_contract' => 'datetime'
    ];

    /**
    * Retrieve the model for a bound value.
    *
    * @param  mixed  $value
    * @param  string|null  $field
     *
    * @return User
    */
    public function resolveRouteBinding($value, $field = null): User
    {
        // If no field was given, use the primary key
        if ($field === null) {
            $field = $this->primaryKey;
        }
        // Apply where clause
        $query = $this->where($field, $value);

        // Conditionally remove the softdelete scope to allow seeing soft-deleted records
        //if (Auth::check() && Auth::user()->can('delete', $this)) {
            $query->withoutGlobalScope(SoftDeletingScope::class);
       //}

        // Find the first record, or abort
        return $query->firstOrFail();
    }

    /**
     * Get the cleanings created by the user.
     *
     * @return HasMany
     */
    public function cleanings(): HasMany
    {
        return $this->hasMany(Cleaning::class);
    }

    /**
     * Get the sites assigned to users.
     *
     * @return BelongsToMany
     */
    public function sites(): BelongsToMany
    {
        return $this->belongsToMany(Site::class)
            ->withTimestamps();
    }

    /**
     * Get the maintenances assigned to user thought operators
     *
     * @return BelongsToMany
     */
    public function maintenancesOperators(): BelongsToMany
    {
        return $this->belongsToMany(Maintenance::class)
            ->withTimestamps();
    }

    /**
     * Get the maintenances created by the user.
     *
     * @return HasMany
     */
    public function maintenances(): HasMany
    {
        return $this->hasMany(Maintenance::class);
    }

    /**
     * Get the setting for the user.
     *
     * @return MorphMany
     */
    public function settings(): MorphMany
    {
        return $this->morphMany(Setting::class, 'model');
    }

    /**
     * Get the user that deleted the user.
     *
     * @return HasOne
     */
    public function deletedUser(): HasOne
    {
        return $this->hasOne(User::class, 'id', 'deleted_user_id')->withTrashed();
    }

    /**
     * Get the direct permissions for the user.
     *
     * @return BelongsToMany
     */
    public function permissionsWithoutSite(): BelongsToMany
    {
        return $this->morphToMany(
            config('permission.models.permission'),
            'model',
            config('permission.table_names.model_has_permissions'),
            config('permission.column_names.model_morph_key'),
            config('permission.column_names.permission_pivot_key')
        );
    }

    /**
     * Get the direct permissions for the user.
     *
     * @return BelongsToMany
     */
    public function rolesWithoutSite(): BelongsToMany
    {
        return $this->morphToMany(
            config('permission.models.role'),
            'model',
            config('permission.table_names.model_has_roles'),
            config('permission.column_names.model_morph_key'),
            app(PermissionRegistrar::class)->pivotRole
        );
    }

    /**
     * Return the first site id of the user or null if no site.
     *
     * @return null|int
     */
    public function getFirstSiteId(): ?int
    {
        $id = $this->sites()->first()?->id;

        if (is_null($id)) {
            return null;
        }
        return $id;
    }

    /**
     * Get the notifications for the user.
     *
     * @return MorphMany
     */
    public function notifications(): MorphMany
    {
        return $this->morphMany(DatabaseNotification::class, 'notifiable')
                        ->orderBy('read_at', 'asc')
                        ->orderBy('created_at', 'desc');
    }

    /**
     * Function to assign the given roles to the given sites
     *
     * @param BackedEnum|int|array|string|Collection|Role $roles
     * @param array|int $sites
     *
     * @return void
     */
    public function assignRolesToSites(BackedEnum|Collection|int|array|string|Role $roles, array|int $sites): void
    {
        if (! app(PermissionRegistrar::class)->teams) {
            return;
        }

        $sites = Arr::wrap($sites);

        $teamId = getPermissionsTeamId();

        foreach ($sites as $site) {
            setPermissionsTeamId($site);
            $this->assignRole($roles);
        }

        setPermissionsTeamId($teamId);
    }

    /**
     * Function to assign the given roles to the given sites
     *
     * @param BackedEnum|int|array|string|Collection|Permission $permissions
     * @param array|int $sites
     *
     * @return void
     */
    public function assignPermissionsToSites(BackedEnum|Collection|int|array|string|Permission $permissions, array|int $sites): void
    {
        if (! app(PermissionRegistrar::class)->teams) {
            return;
        }

        $sites = Arr::wrap($sites);

        $teamId = getPermissionsTeamId();

        foreach ($sites as $site) {
            setPermissionsTeamId($site);
            $this->givePermissionTo($permissions);
        }

        setPermissionsTeamId($teamId);
    }
}

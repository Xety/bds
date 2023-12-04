<?php

namespace BDS\Models;

use Eloquence\Behaviours\CountCache\Countable;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\HasOne;
use BDS\Models\Presenters\MaintenancePresenter;

class Maintenance extends Model
{
    use Countable;
    use HasFactory;
    use MaintenancePresenter;

    /**
     * All types with their labels. (Used for radio buttons)
     */
    public const TYPES = [
        'curative' => 'Curative',
        'preventive' => 'Préventive'
    ];

    /**
     * All realizations with their labels. (Used for radio buttons)
     */
    public const REALIZATIONS = [
        'internal' => 'Interne',
        'external' => 'Externe',
        'both' => 'Interne et Externe'
    ];

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'gmao_id',
        'material_id',
        'description',
        'reason',
        'user_id',
        'type',
        'realization',
        'started_at',
        'finished_at',
        'edit_count',
        'is_edited',
        'edited_user_id'
    ];

    /**
     * The accessors to append to the model's array form.
     *
     * @var array
     */
    protected $appends = [
        'show_url'
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'started_at' => 'datetime',
        'finished_at' => 'datetime',
        'is_edited' => 'boolean'
    ];

    /**
     * Return the count cache configuration.
     *
     * @return array
     */
    public function countCaches(): array
    {
        return [
            Material::class,
            User::class
        ];
    }

    /**
     * Get the material that owns the maintenance.
     *
     * @return BelongsTo
     */
    public function material(): BelongsTo
    {
        return $this->belongsTo(Material::class);
    }

    /**
     * Get the companies related to the maintenance.
     *
     * @return BelongsToMany
     */
    public function companies(): BelongsToMany
    {
        return $this->belongsToMany(Company::class)->withTimestamps();
    }

    /**
     * Get the operators related to the maintenance.
     *
     * @return BelongsToMany
     */
    public function operators(): BelongsToMany
    {
        return $this->belongsToMany(User::class)->withTimestamps()->withTrashed();
    }

    /**
     * Get the partExits related to the maintenance.
     *
     * @return HasMany
     */
    public function partExits(): HasMany
    {
        return $this->hasMany(PartExit::class);
    }

    /**
     * Get the user that owns the maintenance.
     *
     * @return BelongsTo
     */
    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class)->withTrashed();
    }

    /**
     * Get the user that edited the maintenance.
     *
     * @return HasOne
     */
    public function editedUser(): HasOne
    {
        return $this->hasOne(User::class, 'id', 'edited_user_id')->withTrashed();
    }
}

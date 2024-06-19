<?php

namespace BDS\Models;

use BDS\Observers\MaintenanceObserver;
use Eloquence\Behaviours\CountCache\CountedBy;
use Eloquence\Behaviours\CountCache\HasCounts;
use Illuminate\Database\Eloquent\Attributes\ObservedBy;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\HasOne;
use BDS\Models\Presenters\MaintenancePresenter;

#[ObservedBy([MaintenanceObserver::class])]
class Maintenance extends Model
{
    use HasCounts;
    use MaintenancePresenter;

    /**
     * All types with their labels. (Used for radio buttons)
     */
    public const TYPES = [
        [
            'id' => 'curative',
            'name' => 'Curative'
        ],
        [
            'id' => 'preventive',
            'name' => 'Préventive'
        ],
    ];

    /**
     * All realizations with their labels. (Used for radio buttons)
     */
    public const REALIZATIONS = [
        [
            'id' => 'internal',
            'name' => 'Interne'
        ],
        [
            'id' => 'external',
            'name' => 'Externe'
        ],
        [
            'id' => 'both',
            'name' => 'Interne et Externe'
        ],
    ];

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'site_id',
        'gmao_id',
        'material_id',
        'description',
        'reason',
        'user_id',
        'type',
        'realization',
        'started_at',
        'is_finished',
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
     * @return array
     */
    protected function casts(): array
    {
        return [
            'started_at' => 'datetime',
            'finished_at' => 'datetime',
            'is_finished' => 'boolean',
            'is_edited' => 'boolean'
        ];
    }

    /**
     * Get the site that owns the maintenance.
     *
     * @return BelongsTo
     */
    public function site(): BelongsTo
    {
        return $this->belongsTo(Site::class);
    }

    /**
     * Get the material that owns the maintenance.
     *
     * @return BelongsTo
     */
    #[CountedBy]
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
        return $this->belongsToMany(Company::class)
            ->using(CompanyMaintenance::class)
            ->withTimestamps();
    }

    /**
     * Get the operators related to the maintenance.
     *
     * @return BelongsToMany
     */
    public function operators(): BelongsToMany
    {
        return $this->belongsToMany(User::class)
            ->withTimestamps()
            ->withTrashed();
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
     * Get the incidents related to the maintenance.
     *
     * @return HasMany
     */
    public function incidents(): HasMany
    {
        return $this->hasMany(Incident::class);
    }

    /**
     * Get the user that owns the maintenance.
     *
     * @return BelongsTo
     */
    #[CountedBy]
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

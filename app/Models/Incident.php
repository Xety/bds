<?php

namespace BDS\Models;

use BDS\Observers\IncidentObserver;
use Eloquence\Behaviours\CountCache\CountedBy;
use Eloquence\Behaviours\CountCache\HasCounts;
use Illuminate\Database\Eloquent\Attributes\ObservedBy;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasOne;

#[ObservedBy([IncidentObserver::class])]
class Incident extends Model
{
    use HasCounts;

    /**
     * All impact with their labels.
     */
    public const IMPACT = [
        [
            'id' => 'mineur',
            'name' => 'Mineur'
        ],
        [
            'id' => 'moyen',
            'name' => 'Moyen'
        ],
        [
            'id' => 'critique',
            'name' => 'Critique'
        ]
    ];

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'maintenance_id',
        'material_id',
        'user_id',
        'description',
        'started_at',
        'impact',
        'is_finished',
        'finished_at',
        'impact',
        'edit_count',
        'is_edited',
        'edited_user_id',
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
     * Get the site that owns the incident.
     *
     * @return BelongsTo
     */
    public function site(): BelongsTo
    {
        return $this->belongsTo(Site::class);
    }

    /**
     * Get the material that owns the incident.
     *
     * @return BelongsTo
     */
    #[CountedBy]
    public function material(): BelongsTo
    {
        return $this->belongsTo(Material::class);
    }

    /**
     * Get the maintenance that owns the incident.
     *
     * @return BelongsTo
     */
    #[CountedBy]
    public function maintenance(): BelongsTo
    {
        return $this->belongsTo(Maintenance::class);
    }

    /**
     * Get the user that owns the incident.
     *
     * @return BelongsTo
     */
    #[CountedBy]
    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class)
            ->withTrashed();
    }

    /**
     * Get the user that edited the incident.
     *
     * @return HasOne
     */
    public function editedUser(): HasOne
    {
        return $this->hasOne(User::class, 'id', 'edited_user_id')->withTrashed();
    }
}


<?php

namespace BDS\Models;

use BDS\Observers\CleaningObserver;
use Eloquence\Behaviours\CountCache\Countable;
use Illuminate\Database\Eloquent\Attributes\ObservedBy;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasOne;

#[ObservedBy([CleaningObserver::class])]
class Cleaning extends Model
{
    use Countable;

    /**
     * All types with their labels.
     */
    public const TYPES = [
        [
            'id' => 'daily',
            'name' => 'Journalier'
        ],
        [
            'id' => 'weekly',
            'name' => 'Hebdomadaire'
        ],
        [
            'id' => 'bimonthly',
            'name' => 'Bi-mensuel'
        ],
        [
            'id' => 'monthly',
            'name' => 'Mensuel'
        ],
        [
            'id' => 'quarterly',
            'name' => 'Trimestrielle'
        ],
        [
            'id' => 'biannual',
            'name' => 'Bi-annuel'
        ],
        [
            'id' => 'annual',
            'name' => 'Annuel'
        ],
        [
            'id' => 'casual',
            'name' => 'Occasionnel'
        ]
    ];

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'material_id',
        'user_id',
        'description',
        'selvah_ph_test_water',
        'selvah_ph_test_water_after_cleaning',
        'type',
        'edit_count',
        'is_edited',
        'edited_user_id',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
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
     * Get the site that owns the cleaning.
     *
     * @return BelongsTo
     */
    public function site(): BelongsTo
    {
        return $this->belongsTo(Site::class);
    }

    /**
     * Get the material that owns the cleaning.
     *
     * @return BelongsTo
     */
    public function material(): BelongsTo
    {
        return $this->belongsTo(Material::class);
    }

    /**
     * Get the user that owns the cleaning.
     *
     * @return BelongsTo
     */
    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class)->withTrashed();
    }

    /**
     * Get the user that edited the cleaning.
     *
     * @return HasOne
     */
    public function editedUser(): HasOne
    {
        return $this->hasOne(User::class, 'id', 'edited_user_id')->withTrashed();
    }
}

<?php

namespace BDS\Models;

use Eloquence\Behaviours\CountCache\Countable;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use BDS\Models\Presenters\MaterialPresenter;

class Material extends Model
{
    use Countable;
    use HasFactory;
    use MaterialPresenter;

    /**
     * All cleaning types with their labels.
     */
    public const CLEANING_TYPES = [
        'daily' => 'Jour(s)',
        'monthly' => 'Mois',
        'yearly' => 'An(s)'
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'cleaning_alert' => 'boolean',
        'cleaning_alert_email' => 'boolean',
        'last_cleaning_at' => 'datetime'
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
     * Return the count cache configuration.
     *
     * @return array
     */
    public function countCaches(): array
    {
        return [
            Zone::class
        ];
    }

    /**
     * Get the zone that owns the material.
     *
     * @return BelongsTo
     */
    public function zone(): BelongsTo
    {
        return $this->belongsTo(Zone::class);
    }

    /**
     * Get the user that owns the material.
     *
     * @return BelongsTo
     */
    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    /**
     * Get the cleanings for the material.
     *
     * @return HasMany
     */
    public function cleanings(): HasMany
    {
        return $this->hasMany(Cleaning::class);
    }
}

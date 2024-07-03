<?php

namespace BDS\Models;

use BDS\Enums\Material\CleaningTypes;
use BDS\Observers\MaterialObserver;
use Eloquence\Behaviours\CountCache\CountedBy;
use Eloquence\Behaviours\CountCache\HasCounts;
use Illuminate\Database\Eloquent\Attributes\ObservedBy;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasMany;
use BDS\Models\Presenters\MaterialPresenter;

#[ObservedBy([MaterialObserver::class])]
class Material extends Model
{
    use HasCounts;
    use MaterialPresenter;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name',
        'description',
        'zone_id',
        'cleaning_alert',
        'cleaning_alert_email',
        'cleaning_alert_frequency_repeatedly',
        'cleaning_alert_frequency_type',
        'selvah_cleaning_test_ph_enabled'
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
            'cleaning_alert_frequency_type' => CleaningTypes::class,
            'selvah_cleaning_test_ph_enabled' => 'boolean',
            'cleaning_alert' => 'boolean',
            'cleaning_alert_email' => 'boolean',
            'last_cleaning_at' => 'datetime',
            'last_cleaning_alert_send_at' => 'datetime'
        ];
    }

    /**
     * Get the zone that owns the material.
     *
     * @return BelongsTo
     */
    #[CountedBy]
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
        return $this->belongsTo(User::class)->withTrashed();
    }

    /**
     * Get the incidents for the material.
     *
     * @return HasMany
     */
    public function incidents(): HasMany
    {
        return $this->hasMany(Incident::class);
    }

    /**
     * Get the maintenances for the material.
     *
     * @return HasMany
     */
    public function maintenances(): HasMany
    {
        return $this->hasMany(Maintenance::class);
    }

    /**
     * Get the parts for the material.
     *
     * @return BelongsToMany
     */
    public function parts(): BelongsToMany
    {
        return $this->belongsToMany(Part::class)
            ->using(MaterialPart::class);
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

    /**
     * Get the recipients alert for the material.
     *
     * @return BelongsToMany
     */
    public function recipients(): BelongsToMany
    {
        return $this->belongsToMany(User::class)
            ->withTimestamps()
            ->withTrashed();
    }
}

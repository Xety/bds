<?php

namespace BDS\Models;

use BDS\Models\Presenters\ZonePresenter;
use BDS\Observers\ZoneObserver;
use Eloquence\Behaviours\CountCache\CountedBy;
use Eloquence\Behaviours\CountCache\HasCounts;
use Illuminate\Database\Eloquent\Attributes\ObservedBy;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

#[ObservedBy([ZoneObserver::class])]
class Zone extends Model
{
    use HasCounts;
    use ZonePresenter;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'site_id',
        'name',
        'parent_id',
        'allow_material'
    ];

    /**
     * The attributes that should be cast.
     *
     * @return array
     */
    protected function casts(): array
    {
        return [
            'allow_material' => 'boolean'
        ];
    }

    /**
     * Get the materials for the zone.
     *
     * @return HasMany
     */
    public function materials(): HasMany
    {
        return $this->hasMany(Material::class);
    }

    /**
     * Get the site that owns the zone.
     *
     * @return BelongsTo
     */
    #[CountedBy]
    public function site(): BelongsTo
    {
        return $this->belongsTo(Site::class);
    }

    /**
     * Get the parent that owns the zone.
     *
     * @return BelongsTo
     */
    public function parent(): BelongsTo
    {
        return $this->belongsTo(Zone::class, 'parent_id');
    }

    /**
     * Get the direct sub-zone for the zone.
     *
     * @return HasMany
     */
    public function children(): HasMany
    {
        return $this->hasMany(Zone::class, 'parent_id');
    }

    /**
     * Get all the sub-zone recursively for the zone.
     *
     * @return HasMany
     */
    public function descendants(): HasMany
    {
        return $this->children()->with('descendants');
    }
}

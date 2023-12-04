<?php

namespace BDS\Models;

use BDS\Models\Presenters\ZonePresenter;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Zone extends Model
{
    use HasFactory;
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
     * @var array
     */
    protected $casts = [
        'allow_material' => 'boolean'
    ];

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
     * Get the material that owns the cleaning.
     *
     * @return BelongsTo
     */
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

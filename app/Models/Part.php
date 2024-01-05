<?php

namespace BDS\Models;

use Eloquence\Behaviours\CountCache\Countable;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\HasOne;
use BDS\Models\Presenters\PartPresenter;

class Part extends Model
{
    use Countable;
    use PartPresenter;
    use HasFactory;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'site_id',
        'name',
        'user_id',
        'description',
        'reference',
        'supplier_id',
        'price',
        'number_warning_enabled',
        'number_warning_minimum',
        'number_critical_enabled',
        'number_critical_minimum',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array
     */
    protected $casts = [
        'number_warning_enabled' => 'boolean',
        'number_warning_minimum' => 'integer',
        'number_critical_enabled' => 'boolean',
        'number_critical_minimum' => 'integer'
    ];

    /**
     * The accessors to append to the model's array form.
     *
     * @var array
     */
    protected $appends = [
        'show_url',
        'stock_total'
    ];

    /**
     * Return the count cache configuration.
     *
     * @return array
     */
    public function countCaches(): array
    {
        return [
            Supplier::class
        ];
    }

    /**
     * Get the site that owns the part.
     *
     * @return BelongsTo
     */
    public function site(): BelongsTo
    {
        return $this->belongsTo(Site::class);
    }

    /**
     * Get the supplier for the part.
     *
     * @return BelongsTo
     */
    public function supplier(): BelongsTo
    {
        return $this->belongsTo(Supplier::class);
    }

    /**
     * Get the materials for the part.
     *
     * @return BelongsToMany
     */
    public function materials(): BelongsToMany
    {
        return $this->belongsToMany(Material::class)
            ->using(MaterialPart::class)
            ->withTimestamps();
    }

    /**
     * Get the user that owns the part.
     *
     * @return BelongsTo
     */
    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class)->withTrashed();
    }

    /**
     * Get the recipients alert for the part.
     *
     * @return BelongsToMany
     */
    public function recipients(): BelongsToMany
    {
        return $this->belongsToMany(User::class)
            ->withTimestamps()
            ->withTrashed();
    }

    /**
     * Get the partEntries for the part.
     *
     * @return HasMany
     */
    public function partEntries(): HasMany
    {
        return $this->hasMany(PartEntry::class);
    }

    /**
     * Get the partsExits for the part.
     *
     * @return HasMany
     */
    public function partExits(): HasMany
    {
        return $this->hasMany(PartExit::class);
    }

    /**
     * Get the user that edited the part.
     *
     * @return HasOne
     */
    public function editedUser(): HasOne
    {
        return $this->hasOne(User::class, 'id', 'edited_user_id')->withTrashed();
    }
}

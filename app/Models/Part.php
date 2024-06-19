<?php

namespace BDS\Models;

use BDS\Observers\PartObserver;
use Eloquence\Behaviours\CountCache\CountedBy;
use Eloquence\Behaviours\CountCache\HasCounts;
use Illuminate\Database\Eloquent\Attributes\ObservedBy;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\HasOne;
use BDS\Models\Presenters\PartPresenter;

#[ObservedBy([PartObserver::class])]
class Part extends Model
{
    use HasCounts;
    use PartPresenter;

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
     * The accessors to append to the model's array form.
     *
     * @var array
     */
    protected $appends = [
        'show_url',
        'stock_total'
    ];

    /**
     * The attributes that should be cast.
     *
     * @return array
     */
    protected function casts(): array
    {
        return [
            'number_warning_enabled' => 'boolean',
            'number_warning_minimum' => 'integer',
            'number_critical_enabled' => 'boolean',
            'number_critical_minimum' => 'integer'
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
    #[CountedBy]
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
    #[CountedBy]
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

<?php

namespace BDS\Models;

use BDS\Enums\Frequences;
use BDS\Observers\CleaningObserver;
use Eloquence\Behaviours\CountCache\CountedBy;
use Eloquence\Behaviours\CountCache\HasCounts;
use Illuminate\Database\Eloquent\Attributes\ObservedBy;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasOne;

#[ObservedBy([CleaningObserver::class])]
class Cleaning extends Model
{
    use HasCounts;

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
        'type' => Frequences::class,
        'is_edited' => 'boolean'
    ];

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
    #[CountedBy]
    public function material(): BelongsTo
    {
        return $this->belongsTo(Material::class);
    }

    /**
     * Get the user that owns the cleaning.
     *
     * @return BelongsTo
     */
    #[CountedBy]
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

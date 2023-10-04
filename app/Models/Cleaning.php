<?php

namespace BDS\Models;

use Eloquence\Behaviours\CountCache\Countable;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasOne;

class Cleaning extends Model
{
    use Countable;
    use HasFactory;

    /**
     * All types with their labels.
     */
    public const TYPES = [
        'daily' => 'Journalier',
        'weekly' => 'Hebdomadaire',
        'bimonthly' => 'Bi-mensuel',
        'monthly' => 'Mensuel',
        'quarterly' => 'Trimestrielle',
        'biannual' => 'Bi-annuel',
        'annual' => 'Annuel',
        'casual' => 'Occasionnel'
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

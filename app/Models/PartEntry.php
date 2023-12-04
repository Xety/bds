<?php

namespace BDS\Models;

use Eloquence\Behaviours\CountCache\Countable;
use Eloquence\Behaviours\SumCache\Summable;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class PartEntry extends Model
{
    use Countable;
    use HasFactory;
    use Summable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'part_id',
        'user_id',
        'number',
        'order_id'
    ];

    /**
     * Return the count cache configuration.
     *
     * @return array
     */
    public function countCaches(): array
    {
        return [
            'part_entry_count' => [Part::class, 'part_id', 'id']
        ];
    }

    /**
     * Return the count cache configuration.
     *
     * @return array
     */
    public function sumCaches(): array
    {
        return [
            'part_entry_total' => [Part::class, 'number', 'part_id', 'id']
        ];
    }

    /**
     * Get the part that owns the part_entry.
     *
     * @return BelongsTo
     */
    public function part(): BelongsTo
    {
        return $this->belongsTo(Part::class);
    }

    /**
     * Get the user that created the part_entry.
     *
     * @return BelongsTo
     */
    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class)->withTrashed();
    }
}


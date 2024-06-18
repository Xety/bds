<?php

namespace BDS\Models;

use BDS\Observers\PartEntryObserver;
use Eloquence\Behaviours\CountCache\CountedBy;
use Eloquence\Behaviours\CountCache\HasCounts;
use Eloquence\Behaviours\SumCache\HasSums;
use Eloquence\Behaviours\SumCache\SummedBy;
use Illuminate\Database\Eloquent\Attributes\ObservedBy;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

#[ObservedBy([PartEntryObserver::class])]
class PartEntry extends Model
{
    use HasCounts;
    use HasSums;

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
     * Get the part that owns the part_entry.
     *
     * @return BelongsTo
     */
    #[CountedBy(as: 'part_entry_count')]
    #[SummedBy(from: 'number', as: 'part_entry_total')]
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


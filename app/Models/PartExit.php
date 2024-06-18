<?php

namespace BDS\Models;

use BDS\Observers\PartExitObserver;
use Eloquence\Behaviours\CountCache\CountedBy;
use Eloquence\Behaviours\CountCache\HasCounts;
use Eloquence\Behaviours\SumCache\HasSums;
use Eloquence\Behaviours\SumCache\SummedBy;
use Illuminate\Database\Eloquent\Attributes\ObservedBy;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

#[ObservedBy([PartExitObserver::class])]
class PartExit extends Model
{
    use HasCounts;
    use HasSums;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'maintenance_id',
        'part_id',
        'user_id',
        'description',
        'number',
        'price'
    ];

    /**
     * Get the part that owns the part_exit.
     *
     * @return BelongsTo
     */
    #[CountedBy(as: 'part_exit_count')]
    #[SummedBy(from: 'number', as: 'part_exit_total')]
    public function part(): BelongsTo
    {
        return $this->belongsTo(Part::class);
    }

    /**
     * Get the user that created the part_exit.
     *
     * @return BelongsTo
     */
    #[CountedBy(as: 'part_exit_count')]
    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class)
            ->withTrashed();
    }

    /**
     * Get the maintenance that owns the part_exit.
     *
     * @return BelongsTo
     */
    public function maintenance(): BelongsTo
    {
        return $this->belongsTo(Maintenance::class);
    }
}


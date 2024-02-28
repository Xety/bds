<?php

namespace BDS\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasOne;

class Calendar extends Model
{
    /**
     * Indicates if the model should be timestamped
     *
     * @var bool
     */
    public $timestamps = false;

    /**
     * Indicates if the IDs are auto-incrementing.
     *
     * @var bool
     */
    public $incrementing = false;

    /**
     * The "type" of the primary key ID.
     *
     * @var string
     */
    protected $keyType = 'string';

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'id',
        'site_id',
        'title',
        'started',
        'ended',
        'color',
        'allDay'
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'started' => 'datetime',
        'ended' => 'datetime',
        'allDay' => 'boolean'
    ];

    /**
     * Get the user that created the Calendar.
     *
     * @return BelongsTo
     */
    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class)
            ->withTrashed();
    }

    /**
     * Get the site where belongs the calendar.
     *
     * @return BelongsTo
     */
    public function site(): BelongsTo
    {
        return $this->belongsTo(Site::class);
    }

    /**
     * Get the site where belongs the calendar.
     *
     * @return BelongsTo
     */
    public function calendarEvent(): BelongsTo
    {
        return $this->BelongsTo(CalendarEvent::class);
    }
}

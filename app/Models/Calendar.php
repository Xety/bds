<?php

namespace BDS\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasOne;

class Calendar extends Model
{
    /**
     * All status with their labels.
     */
    public const STATUS = [
        [
            'id' => 'incoming',
            'name' => 'A venir',
            'icon' => '<svg fill="#D902D6" class="w-5 h-5 inline mr-2" xmlns="http://www.w3.org/2000/svg" viewBox="0 -960 960 960"><path d="M600-80v-80h160v-400H200v160h-80v-320q0-33 23.5-56.5T200-800h40v-80h80v80h320v-80h80v80h40q33 0 56.5 23.5T840-720v560q0 33-23.5 56.5T760-80H600ZM320 0l-56-56 103-104H40v-80h327L264-344l56-56 200 200L320 0ZM200-640h560v-80H200v80Zm0 0v-80 80Z"/></svg>',
            'color' => '#D902D6'
        ],
        [
            'id' => 'waiting',
            'name' => 'En attente',
            'icon' => '<svg fill="#FFF000" class="w-5 h-5 inline mr-2" xmlns="http://www.w3.org/2000/svg" viewBox="0 -960 960 960"><path d="M320-160h320v-120q0-66-47-113t-113-47q-66 0-113 47t-47 113v120Zm160-360q66 0 113-47t47-113v-120H320v120q0 66 47 113t113 47ZM160-80v-80h80v-120q0-61 28.5-114.5T348-480q-51-32-79.5-85.5T240-680v-120h-80v-80h640v80h-80v120q0 61-28.5 114.5T612-480q51 32 79.5 85.5T720-280v120h80v80H160Z"/></svg>',
            'color' => '#FFF000'
        ],
        [
            'id' => 'progress',
            'name' => 'En cours',
            'icon' => '<svg fill="#021CD9" class="w-5 h-5 inline mr-2" xmlns="http://www.w3.org/2000/svg" viewBox="0 -960 960 960"><path d="M200-640h560v-80H200v80Zm0 0v-80 80Zm0 560q-33 0-56.5-23.5T120-160v-560q0-33 23.5-56.5T200-800h40v-80h80v80h320v-80h80v80h40q33 0 56.5 23.5T840-720v227q-19-9-39-15t-41-9v-43H200v400h252q7 22 16.5 42T491-80H200Zm520 40q-83 0-141.5-58.5T520-240q0-83 58.5-141.5T720-440q83 0 141.5 58.5T920-240q0 83-58.5 141.5T720-40Zm67-105 28-28-75-75v-112h-40v128l87 87Z"/></svg>',
            'color' => '#021CD9'
        ],
        [
            'id' => 'done',
            'name' => 'Terminé',
            'icon' => '<svg fill="#02D902" class="w-5 h-5 inline mr-2" xmlns="http://www.w3.org/2000/svg" viewBox="0 -960 960 960"><path d="M438-226 296-368l58-58 84 84 168-168 58 58-226 226ZM200-80q-33 0-56.5-23.5T120-160v-560q0-33 23.5-56.5T200-800h40v-80h80v80h320v-80h80v80h40q33 0 56.5 23.5T840-720v560q0 33-23.5 56.5T760-80H200Zm0-80h560v-400H200v400Zm0-480h560v-80H200v80Zm0 0v-80 80Z"/></svg>',
            'color' => '#02D902'
        ],
        [
            'id' => 'canceled',
            'name' => 'Annulé',
            'icon' => '<svg fill="#FF0000" class="w-5 h-5 inline mr-2" xmlns="http://www.w3.org/2000/svg" viewBox="0 -960 960 960"><path d="m388-212-56-56 92-92-92-92 56-56 92 92 92-92 56 56-92 92 92 92-56 56-92-92-92 92ZM200-80q-33 0-56.5-23.5T120-160v-560q0-33 23.5-56.5T200-800h40v-80h80v80h320v-80h80v80h40q33 0 56.5 23.5T840-720v560q0 33-23.5 56.5T760-80H200Zm0-80h560v-400H200v400Zm0-480h560v-80H200v80Zm0 0v-80 80Z"/></svg>',
            'color' => '#FF0000'
        ]
    ];

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

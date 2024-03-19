<?php

namespace BDS\Models;

use BDS\Observers\ActivityObserver;
use Illuminate\Database\Eloquent\Attributes\ObservedBy;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\MorphTo;
use Spatie\Activitylog\Models\Activity as ActivityModel;

#[ObservedBy([ActivityObserver::class])]
class Activity extends ActivityModel
{
    /**
     * Get the site where belongs the activity.
     *
     * @return BelongsTo
     */
    public function site(): BelongsTo
    {
        return $this->belongsTo(Site::class);
    }

    public function causer(): MorphTo
    {
        return $this->morphTo()
            ->withTrashed();
    }
}

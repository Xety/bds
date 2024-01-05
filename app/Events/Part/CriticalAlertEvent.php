<?php

namespace BDS\Events\Part;

use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Queue\SerializesModels;
use BDS\Models\PartExit;

class CriticalAlertEvent
{
    use Dispatchable;
    use SerializesModels;

    /**
     * Create a new event instance.
     */
    public function __construct(public PartExit $partExit)
    {
    }
}

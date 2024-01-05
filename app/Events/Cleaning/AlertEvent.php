<?php

namespace BDS\Events\Cleaning;

use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Queue\SerializesModels;
use BDS\Models\Material;

class AlertEvent
{
    use Dispatchable;
    use SerializesModels;

    /**
     * Create a new event instance.
     */
    public function __construct(public Material $material)
    {
    }
}

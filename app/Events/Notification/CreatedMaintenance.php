<?php


namespace BDS\Events\Notification;

use BDS\Models\Maintenance;
use Illuminate\Broadcasting\Channel;
use Illuminate\Broadcasting\PresenceChannel;
use Illuminate\Broadcasting\PrivateChannel;
use Illuminate\Contracts\Broadcasting\ShouldBroadcast;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Queue\SerializesModels;

class CreatedMaintenance implements ShouldBroadcast
{
    use Dispatchable;
    use SerializesModels;

    /**
     * Create a new event instance.
     */
    public function __construct(public Maintenance $maintenance)
    {
    }

    public function broadcastOn(): Channel
    {
        return new Channel('notification-channel');
    }
}

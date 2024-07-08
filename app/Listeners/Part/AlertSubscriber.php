<?php

namespace BDS\Listeners\Part;

use Illuminate\Events\Dispatcher;
use Illuminate\Support\Facades\Notification;
use BDS\Events\Part\AlertEvent;
use BDS\Events\Part\CriticalAlertEvent;
use BDS\Models\Part;
use BDS\Notifications\Part\AlertNotification;

class AlertSubscriber
{
    /**
     * Register the listeners for the subscriber.
     *
     * @param Dispatcher $events
     *
     * @return array
     */
    public function subscribe(Dispatcher $events): array
    {
        return [
            AlertEvent::class => 'handleAlert',
            CriticalAlertEvent::class => 'handleCriticalAlert',
        ];
    }

    /**
     * Handle part alert events.
     */
    public function handleAlert(AlertEvent $event): ?bool
    {
        $partExit = $event->partExit;

        $part = Part::where('id', $partExit->part_id)->first();

        if ($part->number_warning_minimum >= $part->stock_total) {
            return $this->sendNotifications($part);
        }

        return false;
    }

    /**
     * Handle part alert events.
     */
    public function handleCriticalAlert(CriticalAlertEvent $event): ?bool
    {
        $partExit = $event->partExit;

        $part = Part::with('site')->where('id', $partExit->part_id)->first();

        if ($part->number_critical_minimum >= $part->stock_total) {
            return $this->sendNotifications($part, true);
        }

        return false;
    }

    /**
     *
     * @param Part $part
     * @param bool $critical
     *
     * @return bool
     *
     */
    protected function sendNotifications(Part $part, bool $critical = false): bool
    {
        $users = $part->recipients()->get();

        Notification::send($users, new AlertNotification($part, $critical));

        return true;
    }
}

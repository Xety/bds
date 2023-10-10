<?php
namespace BDS\Livewire\Users;

use Illuminate\Contracts\View\Factory;
use Illuminate\Contracts\View\View;
use Illuminate\Foundation\Application;
use Illuminate\Notifications\DatabaseNotificationCollection;
use Livewire\Component;

class Notifications extends Component
{
    /**
     * All notifications from the user.
     *
     * @var DatabaseNotificationCollection
     */
    public DatabaseNotificationCollection $notifications;

    /**
     * Whatever the user has un-read notifications.
     *
     * @var bool
     */
    public bool $hasUnreadNotifications = false;

    /**
     * The number of un-red notifications.
     *
     * @var int
     */
    public int $unreadNotificationsCount = 0;

    /**
     * The mount function.
     *
     * @return void
     */
    public function mount(): void
    {
        $this->fetchData();
    }

    /**
     * The render function.
     *
     * @return View|Application|Factory|\Illuminate\Contracts\Foundation\Application
     */
    public function render(): View|Application|Factory|\Illuminate\Contracts\Foundation\Application
    {
        return view('livewire.users.notifications');
    }

    /**
     * Remove a notification by its id.
     *
     * @param string $notificationId The id of the notification to remove.
     *
     * @return void
     */
    public function remove(string $notificationId): void
    {
        $notification = auth()->user()->notifications()
            ->where('id', $notificationId)
            ->first();

        // That means the notification id has been modified in front-end.
        if (!$notification) {
            return;
        }

        $notification->delete();

        $this->fetchData();
    }

    /**
     * Mark the notification as read by its id.
     *
     * @param string $notificationId The id of the notification to mark as read.
     *
     * @return void
     */
    public function markAsRead(string $notificationId): void
    {
        $notification = auth()->user()->notifications()
            ->where('id', $notificationId)
            ->first();

        // That means the notification id has been modified in front-end.
        if (!$notification) {
            return;
        }

        $notification->markAsRead();

        $this->fetchData();
    }

    /**
     * Mark all notifications from the user as read.
     *
     * @return void
     */
    public function markAllNotificationsAsRead(): void
    {
        auth()->user()->unreadNotifications->markAsRead();

        $this->notifications = auth()->user()->notifications;
        $this->unreadNotificationsCount = 0;
        $this->hasUnreadNotifications = false;
    }

    /**
     * Used to refresh the notifications and the unread count.
     *
     * @return void
     */
    private function fetchData(): void
    {
        $this->notifications = auth()->user()->notifications;
        $this->unreadNotificationsCount = auth()->user()->unreadNotifications->count();
        $this->hasUnreadNotifications = $this->unreadNotificationsCount > 0;
    }
}

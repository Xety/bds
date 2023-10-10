<?php

namespace BDS\Livewire\Users;

use Livewire\Attributes\Modelable;
use Livewire\Attributes\On;
use Livewire\Attributes\Reactive;
use Livewire\Component;

class Notifications extends Component
{
    public $notifications;

    public bool $hasUnreadNotifications = false;

    #[Modelable]
    public int $unreadNotificationsCount = 0;


    public function mount()
    {
        $this->fetchData();
    }

    public function render()
    {
        return view('livewire.users.notifications');
    }


    #[On('remove-notification')]
    public function remove($notificationId): void
    {
        $notification = auth()->user()->notifications()
            ->where('id', $notificationId)
            ->first();

        $notification->delete();

        $this->fetchData();
    }

    public function isNotRead($notificationId)
    {
        $notification = $this->notifications->firstWhere('id', $notificationId);

        return $notification->read_at !== null;
    }

    public function markAsRead(string $notificationId): void
    {
        $notification = auth()->user()->notifications()
            ->where('id', $notificationId)
            ->first();

        $notification->markAsRead();

        $this->fetchData();
    }

    public function markAllNotificationsAsRead(): void
    {
        auth()->user()->unreadNotifications->markAsRead();

        $this->notifications = auth()->user()->notifications;
        $this->unreadNotificationsCount = 0;
        $this->hasUnreadNotifications = false;
    }

    private function fetchData(): void
    {
        $this->notifications = auth()->user()->notifications;
        $this->unreadNotificationsCount = auth()->user()->unreadNotifications->count();
        $this->hasUnreadNotifications = $this->unreadNotificationsCount > 0;
    }
}

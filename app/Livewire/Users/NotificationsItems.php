<?php

namespace BDS\Livewire\Users;

use Livewire\Attributes\Reactive;
use Livewire\Component;

class NotificationsItems extends Component
{

    public $notification;

    public function mount($notification): void
    {
        $this->notification = $notification;
    }

    public function render()
    {
        return view('livewire.users.notifications-items');
    }

    public function isNotRead($notificationId)
    {
        return $this->notification->read_at == null;
    }
}

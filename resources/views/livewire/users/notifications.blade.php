<div>
    <div class="dropdown dropdown-end">
        <!-- Toggle notification menu -->
        <label tabindex="0" class="btn btn-ghost btn-circle">
            <div class="indicator">
                <svg xmlns="http://www.w3.org/2000/svg" ref="toggle_icon_notifications" class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 17h5l-1.405-1.405A2.032 2.032 0 0118 14.158V11a6.002 6.002 0 00-4-5.659V5a2 2 0 10-4 0v.341C7.67 6.165 6 8.388 6 11v3.159c0 .538-.214 1.055-.595 1.436L4 17h5m6 0v1a3 3 0 11-6 0v-1m6 0H9" /></svg>
                <span x-text="$wire.unreadNotificationsCount" class="badge badge-sm indicator-item badge-primary {{ $hasUnreadNotifications && $notifications->isNotEmpty() ? '' : 'hidden' }}"></span>
            </div>
        </label>

        <div tabindex="0" class="mt-3 card card-compact dropdown-content w-96 bg-base-100 shadow z-50">
            <div class="card-body">
                <h3 class="card-title  justify-center">
                    Notifications
                </h3>

                <div class="divider my-0"></div>

                <ul class="max-h-[350px] overflow-y-scroll">
                    @forelse($notifications as $notification)
                        <livewire:users.notifications-items :$notification :key="$notification->id" />
                    @empty
                        <li>
                            <p class="m-2 text-center">
                                Vous n'avez pas de notifications
                            </p>
                        </li>
                    @endforelse
                </ul>

                <!-- Mark all as read -->
                @if($hasUnreadNotifications && $notifications->isNotEmpty())
                    <div class="mb-1">
                        <div class="divider my-0"></div>

                        <button wire:click="markAllNotificationsAsRead" class="btn btn-primary btn-block" type="button">
                            Marquer toutes les notifications comme lues
                        </button>
                    </div>
                @endif

            </div>
        </div>
    </div>
</div>

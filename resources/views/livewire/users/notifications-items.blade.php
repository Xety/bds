<div>
    <li class="hover:bg-slate-200 flex items-center rounded mb-3 mr-2 pt-2 dark:hover:bg-slate-700" wire:key="{{ $notification->id }}">
        <div class="indicator w-full">
            <div  class="p-3 flex items-center">
                <!-- Icon -->
                <i class="fa-solid fa-triangle-exclamation text-3xl text-primary mr-3" aria-hidden="true"></i>

                <!-- Message -->
                <span class="w-full">{!! vsprintf($notification->data['message'], $notification->data['message_key']) !!}</span>

                <!-- Badge new -->
                @if($this->isNotRead($notification->id))
                    <span class="badge badge-sm indicator-item badge-primary right-3">New</span>
                @endif


            </div>
        </div>
        <a wire:click="$dispatch('remove-notification', { notificationId: '{{ $notification->id }}' })" class="cursor-pointer tooltip tooltip-left" data-tip="Supprimer la notification">
            <i class="fa-solid fa-trash text-2xl text-error mr-3" aria-hidden="true"></i>
        </a>
    </li>
</div>

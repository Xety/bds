<?php

namespace BDS\View\Components;

use Illuminate\View\Component;

class Alert extends Component
{
    public string $uuid;
    public string $textTitleColor = 'text-primary';
    public string $bgIconColor = 'bg-primary';
    public string $icon = 'fas-exclamation-circle';

    public function __construct(
        public ?string $title = null,
        public ?string $type = null,

        // Slots
        public mixed $actions = null
    ) {
        $this->uuid = md5(serialize($this));

        switch ($this->type) {
            case 'success':
                $this->textTitleColor = 'text-green-500';
                $this->bgIconColor = 'bg-green-500';
                $this->icon = 'fas-check-circle';
                break;

            case 'info':
                $this->textTitleColor = 'text-blue-500';
                $this->bgIconColor = 'bg-blue-500';
                $this->icon = 'fas-exclamation-circle';
                break;

            case 'warning':
                $this->textTitleColor = 'text-yellow-500';
                $this->bgIconColor = 'bg-yellow-500';
                $this->icon = 'fas-exclamation-triangle';
                break;

            case 'error':
                $this->textTitleColor = 'text-red-500';
                $this->bgIconColor = 'bg-red-500';
                $this->icon = 'bxs-bolt-circle';
                break;
        }
    }

    public function render(): string
    {
        return <<<'HTML'
                <div
                    wire:key="{{ $uuid }}"
                    {{ $attributes->whereDoesntStartWith('class') }}
                    {{ $attributes->class(['flex w-full overflow-hidden rounded-lg shadow-md bg-white dark:bg-base-300 z-10'])}}
               >
                     <div class="flex items-center justify-center w-14 {{ $bgIconColor }}">
                        <x-icon :name="$icon" class="w-6 h-6 text-white fill-current" />
                    </div>
                    <div class="px-2 py-2 w-full relative">
                        <div class="mx-3">
                            <span class="font-semibold {{ $textTitleColor }}">
                                @if($title)
                                    {{ $title }}
                                @endif
                           </span>
                            <p class="text-sm">
                                {{ $slot }}
                            </p>
                        </div>
                        <div class="flex items-center gap-3">
                            {{ $actions }}
                        </div>
                    </div>
                </div>
            HTML;
    }
}

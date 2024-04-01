<?php

namespace BDS\View\Components;

use Illuminate\View\Component;

class Menu extends Component
{
    public string $uuid;

    public function __construct(
        public ?string $title = null,
        public ?string $icon = null,
        public ?bool $separator = false,
        public ?bool $activateByRoute = false,
        public ?string $activeBgColor = 'bg-base-200 hover:bg-base-200 active:!bg-base-200 focus:!bg-base-200 dark:bg-neutral',
        public ?string $activeColor = 'text-neutral active:!text-neutral dark:text-primary-content',
    ) {
        $this->uuid = md5(serialize($this));
    }

    public function render(): string
    {
        return <<<'HTML'
                <ul {{ $attributes->class(["menu rounded-md"]) }} >
                    @if($title)
                        <li class="menu-title text-inherit uppercase">
                            <div class="flex items-center gap-2">

                                @if($icon)
                                    <x-icon :name="$icon" class="w-4 h-4 inline-flex"  />
                                @endif

                                {{ $title }}
                            </div>
                        </li>
                    @endif

                    @if($separator)
                        <hr class="mb-3"/>
                    @endif

                    {{ $slot }}
                </ul>
            HTML;
    }
}

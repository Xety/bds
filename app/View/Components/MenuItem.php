<?php

namespace BDS\View\Components;

use Illuminate\Support\Facades\Route;
use Illuminate\Support\Str;
use Illuminate\View\Component;

class MenuItem extends Component
{
    public string $uuid;

    public function __construct(
        public ?string $title = null,
        public ?string $icon = null,
        public ?string $iconClass = 'inline h-4 w-4',
        public ?string $link = null,
        public ?bool $active = false,
        public ?bool $tooltip = false,
        public ?bool $badge = false,
        public ?string $badgeClass = null,
        public ?string $badgeText = null,
        public ?string $tooltipContent = '',
        public ?bool $separator = false
    ) {
        $this->uuid = md5(serialize($this));
    }

    public function routeMatches(): bool
    {
        if ($this->link == null) {
            return false;
        }

        $link = url($this->link ?? '');
        $route = url(Route::current()->uri());

        return $route === $link;
    }

    public function render(): string
    {
        return <<<'HTML'
                @aware([
                    'activateByRoute' => false,
                    'activeBgColor' => 'bg-base-200 hover:bg-base-200 active:!bg-base-200 dark:bg-neutral',
                    'activeColor' => 'text-neutral dark:text-primary-content active:dark:!text-primary-content'
               ])

                <li>
                    @if($tooltip)
                        <div
                            class="tooltip tooltip-top"
                            data-tip="{{ $tooltipContent }}"
                        >
                    @endif
                        <a
                            {{
                                $attributes->class([
                                    "flex items-center gap-4",
                                    "mary-active-menu $activeBgColor $activeColor" => ($active || ($activateByRoute && $routeMatches()))
                                ])
                            }}

                            @if($link)
                                href="{!! $link !!}" {{ $attributes->has('wire:navigate') ? 'wire:navigate' : '' }}
                            @endif
                        >
                            @if($icon)
                                <x-icon :name="$icon" class="{{ $iconClass }}" />
                            @endif

                           <span class="mary-hideable">
                               {{ $title ?? $slot }}
                               @if($badge)
                                    <span class="badge {{ $badgeClass }}">{{ $badgeText }}</span>
                                @endif
                           </span>
                        </a>
                    @if($tooltip)
                        </div>
                    @endif
                </li>
            HTML;
    }
}

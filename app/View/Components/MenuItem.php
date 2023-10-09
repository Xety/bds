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
        public ?string $link = null,
        public ?bool $active = false,
        public ?bool $tooltip = false,
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

        //var_dump(Str::startsWith($route, $link));

        //return Str::startsWith($route, $link);

        return $route === $link;
    }

    public function render(): string
    {
        return <<<'HTML'
                @aware([
                    'activateByRoute' => false,
                    'activeBgColor' => 'bg-base-200 dark:bg-neutral',
                    'activeColor' => 'text-neutral dark:text-primary-content'
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
                                    "flex items-center gap-4 menu-link",
                                    "mary-active-menu $activeBgColor $activeColor" => ($active || ($activateByRoute && $routeMatches()))
                                ])
                            }}

                            @if($link)
                                href="{{ $link }}" {{ $attributes->has('wire:navigate') ? 'wire:navigate' : '' }}
                            @endif
                        >
                            @if($icon)
                                <x-icon :name="$icon" class="inline h-5 w-5" />
                            @endif

                           <span class="mary-hideable">{{ $title ?? $slot }}</span>
                        </a>
                    @if($tooltip)
                        </div>
                    @endif
                </li>
            HTML;
    }
}

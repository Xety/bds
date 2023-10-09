<?php

namespace BDS\View\Components;

use Illuminate\View\Component;

class MenuSub extends Component
{
    public string $uuid;

    public function __construct(
        public ?string $title = null,
        public ?string $icon = null
    ) {
        $this->uuid = md5(serialize($this));
    }

    public function render(): string
    {
        return <<<'HTML'
                @aware([
                    'activeBgColor' => 'bg-base-200 dark:bg-neutral',
                    'activeColor' => 'text-neutral dark:text-primary-content'
                ])

                @php
                    $submenuActive = Str::contains($slot, 'mary-active-menu');
                @endphp

                <li
                    x-data="
                    {
                        show: @if($submenuActive) true @else false @endif,
                        toggle() {
                            // From parent Sidebar
                            if (this.collapsed) {
                                this.show = true
                                $dispatch('menu-sub-clicked');
                                return
                            }

                            this.show = !this.show
                        }
                    }"
                >
                    <details :open="show" @if($submenuActive) open @endif>
                        <summary @click.prevent="toggle()" @class(["hover:text-inherit text-inherit font-bold", ])>
                            @if($icon)
                                <x-icon :name="$icon" class="inline-flex h-5 w-5"  />
                            @endif
                            <span class="mary-hideable">{{ $title }}</span>
                        </summary>
                        <ul class="mary-hideable">
                            {{ $slot }}
                        </ul>
                    </details>
                </li>
            HTML;
    }
}

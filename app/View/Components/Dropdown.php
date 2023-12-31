<?php

namespace BDS\View\Components;

use Illuminate\View\Component;

class Dropdown extends Component
{
    public function __construct(
        public ?string $label = null,
        public ?string $icon = 'fas-chevron-down',
        public ?bool $right = false,
        public ?bool $hover = false,
        public ?bool $top = false,

        //Slots
        public mixed $trigger = null,
        public mixed $triggerClass = null
    ) {

    }

    public function render(): string
    {
        return <<<'HTML'
            <details
                class="dropdown @if($right) dropdown-end @endif @if($hover) dropdown-hover @endif @if($top) dropdown-top @endif"
                x-data="{open: false}"
                @click.outside="open = false"
                :open="open"
            >
                <!-- CUSTOM TRIGGER -->
                @if($trigger)
                    <summary x-ref="button" @click.prevent="open = !open" class="list-none">
                        {{ $trigger }}
                    </summary>
                @else
                    <!-- DEFAULT TRIGGER -->
                    <summary x-ref="button" @click.prevent="open = !open" class="btn normal-case {{ $triggerClass }}">
                        {{ $label }}
                        <x-icon :name="$icon" class="h-4 w-4" />
                    </summary>
                @endif
                <ul @click="open = false" {{ $attributes->class(['menu dropdown-content mt-3 p-2 shadow z-[1] bg-base-100 dark:bg-base-200 rounded-box whitespace-nowrap w-52']) }}>
                    {{ $slot }}
                </ul>
            </details>
        HTML;
    }
}

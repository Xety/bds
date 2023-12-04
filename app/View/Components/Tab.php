<?php
namespace BDS\View\Components;

use Illuminate\Support\Str;
use Illuminate\View\Component;

class Tab extends Component
{
    public string $uuid;

    public function __construct(
        public ?string $name = null,
        public ?string $label = null,
        public ?string $icon = null
    ) {
        $this->uuid = Str::uuid();
    }

    public function render(): string
    {
        return <<<'HTML'
                    @aware(['tabContainer' =>  ''])
                    <li class="-mb-px xl:mr-2 last:mr-0 flex-auto text-center">
                        <a
                            @click="selected = '{{ $name }}'"
                            class="text-xs font-bold uppercase px-5 py-3 shadow-md rounded block leading-normal cursor-pointer"
                            :class="{ 'text-white bg-neutral dark:text-neutral dark:bg-white': selected === '{{ $name }}',
                             'text-neutral bg-white dark:text-white dark:bg-neutral': selected !== '{{ $name }}' }"
                            {{ $attributes->whereDoesntStartWith('class') }}
                          >

                            @if($icon)
                                <x-icon :name="$icon" class="h-4 w-4 mr-2 inline" />
                            @endif

                            {{ $label }}
                        </a>
                    </li>


                    <div wire:key="{{ $name }}-{{ rand() }}">
                        <template x-teleport="#{{ $tabContainer }}">
                            <div x-show="selected === '{{ $name }}'" {{ $attributes->class(['py-5']) }}>
                                {{ $slot }}
                            </div>
                        </template>
                    </div>
                HTML;
    }
}

<?php

namespace BDS\View\Components;

use Illuminate\Support\Str;
use Illuminate\View\Component;

class Header extends Component
{
    public function __construct(
        public ?string $title = null,
        public ?string $subtitle = null,
        public ?bool $separator = false,
        public ?string $size = 'text-4xl',

        // Slots
        public mixed $middle = null,
        public mixed $actions = null,
    ) {
    }

    public function render(): string
    {
        return <<<'HTML'
                <div {{ $attributes->class(["mb-10"]) }}>
                    <div class="flex flex-wrap gap-5 justify-between items-center">
                        <div>
                            <div class="{{$size}} font-bold">
                                {{ $title }}
                            </div>

                            @if($subtitle)
                                <div class="text-gray-500 text-sm mt-1">{{ $subtitle }}</div>
                            @endif
                        </div>
                        <div class="flex items-center justify-center gap-3 grow order-last sm:order-none">
                            <div class="w-full lg:w-auto">
                                {{ $middle }}
                            </div>
                        </div>
                        <div class="flex items-center gap-3">
                            {{ $actions}}
                        </div>
                    </div>

                    @if($separator)
                        <hr class="my-5" />
                    @endif
                </div>
                HTML;
    }
}

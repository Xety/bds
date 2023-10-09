<?php

namespace BDS\View\Components;

use Illuminate\View\Component;

class Checkbox extends Component
{
    public function __construct(
        public ?string $label = null,
        public ?bool $right = false,
        public ?bool $tight = false
    ) {

    }

    public function render(): string
    {
        return <<<'HTML'
                <label class="flex items-center gap-3 cursor-pointer">
                    @if($right)
                        <span @class(["flex-1" => !$tight])>
                            {{ $label}}
                        </span>
                    @endif

                    <input type="checkbox" {{ $attributes->whereDoesntStartWith('class') }} {{ $attributes->class(['checkbox checkbox-primary']) }}  />

                    @if(!$right)
                        {{ $label}}
                    @endif

                </label>
        HTML;
    }
}

<?php

namespace BDS\View\Components;

use Illuminate\View\Component;

class Checkbox extends Component
{
    public function __construct(
        public ?string $label = null,
        public ?string $labelInfo = null,
        public ?string $text = null,
        public ?bool $checked = false,
        public ?bool $right = false,
        public ?bool $tight = false
    ) {

    }

    public function modelName(): ?string
    {
        return $this->attributes->has('wire:model') ?
            $this->attributes->whereStartsWith('wire:model')->first() :
            $this->attributes->whereStartsWith('name')->first();
    }

    public function render(): string
    {
        return <<<'HTML'
            <div class="form-control">
                <!-- STANDARD LABELS -->
                @if($label)
                    <label class="label" for="{{ $modelName() }}">
                        @if ($label)
                        <span class="label-text font-semibold">
                            {{ $label }}
                        </span>
                        @endif

                        @if ($labelInfo)
                        <span class="label-text-alt">
                            <div class="dropdown dropdown-hover dropdown-bottom dropdown-end">
                                <label tabindex="0" class="hover:cursor-pointer text-info">
                                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" class="w-4 h-4 stroke-current"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                                </label>
                                <div tabindex="0" class="card compact dropdown-content z-[1] shadow bg-base-100 dark:bg-base-200 rounded-box w-64">
                                    <div class="card-body">
                                        <p>{!! $labelInfo !!}</p>
                                    </div>
                                </div>
                            </div>
                        </span>
                        @endif
                    </label>
                @endif

                <label class="flex items-center gap-3 cursor-pointer">
                    @if($right)
                        <span @class(["flex-1" => !$tight])>
                            {{ $label}}
                        </span>
                    @endif

                    <input type="checkbox" {{ $attributes->whereDoesntStartWith('class') }} {{ $attributes->class(['checkbox checkbox-primary']) }} @if($checked) checked @endif  />

                    @if(!$right)
                        {{ $text }}
                    @endif

                </label>
            </div>
        HTML;
    }
}

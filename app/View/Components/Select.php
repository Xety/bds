<?php

namespace BDS\View\Components;

use Illuminate\Support\Collection;
use Illuminate\View\Component;

class Select extends Component
{
    public string $uuid;

    public function __construct(
        public ?string $label = null,
        public ?string $labelInfo = null,
        public ?string $icon = null,
        public ?string $iconRight = null,
        public ?string $hint = null,
        public ?string $placeholder = null,
        public ?bool $inline = false,
        public ?bool $tip = false,
        public ?string $optionValue = 'id',
        public ?string $optionLabel = 'name',
        public ?string $optionTip = 'description',
        public Collection|array $options = new Collection(),
    ) {
        $this->uuid = md5(serialize($this));
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
            <div wire:key="{{ $uuid }}" class="form-control">
                <!-- STANDARD LABELS -->
                @if(($label || $labelInfo) && !$inline)
                    <label class="label" for="{{ $modelName() }}">
                        @if ($label && !$inline)
                        <span class="label-text font-semibold">
                            {{ $label }}
                        </span>
                        @endif

                        @if ($labelInfo && !$inline)
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

                <div class="relative">
                    <select
                        {{ $attributes->whereDoesntStartWith('class') }}
                        {{ $attributes->class([
                                    'select w-full',
                                    'pl-10' => ($icon),
                                    'h-14' => ($inline),
                                    'pt-3' => ($inline && $label),
                                    'border border-dashed' => $attributes->has('readonly'),
                                    'select-error' => $errors->has($modelName())
                                ])
                        }}

                    >
                        @if($placeholder)
                            <option>{{ $placeholder }}</option>
                        @endif

                        @foreach ($options as $option)
                            <option value="{{ $option[$optionValue] }}" @if(isset($option['disabled'])) disabled @endif @if($tip) class="block text-left tooltip" data-tip="{{ $option[$optionTip] }}" @endif>
                                {{ $option[$optionLabel] }}
                            </option>
                        @endforeach
                    </select>

                    <!-- ICON -->
                    @if($icon)
                        <x-icon :name="$icon" class="h-5 w-5 absolute top-1/2 -translate-y-1/2 left-3 text-gray-400" />
                    @endif

                    <!-- RIGHT ICON  -->
                    @if($iconRight)
                        <x-icon :name="$iconRight" class="absolute top-1/2 right-8 -translate-y-1/2 text-gray-400 " />
                    @endif

                    <!-- INLINE LABEL -->
                    @if($label && $inline)
                        <label class="absolute text-gray-500 duration-300 transform -translate-y-1 scale-75 top-2 origin-[0] bg-white rounded dark:bg-gray-900 px-2 peer-focus:px-2 peer-focus:text-blue-600 peer-focus:dark:text-blue-500 peer-placeholder-shown:scale-100 peer-placeholder-shown:-translate-y-1/2 peer-placeholder-shown:top-1/2 peer-focus:top-2 peer-focus:scale-75 peer-focus:-translate-y-1 @if($inline && $icon) left-9 @else left-3 @endif">
                            {{ $label }}
                        </label>
                    @endif
                </div>

                 <!-- ERROR -->
                 @error($modelName())
                    <div class="text-red-500 label-text-alt p-1">{{ $message }}</div>
                @enderror

                <!-- HINT -->
                @if($hint)
                    <div class="label-text-alt text-gray-400 pl-1 mt-2">{{ $hint }}</div>
                @endif
            </div>
        HTML;
    }
}

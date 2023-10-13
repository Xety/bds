<?php

namespace BDS\View\Components;

use Illuminate\View\Component;

class Textarea extends Component
{
    public string $uuid;

    public function __construct(
        public ?string $label = null,
        public ?string $labelInfo = null,
        public ?string $hint = null,
        public ?bool $inline = false,
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
            <div>
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

                <div class="flex-1 relative">
                    <!-- INPUT -->
                    <textarea
                        placeholder = "{{ $attributes->whereStartsWith('placeholder')->first() }} "

                        {{
                            $attributes
                            ->class([
                                'textarea textarea-primary w-full peer',
                                'pt-5' => ($inline && $label),
                                'border border-dashed' => $attributes->has('readonly'),
                                'textarea-error' => $errors->has($modelName())
                            ])
                        }}
                    ></textarea>

                    <!-- INLINE LABEL -->
                    @if($label && $inline)
                        <label for="{{ $uuid }}" class="absolute text-gray-400 duration-300 transform -translate-y-3 scale-75 top-4 bg-white rounded dark:bg-gray-900 px-2 peer-focus:px-2 peer-focus:text-blue-600 peer-focus:dark:text-blue-500 peer-placeholder-shown:scale-100 peer-placeholder-shown:-translate-y-1/2  peer-focus:scale-75 peer-focus:-translate-y-3 left-2">
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
                    <div class="label-text-alt text-gray-400 p-1 pb-0">{{ $hint }}</div>
                @endif
            </div>
            HTML;
    }
}

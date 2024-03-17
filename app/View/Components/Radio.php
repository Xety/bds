<?php

namespace BDS\View\Components;

use Closure;
use Illuminate\Contracts\View\View;
use Illuminate\Support\Collection;
use Illuminate\View\Component;

class Radio extends Component
{
    public string $uuid;

    public function __construct(
        public ?string $label = null,
        public ?string $hint = null,
        public ?string $optionValue = 'id',
        public ?string $optionLabel = 'name',
        public Collection|array $options = new Collection(),
    ) {
        $this->uuid = "mary" . md5(serialize($this));
    }

    public function name(): string
    {
        return $this->attributes->whereStartsWith('wire:model')->first();
    }

    public function render(): string
    {
        return <<<'HTML'

                    @foreach ($options as $option)
                    <div class="form-control">
                            @if($label)
                                <label class="label" for="{{ $name }}">
                                    <span class="label-text">{{ $label }}</span>
                                </label>
                            @endif

                            <label class="cursor-pointer label justify-start">
                                <input
                                    type="radio"
                                    name="{{ $name() }}"
                                    class="radio"
                                    value="{{ data_get($option, $optionValue) }}"
                                    aria-label="{{ data_get($option, $optionLabel) }}"
                                    {{ $attributes->whereStartsWith('wire:model') }}
                                    {{ $attributes->class(["radio"]) }}
                                    />
                                <span class="label-text ml-2">{{ data_get($option, $optionLabel) }}</span>
                            </label>
                    @endforeach

                    @error($name())
                        <label class="label">
                            <span class="label-text-alt text-error">
                                {{ $message }}
                            </span>
                        </label>
                    @enderror
                </div>
            HTML;
    }
}

<?php
namespace BDS\View\Components;

use Illuminate\View\Component;

class Modal extends Component
{
    public function __construct(
        public ?string $id = '',
        public ?string $title = null,
        public ?string $subtitle = null,
        public ?string $modalClass = null,

        // Slots
        public ?string $actions = null
    ) {
        //
    }

    public function render(): string
    {
        return <<<'HTML'
                <dialog
                    {{ $attributes->except('wire:model')->class(["modal"]) }}

                    @if($id)
                        id="{{ $id }}"
                    @else
                        x-data="{open: @entangle($attributes->wire('model')).live }"
                        :class="{'modal-open !animate-none': open}"
                        :open="open"
                        @keydown.escape.window = "$wire.{{ $attributes->wire('model')->value() }} = false"
                    @endif
                >
                    <div class="modal-box {{$modalClass}}">
                        <button class="btn btn-sm btn-circle btn-ghost absolute right-2 top-2" @click="$wire.{{ $attributes->wire('model')->value() }} = false" type="button">✕</button>

                        @if($title)
                            <x-header :title="$title" :subtitle="$subtitle" size="text-2xl" class="mb-5" />
                        @endif

                        {{ $slot }}

                        <div class="modal-action">
                            {{ $actions }}
                        </div>

                    </div>
                </dialog>
                HTML;
    }
}

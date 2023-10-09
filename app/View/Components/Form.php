<?php

namespace BDS\View\Components;

use Illuminate\View\Component;

class Form extends Component
{
    public function __construct(
        public string $method = 'GET',
        // Slots
        public mixed $actions = null
    ) {
    }

    public function method(): string
    {
        $method = str($this->method)->upper();

        if ($method == 'PUT' || $method == 'PATCH' || $method == 'DELETE') {
            $method = 'POST';
        }
        return $method;
    }

    public function isSpoofed()
    {
        $method = str($this->method)->upper();

        if ($method == 'PUT' || $method == 'PATCH' || $method == 'DELETE') {
            return $method;
        }
        return null;
    }

    public function render(): string
    {
        return <<<'HTML'
                <form
                    method="{{ $method() }}"
                    {{ $attributes->whereDoesntStartWith('class') }}
                    {{ $attributes->class(['grid grid-flow-row auto-rows-min gap-3']) }}
                >
                    <!-- CSRF -->
                    @csrf

                    @if($isSpoofed())
                        @method($isSpoofed())
                   @endif

                    {{ $slot }}

                    @if ($actions)
                        <hr class="my-3" />

                        <div class="flex justify-end gap-3">
                            {{ $actions }}
                        </div>
                    @endif
                </form>
                HTML;
    }
}

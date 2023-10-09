<?php

namespace BDS\View\Components;

use Illuminate\View\Component;

class MenuSeparator extends Component
{
    public string $uuid;

    public function __construct(
        public ?string $title = null,
        public ?string $icon = null,
        public ?string $hrClass = null,
    ) {
        $this->uuid = md5(serialize($this));
    }

    public function render(): string
    {
        return <<<'HTML'
                <hr class="m-3 border-t-2 border-base-content dark:border-neutral {{ $hrClass }}" />

                @if($title)
                    <li {{ $attributes->class(["menu-title text-inherit uppercase"]) }}>
                        <div class="flex items-center gap-2">

                            @if($icon)
                                <x-icon :name="$icon"  />
                            @endif

                            {{ $title }}
                        </div>
                    </li>
                @endif
            HTML;
    }
}

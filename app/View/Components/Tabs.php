<?php

namespace BDS\View\Components;

use Illuminate\View\Component;

class Tabs extends Component
{
    public string $uuid;

    public function __construct(
        public ?string $selected = null,
        public string $tabContainer = ''
    ) {
        $this->uuid = md5(serialize($this));
        $this->tabContainer = $this->uuid;
    }

    public function render(): string
    {
        return <<<'HTML'
                    <ul
                        x-data="{
                            selected:
                                @if($selected)
                                    '{{ $selected }}'
                                @else
                                    @entangle($attributes->wire('model'))
                                @endif
                        }"
                        x-init="$nextTick(() => {
                            // After Alpine loaded the component, check if the URL has a hash
                            // If yes set the selected from the hash.
                            if (window.location.hash) {
                                selected = window.location.hash.substring(1);
                            } else {
                                // Set the hash from the selected
                                window.location.hash = selected;
                            }
                            // Add a watcher for selected, if the value change, update the URL hash.
                        }); $watch('selected', (value, oldValue) => oldValue !== value ? window.location.hash = selected : '')"

                        {{ $attributes->class(["flex mb-0 list-none flex-wrap pt-3 pb-4 flex-col xl:flex-row gap-y-3 xl:gap-3"]) }}
                    >
                        {{ $slot }}
                    </ul>
                    <hr/>
                    <div id="{{ $tabContainer }}">
                            <!-- tab contents will be teleported in here -->
                    </div>
                HTML;
    }
}

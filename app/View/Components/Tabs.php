<?php

namespace BDS\View\Components;

use Closure;
use Illuminate\View\Component;
use Illuminate\View\View;

class Tabs extends Component
{
    public string $uuid;

    public function __construct(
        public ?string $selected = null
    ) {
        $this->uuid = "mary" . md5(serialize($this));
    }

    public function render(): View|Closure|string
    {
        return <<<'HTML'
                    <div
                        x-data="{
                                tabs: [],
                                selected:
                                    @if($selected)
                                        '{{ $selected }}'
                                    @else
                                        @entangle($attributes->wire('model'))
                                    @endif
                                 ,
                                 init() {
                                     // Fix weird issue when navigating back
                                     document.addEventListener('livewire:navigating', () => {
                                         document.querySelectorAll('.tab').forEach(el =>  el.remove());
                                     });
                                 }
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
                        class="relative"
                    >
                        <!-- TAB LABELS -->
                        <ul class="flex mb-0 list-none flex-wrap pt-3 pb-4 flex-col xl:flex-row gap-y-3 xl:gap-3">
                            <template x-for="tab in tabs">
                                <li class="-mb-px xl:mr-2 last:mr-0 flex-auto text-center">
                                    <a
                                        role="tab"
                                        x-html="tab.label"
                                        @click="selected = tab.name"
                                        :class="{ 'text-white bg-neutral dark:text-neutral dark:bg-white': selected === tab.name, 'text-neutral bg-white dark:text-white dark:bg-neutral': selected !== tab.name }"
                                        class="text-xs font-bold uppercase px-5 py-3 shadow-md rounded block leading-normal cursor-pointer"></a>
                                </li>
                            </template>
                        </ul>

                        <!-- TAB CONTENT -->
                        <div role="tablist" {{ $attributes->except(['wire:model', 'wire:model.live'])->class(["tabs tabs-bordered block"]) }}>
                            {{ $slot }}
                        </div>
                    </div>
                HTML;
    }
}

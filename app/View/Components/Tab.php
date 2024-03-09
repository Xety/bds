<?php
namespace BDS\View\Components;

use Closure;
use Illuminate\Contracts\View\View;
use Illuminate\Support\Facades\Blade;
use Illuminate\Support\Str;
use Illuminate\View\Component;

class Tab extends Component
{
    public string $uuid;

    public function __construct(
        public ?string $name = null,
        public ?string $label = null,
        public ?string $icon = null
    ) {
        $this->uuid = md5(serialize($this));
    }

    public function tabLabel(): string
    {
        return $this->icon
            ? Blade::render("<x-icon name='" . $this->icon . "' class='h-4 w-4 mr-2 inline'></x-icon>" . $this->label)
            : $this->label;
    }

    public function render(): View|Closure|string
    {
        return <<<'HTML'
                    <a
                        class="hidden"
                        :class="{ 'tab-active': selected === '{{ $name }}' }"
                        data-name="{{ $name }}"
                        x-init="
                                tabs.push({ name: '{{ $name }}', label: {{ json_encode($tabLabel()) }} });
                                Livewire.hook('morph.removed', ({el}) => {
                                    if (el.getAttribute('data-name') == '{{ $name }}'){
                                        tabs = tabs.filter(i => i.name !== '{{ $name }}')
                                    }
                                })
                            "
                    ></a>

                    <div x-show="selected === '{{ $name }}'" role="tabpanel" {{ $attributes->class("tab-content py-5 px-1") }}>
                        {{ $slot }}
                    </div>
                HTML;
    }
}

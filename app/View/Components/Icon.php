<?php

namespace BDS\View\Components;

use Illuminate\Support\Str;
use Illuminate\View\Component;

class Icon extends Component
{
    public string $uuid;

    public function __construct(
        public string $name,
    ) {
        $this->uuid = md5(serialize($this));
    }

    public function icon(): string
    {
        return "{$this->name}";
    }

    public function render(): string
    {
        return <<<'HTML'
                <x-svg
                    :name="$icon()"

                    {{ $attributes->class([
                            'inline',
                            'w-5 h-5' => !\Illuminate\Support\Str::contains($attributes->get('class'), ['w-', 'h-'])
                        ]) }}
                />
            HTML;
    }
}

<?php

use BDS\Models\Site;
use Livewire\Volt\Component;

new class extends Component
{
    /**
     * All the sites that below to the authenticated user.
     *
     * @var array
     */
    public array $sites = [];

    /**
     * The current site id to the authenticated user.
     *
     * @var int|null
     */
    public ?int $current_site_id = null;

    /**
     * Whatever the select is displayed on the sidebar or not. (Used for custom css class on sidebar)
     *
     * @var bool
     */
    public bool $sidebar = false;

    public function mount(bool $sidebar = false):void
    {
        $this->sidebar = $sidebar;
        $this->sites = auth()->user()->sites()->select('id', 'name')->orderBy('name')->get()->toArray();
        $this->current_site_id = session('current_site_id');
    }

    public function updatedCurrentSiteId(): void
    {
        $user = auth()->user();

        if ($user->current_site_id === $this->current_site_id) {
            return;
        }

        $newSiteId = $this->current_site_id;

        session()->put([
            'current_site_id' => $newSiteId
        ]);

        $user->current_site_id = $newSiteId;
        $user->save();

        $this->redirect(route('dashboard.index'));
    }
}; ?>

<div>
    @php
        $class = 'select font-bold min-w-fit ' .  ($sidebar === true ? 'border-transparent bg-[#364150] dark:bg-base-200 dark:text-slate-300' : 'bg-zinc-100 dark:bg-base-200 border-transparent ');
    @endphp
    <x-select
        name="current_site_id"
        icon="fas-map-marker-alt"
        :class="$class"
        :options="$sites"
        wire:model.live="current_site_id"
    />
</div>

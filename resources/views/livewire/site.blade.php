<?php

use BDS\Models\Site;
use Livewire\Volt\Component;

new class extends Component
{
    public array $sites = [];

    public ?int $current_site_id = null;

    public function mount():void
    {
        $this->sites = auth()->user()->sites()->orderBy('name')->pluck('name', 'id')->toArray();
        $this->current_site_id = session('current_site_id');
    }

    public function updatedCurrentSiteId()
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
    <select wire:model.live="current_site_id" name="current_site_id" class="select w-full font-bold">
        @foreach($sites as $siteId => $siteName)
            <option  value="{{ $siteId }}">{{$siteName}}</option>
        @endforeach
    </select>
</div>

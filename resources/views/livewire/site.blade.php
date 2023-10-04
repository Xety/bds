<?php

use BDS\Models\Site;
use Livewire\Volt\Component;

new class extends Component
{
    public $sites;
    public $current_site_id;

    public function mount():void
    {
        $this->sites = auth()->user()->sites()->pluck('name', 'id')->toArray();
        $this->current_site_id = auth()->user()->current_site_id;
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
        //setPermissionsTeamId(session('current_site_id'));
        //app(\Spatie\Permission\PermissionRegistrar::class)->setPermissionsTeamId(session('current_site_id'));

        $user->current_site_id = $newSiteId;
        $user->save();

        $this->redirect(route('dashboard.index'));
    }
}; ?>

<div>
    <select wire:model.live="current_site_id" name="current_site_id" class="select select-md w-full font-bold">
        @foreach($sites as $siteId => $siteName)
            <option  value="{{ $siteId }}">{{$siteName}}</option>
        @endforeach
    </select>
</div>

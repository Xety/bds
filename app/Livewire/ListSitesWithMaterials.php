<?php

namespace BDS\Livewire;

use BDS\Models\Site;
use BDS\Models\User;
use Livewire\Component;

class ListSitesWithMaterials extends Component
{
    public function placeholder()
    {
        return view('livewire.placeholders.skeleton');
    }

    public function render()
    {
        //dd( auth()->user()->sites()->allRelatedIds()->toArray());
        $sites = Site::with('zones', 'zones.materials', 'zones.children')
            ->whereIn('id', auth()->user()->sites()->allRelatedIds()->toArray())
            ->orderBy('name')
            ->get();

        return view('livewire.list-sites-with-materials', [
            'sites' => $sites
        ]);
    }
}

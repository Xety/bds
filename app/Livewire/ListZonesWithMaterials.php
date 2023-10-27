<?php

namespace BDS\Livewire;

use BDS\Models\Zone;
use Livewire\Component;

class ListZonesWithMaterials extends Component
{
    public function render()
    {
        $zones = Zone::query()
            ->with('materials', 'children', 'children.materials')
            ->whereRelation('site', 'id', session('current_site_id'))
            ->whereNull('parent_id')
            ->get();
        return view('livewire.list-zones-with-materials', ['zones' => $zones]);
    }
}

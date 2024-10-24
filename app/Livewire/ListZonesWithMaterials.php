<?php

namespace BDS\Livewire;

use BDS\Models\Zone;
use Illuminate\View\View;
use Livewire\Component;

class ListZonesWithMaterials extends Component
{
    public function placeholder(): View
    {
        return view('livewire.placeholders.skeleton');
    }

    public function render(): View
    {
        $zones = Zone::query()
            ->with('materials', 'materials.zone', 'children', 'children.materials')
            ->whereRelation('site', 'id', getPermissionsTeamId())
            ->whereNull('parent_id')
            ->get();

        return view('livewire.list-zones-with-materials', ['zones' => $zones]);
    }
}

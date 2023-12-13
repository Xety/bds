<?php

use BDS\Models\Material;
use Illuminate\Support\Collection;
use Livewire\Volt\Component;

new class extends Component {

    // Selected option
    public ?array $users_multi_searchable_ids = [];

    // Options list
    public Collection $usersMultiSearchable;

    public function mount()
    {
        // Fill options when component first renders
        $this->search();
    }

    // Also called as you type
    public function search(string $value = '')
    {
        // Besides the search results, you must include on demand selected option
        $selectedOption = Material::whereIn('id', $this->users_multi_searchable_ids)->get();

        $this->usersMultiSearchable = Material::query()
            ->where('name', 'like', "%$value%")
            ->take(5)
            ->orderBy('name')
            ->get()
            ->merge($selectedOption);     // <-- Adds selected option
    }
}
?>

<div>
    <x-choices
        label="Searchable + Multiple"
        wire:model="users_multi_searchable_ids"
        :options="$usersMultiSearchable"
        search-function="search"
        no-result-text="Aucun résultat..."
        debounce="300ms"
        min-chars="2"
        searchable>
        {{-- Item slot--}}
        @scope('item', $option)
            <x-list-item :item="$option">
                <x-slot:avatar>
                    <x-icon name="fas-microchip" class="bg-blue-100 p-2 w-8 h-8 rounded-full" />
                </x-slot:avatar>

                <x-slot:value>
                    {{ $option->name }} ({{ $option->id }})
                </x-slot:value>

                <x-slot:sub-value>
                    {{ $option->zone->site->name }}
                </x-slot:sub-value>

                <x-slot:actions>
                    {{ $option->zone->name }}
                </x-slot:actions>
            </x-list-item>
        @endscope

        {{-- Selection slot--}}
        @scope('selection', $option)
        {{ $option->name }} ({{ $option->id }})
        @endscope
    </x-choices>
</div>

@can('search', \BDS\Models\Selvah\CorrespondenceSheet::class)
    <div class="grid grid-cols-12 gap-4 shadow-md border rounded-lg p-3 border-gray-200 dark:border-gray-700 bg-base-100 dark:bg-base-300">
        <div class="col-span-12 xl:col-span-4">
            <x-input
                class="min-w-max"
                wire:model.live.debounce.400ms="filters.user_id"
                name="filters.user_id"
                type="text"
                label="Opérateur"
            />
        </div>
        <div class="col-span-12 xl:col-span-4">
            <x-input
                class="min-w-max"
                wire:model.live.debounce.400ms="filters.bmp2_numero_lot"
                name="filters.bmp2_numero_lot"
                type="text"
                label="Numéro lot BMP2"
            />
        </div>

        <div class="col-span-12 xl:col-span-4">
            <x-select
                :options="\BDS\Enums\Selvah\Postes::toSelectArray()"
                class="select-primary min-w-max"
                wire:model.live="filters.poste_type"
                name="filters.poste_type"
                label="Type de poste"
            />
        </div>
        <div class="col-span-12 xl:col-span-4">
            <x-input
                class="min-w-max"
                wire:model.live.debounce.400ms="filters.btf1_numero_lot"
                name="filters.btf1_numero_lot"
                type="text"
                label="Numéro lot BTF1"
            />
        </div>
        <div class="col-span-12 xl:col-span-4">
            <x-input
                class="min-w-max"
                wire:model.live.debounce.400ms="filters.bmp1_numero_lot"
                name="filters.bmp1_numero_lot"
                type="text"
                label="Numéro lot BMP1"
            />
        </div>

        <div class="col-span-12 xl:col-span-4">
            <x-input
                class="min-w-max"
                wire:model.live.debounce.250ms="filters.compteur_huile_brute_min"
                name="filters.compteur_huile_brute_min"
                class="input-sm"
                placeholder="Mini"
                type="number"
                min="0"
                step="1"
                label="Compteur huile brute Min/Max"
            />
            <x-input
                class="min-w-max"
                wire:model.live.debounce.250ms="filters.compteur_huile_brute_max"
                name="filters.compteur_huile_brute_max"
                class="input-sm mt-2"
                placeholder="Maxi"
                type="number"
                min="0"
                step="1"
            />
        </div>

        <div class="col-span-12 xl:col-span-4">
            @php
                $options = [
                    [
                        'id' => '',
                        'name' => 'Tous'
                    ],
                    [
                        'id' => 'yes',
                        'name' => 'Oui'
                    ],
                    [
                        'id' => 'no',
                        'name' => 'Non'
                    ]
                ];
            @endphp
            <x-select
                :options="$options"
                class="select-primary min-w-max"
                wire:model.live="filters.filtration_nettoyage_filtre"
                name="filters.filtration_nettoyage_filtre"
                label="Nettoyage plateaux de filtration"
            />
        </div>

        <div class="col-span-12 xl:col-span-4">
            <x-input
                class="min-w-max"
                wire:model.live.debounce.400ms="filters.filtration_commentaire"
                name="filters.filtration_commentaire"
                type="text"
                label="Filtration remarques"
            />
        </div>

        <div class="col-span-12 xl:col-span-4">
            <x-input
                class="min-w-max"
                wire:model.live.debounce.400ms="filters.ns1_numero_lot"
                name="filters.ns1_numero_lot"
                type="text"
                label="Numéro lot NS1"
            />
        </div>


    </div>
@endcan

<div>
    <x-modal wire:model="showQrCodeModal" title="Scan de QR Code">
        <div class=" mb-3 flex flex-col items-center">
            @if ($type == 'material')
                <div class="mb-3">
                    Le QR Code que vous venez de scanner correspond au matériel :
                </div>
                <div class="flex flex-col items-center">
                    <x-icon name="fas-microchip" class="w-16 h-16"></x-icon>
                    <span class="block font-bold text-2xl">
                        {{ $model?->name }}
                    </span>
                    <div class="mt-4 text-center">
                        <span class="block mb-4">sur le site :</span>
                        <figure class="px-10">
                            @if ($model?->zone->site->id == settings('site_id_selvah'))
                                <img src="{{ asset('images/logos/selvah.png') }}" alt="Selvah Logo" class="inline-block w-20">
                            @elseif ($model?->zone->site->id == settings('site_id_extrusel'))
                                <img src="{{ asset('images/logos/extrusel.png') }}" alt="Extrusel Logo" class="inline-block w-28">
                            @elseif ($model?->zone->site->id == settings('site_id_moulin_jannet'))
                                <img src="{{ asset('images/logos/moulin_jannet.png') }}" alt="Moulin Jannet Logo" class="inline-block w-16">
                            @elseif ($model?->zone->site->id == settings('site_id_val_union'))
                                <img src="{{ asset('images/logos/bfc_val_union.png') }}" alt="BFC Val Union Logo" class="inline-block dark:hidden h-14">
                                <img src="{{ asset('images/logos/bfc_val_union_blanc.png') }}" alt="BFC Val Union Logo" class="hidden dark:inline-block h-14">
                            @else
                                <img src="{{ asset('images/logos/cbds_324x383.png') }}" alt="Coopérative Bourgogne du Sud Logo" class="inline-block w-20">
                            @endif
                        </figure>
                        <span class="block font-bold text-2xl">
                            {{ $model?->zone->site->name }}
                        </span>
                    </div>
                </div>
            @elseif($type == 'part')
                <div class="mb-3">
                    Le QR Code que vous venez de scanner correspond à la pièce détachée :
                </div>
                <div class="flex flex-col items-center">
                    <x-icon name="fas-gear" class="w-16 h-16"></x-icon>
                    <span class="block font-bold text-2xl">{{ $model?->name }}</span>
                    <div class="mt-4 text-center">
                        <span class="block mb-4">sur le site :</span>
                        <figure class="px-10">
                            @if ($model?->site->id == settings('site_id_selvah'))
                                <img src="{{ asset('images/logos/selvah.png') }}" alt="Selvah Logo" class="inline-block w-20">
                            @elseif ($model?->site->id == settings('site_id_extrusel'))
                                <img src="{{ asset('images/logos/extrusel.png') }}" alt="Extrusel Logo" class="inline-block w-28">
                            @elseif ($model?->site->id == settings('site_id_moulin_jannet'))
                                <img src="{{ asset('images/logos/moulin_jannet.png') }}" alt="Moulin Jannet Logo" class="inline-block w-16">
                            @elseif ($model?->site->id == settings('site_id_val_union'))
                                <img src="{{ asset('images/logos/bfc_val_union.png') }}" alt="BFC Val Union Logo" class="inline-block dark:hidden h-14">
                                <img src="{{ asset('images/logos/bfc_val_union_blanc.png') }}" alt="BFC Val Union Logo" class="hidden dark:inline-block h-14">
                            @else
                                <img src="{{ asset('images/logos/cbds_324x383.png') }}" alt="Coopérative Bourgogne du Sud Logo" class="inline-block w-20">
                            @endif
                        </figure>
                        <span class="block font-bold text-2xl">
                            {{ $model?->site->name }}
                        </span>
                    </div>
                </div>
            @endif
        </div>

        @if (array_key_exists($type, $this->types))
            @php
                $options = [];

                foreach ($types[$type]['permission'] as $key => $value) {
                    $options[] = [
                    'id' => $key,
                    'name' => $value
                    ];
                }
            @endphp

            <x-select
                :options="$options"
                class="select-primary"
                wire:model.live="action"
                name="action"
                label="Type de fiche à créer"
                placeholder="Sélectionnez le type"
            />
        @endif

        <x-slot:actions>
            <x-button class="btn btn-success gap-2" type="button" wire:click="redirection" spinner :disabled="empty($action)">
                <x-icon name="fas-plus" class="h-5 w-5"></x-icon>
                Créer
            </x-button>
            <x-button @click="$wire.showQrCodeModal = false" class="btn btn-neutral">
                Fermer
            </x-button>
        </x-slot:actions>
    </x-modal>
</div>

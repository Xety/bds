<div>
    <x-modal wire:model="showQrCodeModal" title="Scan de QR Code">
        <div class="text-gray-600 mb-3 flex flex-col items-center">
            @if ($type == 'material')
                <div class="mb-3">
                    Le QR Code que vous avez scanné correspond au matériel :
                </div>
                <div class="font-bold text-2xl text-center">
                    <x-icon name="fas-microchip" class="text-4xl"></x-icon>
                    <span class="block">{{ $model?->name }}</span>
                </div>
            @elseif($type == 'part')
                <div class="mb-3">
                    Le QR Code que vous avez scanné correspond à la pièce détachée :
                </div>
                <div class="font-bold text-2xl text-center">
                    <x-icon name="fas-gear" class="text-4xl"></x-icon>
                    <span class="block">{{ $model?->name }}</span>
                </div>
            @endif
        </div>

        @if (array_key_exists($type, $this->types))
            @php
                $options = [];

                foreach ($types[$type]['actions'] as $key => $value) {
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
            <x-button @click="$wire.showDeleteModal = false" class="btn btn-neutral">
                Fermer
            </x-button>
        </x-slot:actions>
    </x-modal>
</div>

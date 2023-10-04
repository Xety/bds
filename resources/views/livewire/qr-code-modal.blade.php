<div>
    <form wire:submit.prevent="redirection">
        <input type="checkbox" id="QrCodeModal" class="modal-toggle" wire:model="showQrCodeModal" />
        <label for="QrCodeModal" class="modal cursor-pointer">
            <label class="modal-box relative">
                <label for="QrCodeModal" class="btn btn-sm btn-circle absolute right-2 top-2">✕</label>
                <h3 class="font-bold text-lg mb-2">
                    Scan de QR Code
                </h3>

                <div class="text-gray-600 mb-3 flex flex-col items-center">
                    @if ($type == 'material')
                        <div class="mb-3">
                            Le QR Code que vous avez scanné correspond au matériel :
                        </div>
                        <div class="font-bold text-2xl text-center">
                            <i class="fa-solid fa-microchip text-5xl"></i> <br><span>{{ $model?->name }}</span>
                        </div>
                    @elseif($type == 'part')
                        <div class="mb-3">
                            Le QR Code que vous avez scanné correspond à la pièce détachée :
                        </div>
                        <div class="font-bold text-2xl text-center">
                            <i class="fa-solid fa-gear text-5xl"></i> <br><span>{{ $model?->name }}</span>
                        </div>
                    @endif
                </div>

                @if (array_key_exists($type, $this->types))
                    <x-form.select wire:model.defer="action" name="action"  label="Type de fiche à créer">
                        <option value="" disabled>Sélectionnez le type</option>
                        @foreach($types[$type]['actions'] as $key => $value)
                        <option value="{{ $key }}">{{$value}}</option>
                        @endforeach
                    </x-form.select>
                @endif


                <div class="modal-action">
                    <button type="submit" class="btn btn-success gap-2">
                        <i class="fa-solid fa-plus"></i> Créer
                    </button>
                    <label for="QrCodeModal" class="btn btn-neutral">Fermer</label>
                </div>
            </label>
        </label>
    </form>
</div>

<div>
    <x-button type="button" class="btn btn-info gap-2" wire:click="$toggle('showSignModal')" spinner>
        <x-icon name="fas-file-signature" class="h-5 w-5"></x-icon>
        Signer la fiche
    </x-button>

    <!-- Sign Modal -->
    <x-modal wire:model="showSignModal" title="Signer la Fiche de Correspondance">

        @php $message = "Si vous avez des informations complémentaires à renseigner, veuillez le faire dans la case ci-dessous.";@endphp
        <x-textarea wire:model="responsable_commentaire" name="responsable_commentaire" label="Remarques éventuelles..." placeholder="Remarques éventuelles..." rows="3" :label-info="$message" />

        <x-slot:actions>
            <x-button class="btn btn-info gap-2" type="button" wire:click="signSheet" spinner>
                <x-icon name="fas-file-signature" class="h-5 w-5"></x-icon>
                Signer
            </x-button>
            <x-button @click="$wire.showSignModal = false" class="btn btn-neutral">
                Fermer
            </x-button>
        </x-slot:actions>
    </x-modal>
</div>

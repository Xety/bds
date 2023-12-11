<div>
    <div class="flex flex-col lg:flex-row gap-4 justify-between">
        <div>
            @canany(['export', 'delete'], \BDS\Models\Part::class)
                <div class="dropdown">
                    <label tabindex="0" class="btn btn-neutral m-1">
                        Actions
                        <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-caret-down-fill align-bottom" viewBox="0 0 16 16">
                            <path d="M7.247 11.14 2.451 5.658C1.885 5.013 2.345 4 3.204 4h9.592a1 1 0 0 1 .753 1.659l-4.796 5.48a1 1 0 0 1-1.506 0z"/>
                        </svg>
                    </label>
                    <ul tabindex="0" class="dropdown-content menu p-2 shadow bg-base-100 rounded-box w-52 z-[1]">
                        @can('export', \BDS\Models\Part::class)
                            <li>
                                <button type="button" class="text-blue-500" wire:click="exportSelected()">
                                    <x-icon name="fas-download" class="h-5 w-5"></x-icon>
                                    Exporter
                                </button>
                            </li>
                        @endcan
                        @can('delete', \BDS\Models\Part::class)
                            <li>
                                <button type="button" class="text-red-500" wire:click="$toggle('showDeleteModal')">
                                    <x-icon name="fas-trash-can" class="h-5 w-5"></x-icon>
                                    Supprimer
                                </button>
                            </li>
                        @endcan
                    </ul>
                </div>
            @endcanany
        </div>
        <div class="mb-4">
            @if (settings('part_create_enabled', true) && auth()->user()->can('create', \BDS\Models\Part::class))
                <x-button type="button" class="btn btn-success gap-2" wire:click="create" spinner>
                    <x-icon name="fas-plus" class="h-5 w-5"></x-icon>
                    Nouvelle Pièce Détachée
                </x-button>
            @endif
        </div>
    </div>

    <x-table.table class="mb-6">
        <x-slot name="head">
            @canany(['export', 'delete'], \BDS\Models\Part::class)
                <x-table.heading>
                    <label>
                        <input type="checkbox" class="checkbox" wire:model.live="selectPage" />
                    </label>
                </x-table.heading>
            @endcanany

            @if (
                Gate::any(['update', 'generateQrCode'], \BDS\Models\Part::class) ||
                Gate::any(['create'], \BDS\Models\PartEntry::class) ||
                Gate::any(['create'], \BDS\Models\PartExit::class))
                <x-table.heading>Actions</x-table.heading>
            @endif

            <x-table.heading sortable wire:click="sortBy('name')" :direction="$sortField === 'name' ? $sortDirection : null" class="min-w-[250px]">Nom</x-table.heading>
            <x-table.heading>Materials</x-table.heading>
            <x-table.heading>Site</x-table.heading>
            <x-table.heading sortable wire:click="sortBy('description')" :direction="$sortField === 'description' ? $sortDirection : null">Description</x-table.heading>
            <x-table.heading sortable wire:click="sortBy('user_id')" :direction="$sortField === 'user_id' ? $sortDirection : null">Enregistré<br> par</x-table.heading>
            <x-table.heading sortable wire:click="sortBy('reference')" :direction="$sortField === 'reference' ? $sortDirection : null">Référence</x-table.heading>
            <x-table.heading sortable wire:click="sortBy('supplier')" :direction="$sortField === 'supplier' ? $sortDirection : null">Fournisseur</x-table.heading>
            <x-table.heading sortable wire:click="sortBy('price')" :direction="$sortField === 'price' ? $sortDirection : null">Prix Unitaire</x-table.heading>
            <x-table.heading>Nombre en stock</x-table.heading>
            <x-table.heading sortable wire:click="sortBy('number_warning_enabled')" :direction="$sortField === 'number_warning_enabled' ? $sortDirection : null">Alerte<br> activée</x-table.heading>
            <x-table.heading sortable wire:click="sortBy('number_critical_enabled')" :direction="$sortField === 'number_critical_enabled' ? $sortDirection : null">Alerte critique<br> activée</x-table.heading>
            <x-table.heading sortable wire:click="sortBy('material_count')" :direction="$sortField === 'material_count' ? $sortDirection : null">Nombre <br>de matériels</x-table.heading>
            <x-table.heading sortable wire:click="sortBy('part_entry_count')" :direction="$sortField === 'part_entry_count' ? $sortDirection : null">Nombre <br>d'entrées</x-table.heading>
            <x-table.heading sortable wire:click="sortBy('part_exit_count')" :direction="$sortField === 'part_exit_count' ? $sortDirection : null">Nombre <br>de sorties</x-table.heading>
            <x-table.heading sortable wire:click="sortBy('created_at')" :direction="$sortField === 'created_at' ? $sortDirection : null">Créé le</x-table.heading>
        </x-slot>

        <x-slot name="body">
            @if ($selectPage)
                <x-table.row wire:key="row-message">
                    <x-table.cell colspan="17">
                        @unless ($selectAll)
                            <div>
                                <span>Vous avez sélectionné <strong>{{ $parts->count() }}</strong> pièce(s) détachée(s), voulez-vous tous les sélectionner <strong>{{ $parts->total() }}</strong>?</span>
                                <button type="button" wire:click="selectAll" class="btn btn-neutral btn-sm gap-2 ml-1">
                                    <i class="fa-solid fa-check"></i>
                                    Tout sélectionner
                                </button>
                            </div>
                        @else
                            <span>Vous sélectionnez actuellement <strong>{{ $parts->total() }}</strong> pièce(s) détachée(s).</span>
                        @endif
                    </x-table.cell>
                </x-table.row>
            @endif

            @forelse($parts as $part)
                <x-table.row wire:loading.class.delay="opacity-50" wire:key="row-{{ $part->getKey() }}">
                    @canany(['export', 'delete'], \BDS\Models\Part::class)
                        <x-table.cell>
                            <label>
                                <input type="checkbox" class="checkbox" wire:model="selected" value="{{ $part->getKey() }}" />
                            </label>
                        </x-table.cell>
                    @endcanany

                    @if (Gate::any(['update', 'generateQrCode'], $part) ||
                        Gate::any(['create'], \BDS\Models\PartEntry::class) ||
                        Gate::any(['create'], \BDS\Models\PartExit::class))
                        <x-table.cell>
                            <x-dropdown top hover class="w-60">
                                <x-slot:trigger>
                                    <x-icon name="fas-ellipsis" class="h-5 w-5 cursor-pointer"></x-icon>
                                </x-slot:trigger>

                                @can('update', $part)
                                    <x-menu-item
                                        title="Modifier cette pièce détachée"
                                        icon="fas-pen-to-square"
                                        tooltip
                                        tooltip-content="Modifier cette pièce détachée"
                                        wire:click.prevent="edit({{ $part->getKey() }})" class="text-blue-500 text-left" />
                                @endcan
                                @can('generateQrCode', $part)
                                    <x-menu-item
                                        title="Générer un QR Code"
                                        icon="fas-qrcode"
                                        tooltip
                                        tooltip-content="Générer un QR Code pour cette pièce détachée"
                                        wire:click.prevent="showQrCode({{ $part->getKey() }})"
                                        class="text-purple-500" />
                                @endcan
                                @can('create', \BDS\Models\PartEntry::class)
                                    <x-menu-item
                                        wire:navigate
                                        title="Créer une Entrée"
                                        icon="fas-arrow-right-to-bracket"
                                        tooltip
                                        tooltip-content="Créer une entrée pour cette pièce détachée"
                                        link="{{ route('part-entries.index', ['partId' => $part->getKey(), 'creating' => 'true']) }}"
                                        class="text-red-500" />
                                @endcan
                                @can('create', \BDS\Models\PartExit::class)
                                    <x-menu-item
                                        wire:navigate
                                        title="Créer une Sortie"
                                        icon="fas-right-from-bracket"
                                        tooltip
                                        tooltip-content="Créer une sortie pour cette pièce détachée"
                                        link="{{ route('part-exits.index', ['partId' => $part->getKey(), 'creating' => 'true']) }}"
                                        class="text-yellow-500" />
                                @endcan
                            </x-dropdown>
                        </x-table.cell>
                    @endif

                    <x-table.cell>
                        <a class="link link-hover link-primary font-bold" href="{{ $part->show_url }}">
                            {{ $part->name }}
                        </a>
                    </x-table.cell>
                    <x-table.cell>
                        @foreach($part->materials as $material)
                            {{ $material->name }}<br>
                        @endforeach
                    </x-table.cell>
                    <x-table.cell>
                        {{ $part->site->name }}
                    </x-table.cell>
                    <x-table.cell>
                        <span class="tooltip tooltip-top text-left" data-tip="{{ $part->description }}">
                            {{ Str::limit($part->description, 50) }}
                        </span>
                    </x-table.cell>
                    <x-table.cell>
                        {{ $part->user->full_name }}
                    </x-table.cell>
                    <x-table.cell>
                        <code class="code rounded-sm">
                            {{ $part->reference}}
                        </code>
                    </x-table.cell>
                    <x-table.cell>{{ $part->supplier }}</x-table.cell>
                    <x-table.cell>
                        <code class="code rounded-sm">
                            {{ $part->price }}€
                        </code>
                    </x-table.cell>
                    <x-table.cell>
                        <code class="code rounded-sm">
                            {{ $part->stock_total }}
                        </code>
                    </x-table.cell>
                    <x-table.cell>
                        @if ($part->number_warning_enabled)
                            <span class="font-bold text-red-500">Oui</span>
                        @else
                            <span class="font-bold text-green-500">Non</span>
                        @endif
                    </x-table.cell>
                    <x-table.cell>
                        @if ($part->number_critical_enabled)
                            <span class="font-bold text-red-500">Oui</span>
                        @else
                            <span class="font-bold text-green-500">Non</span>
                        @endif
                    </x-table.cell>
                    <x-table.cell>
                        <code class="code rounded-sm">
                            {{ $part->material_count }}
                        </code>
                    </x-table.cell>
                    <x-table.cell>
                        <code class="code rounded-sm">
                            {{ $part->part_entry_count }}
                        </code>
                    </x-table.cell>
                    <x-table.cell>
                        <code class="code rounded-sm">
                            {{ $part->part_exit_count }}
                        </code>
                    </x-table.cell>
                    <x-table.cell class="capitalize">
                        {{ $part->created_at->translatedFormat( 'D j M Y H:i') }}
                    </x-table.cell>
                </x-table.row>
            @empty
                <x-table.row>
                    <x-table.cell colspan="17">
                        <div class="text-center p-2">
                            <span class="text-muted">Aucune pièce détachée trouvée...</span>
                        </div>
                    </x-table.cell>
                </x-table.row>
            @endforelse
        </x-slot>
    </x-table.table>

    <div class="grid grid-cols-1">
        {{ $parts->links() }}
    </div>


    <!-- Delete Parts Modal -->
    <x-modal wire:model="showDeleteModal" title="Supprimer les Pièces Détachées">
        @if (empty($selected))
            <p class="my-7">
                Vous n'avez sélectionné aucune pièce détachée à supprimer.
            </p>
        @else
            <p class="my-7">
                Voulez-vous vraiment supprimer ces pièces détachées ? <span class="font-bold text-red-500">Cette opération n'est pas réversible.</span>
            </p>
        @endif

        <x-slot:actions>
            <x-button class="btn btn-error gap-2" type="button" wire:click="deleteSelected" spinner :disabled="empty($selected)">
                <x-icon name="fas-trash-can" class="h-5 w-5"></x-icon>
                Supprimer
            </x-button>
            <x-button @click="$wire.showDeleteModal = false" class="btn btn-neutral">
                Fermer
            </x-button>
        </x-slot:actions>
    </x-modal>

    <!-- Create/Edit Parts Modal -->
    <x-modal wire:model="showModal" title="{{ $isCreating ? 'Créer une Pièce Détachée' : 'Editer la Pièce Détachée' }}">

        <x-input wire:model="form.name" name="form.name" label="Nom" placeholder="Nom de la pièce détachée..." type="text" />

        @php $message = "Sélectionnez le(s) matériel(s) auquel appartient la pièce détachée.<br><i>Note: si la pièce détachée appartient à aucun matériel, sélectionnez <b>\"Aucun matériel\"</b></i> ";@endphp
        <x-select
            :options="$materials"
            class="select-primary"
            wire:model="form.materials"
            name="form.materials"
            label="Materiel"
            :label-info="$message"
            placeholder="Aucun Matériel"
            multiple=""
        />

        <x-slot:actions>
            <x-button class="btn btn-success gap-2" type="button" wire:click="save" spinner>
                @if($isCreating)
                    <x-icon name="fas-user-plus" class="h-5 w-5"></x-icon> Créer
                @else
                    <x-icon name="fas-user-pen" class="h-5 w-5"></x-icon> Editer
                @endif
            </x-button>
            <x-button @click="$wire.showModal = false" class="btn btn-neutral">
                Fermer
            </x-button>
        </x-slot:actions>
    </x-modal>

    <!-- QrCode Matériels Modal -->
    <x-modal wire:model="showQrCodeModal" title="Générer un QR Code">

        <span class="text-sm mb-3">
            Le QR Code sera généré pour la pièce détachée <span class="font-bold">{{ $modelQrCode?->name }}</span>
        </span>

        <div class="form-control">
            <label class="label" for="size">
                <span class="label-text">Taille</span>
                <span class="label-text-alt">
                    <div class="dropdown dropdown-hover dropdown-bottom dropdown-end">
                        <label tabindex="0" class="hover:cursor-pointer text-info">
                            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" class="w-4 h-4 stroke-current"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                        </label>
                        <div tabindex="0" class="card compact dropdown-content z-[1] shadow bg-base-100 dark:bg-base-200 rounded-box w-64">
                            <div class="card-body">
                                <p>
                                    Sélectionnez la taille du QR Code généré : <br/>
                                        <b>Très Petit</b> (100 pixels)<br/>
                                        <b>Petit</b> (150 pixels)<br/>
                                        <b>Normal</b> (200 pixels)<br/>
                                        <b>Moyen</b> (300 pixels)<br/>
                                        <b>Grand</b> (400 pixels)<br/>
                                        <b>Très Grand</b> (500 pixels)<br/>
                                </p>
                            </div>
                        </div>
                    </div>
                </span>
            </label>
        </div>
        @foreach ($allowedQrCodeSize as $key => $value)
            <x-form.radio wire:model.live="qrCodeSize" value="{{ $key }}" name="size">
                {{ $value['text'] }}
            </x-form.radio>
        @endforeach

        <x-input wire:model.live="qrCodeLabel" name="qrCodeLabel" label="Label du QR Code" placeholder="Texte du label..." type="text" />

        <div>
            <div class="flex justify-center my-3">
                <img id="qrCodeImg" src="{{ $qrCodeImg }}" alt="QR Code image" />
            </div>
        </div>

        <x-slot:actions>
            <a href="#" class="btn btn-info gap-2" onclick="printJS(document.getElementById('qrCodeImg').src, 'image');return false;">
                <x-icon name="fas-print" class="h-5 w-5"></x-icon> Imprimer
            </a>
            <a href="{{ $qrCodeImg }}" download="qrcode_{{ \Illuminate\Support\Str::slug($modelQrCode?->name) }}.png" class="btn btn-success gap-2">
                <x-icon name="fas-download" class="h-5 w-5"></x-icon> Télécharger
            </a>
            <x-button @click="$wire.showQrCodeModal = false" class="btn btn-neutral">
                Fermer
            </x-button>
        </x-slot:actions>
    </x-modal>
</div>

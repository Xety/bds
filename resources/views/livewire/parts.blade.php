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
                                <button type="button" class="text-red-500" wire:click="exportSelected()">
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

    @if ($showFilters)
        <div class="flex flex-col md:flex-row rounded shadow-inner relative mb-4 bg-slate-100 dark:bg-base-200">
            <div class="w-full md:w-1/2 p-4">
                <x-form.select wire:model="filters.creator" label="Créateur">
                    <option value="" disabled>Sélectionnez un créateur</option>
                    @foreach($users as $userId => $userUsername)
                        <option  value="{{ $userId }}">{{$userUsername}}</option>
                    @endforeach
                </x-form.select>

                <x-form.select wire:model="filters.material" label="Materiel">
                    <option  value="" disabled>Sélectionnez le matériel</option>
                    @foreach($materials as $materialId => $materialName)
                        <option  value="{{ $materialId }}">{{$materialName}}</option>
                    @endforeach
                </x-form.select>
            </div>

            <div class="w-full md:w-1/2 p-4 mb-11">
                <x-form.date wire:model="filters.created-min" label="Minimum date de création"  :join="true" :joinIcon="'fa-solid fa-calendar'" placeholder="Sélectionnez une date..." />
                <x-form.date wire:model="filters.created-max" label="Maximum date de création"  :join="true" :joinIcon="'fa-solid fa-calendar'" placeholder="Sélectionnez une date..." />

                <button wire:click="resetFilters" type="button" class="btn btn-error btn-sm absolute right-4 bottom-4">
                    <i class="fa-solid fa-eraser"></i>Réinitialiser les filtres
                </button>
            </div>
        </div>
    @endif

    <x-table.table class="mb-6" containerClass="py-20">
        <x-slot name="head">
            @canany(['export', 'delete'], \Selvah\Models\Part::class)
                <x-table.heading>
                    <label>
                        <input type="checkbox" class="checkbox" wire:model="selectPage" />
                    </label>
                </x-table.heading>
            @endcanany

            @if (
                Gate::any(['update', 'generateQrCode'], \Selvah\Models\Part::class) ||
                Gate::any(['create'], \Selvah\Models\PartEntry::class) ||
                Gate::any(['create'], \Selvah\Models\PartExit::class))
                <x-table.heading>Actions</x-table.heading>
            @endif

            <x-table.heading sortable wire:click="sortBy('name')" :direction="$sortField === 'name' ? $sortDirection : null" class="min-w-[250px]">Nom</x-table.heading>
            <x-table.heading sortable wire:click="sortBy('material_id')" :direction="$sortField === 'material_id' ? $sortDirection : null">Matériel</x-table.heading>
            <x-table.heading sortable wire:click="sortBy('description')" :direction="$sortField === 'description' ? $sortDirection : null">Description</x-table.heading>
            <x-table.heading sortable wire:click="sortBy('user_id')" :direction="$sortField === 'user_id' ? $sortDirection : null">Enregistré<br> par</x-table.heading>
            <x-table.heading sortable wire:click="sortBy('reference')" :direction="$sortField === 'reference' ? $sortDirection : null">Référence</x-table.heading>
            <x-table.heading sortable wire:click="sortBy('supplier')" :direction="$sortField === 'supplier' ? $sortDirection : null">Fournisseur</x-table.heading>
            <x-table.heading sortable wire:click="sortBy('price')" :direction="$sortField === 'price' ? $sortDirection : null">Prix Unitaire</x-table.heading>
            <x-table.heading>Nombre en stock</x-table.heading>
            <x-table.heading sortable wire:click="sortBy('number_warning_enabled')" :direction="$sortField === 'number_warning_enabled' ? $sortDirection : null">Alerte<br> activée</x-table.heading>
            <x-table.heading sortable wire:click="sortBy('number_critical_enabled')" :direction="$sortField === 'number_critical_enabled' ? $sortDirection : null">Alerte critique<br> activée</x-table.heading>
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
                                <span>Vous avez sélectionné <strong>{{ $parts->count() }}</strong> pièce(s) détachée(s), voulez-vous tous les selectionner <strong>{{ $parts->total() }}</strong>?</span>
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
                    @canany(['export', 'delete'], \Selvah\Models\Part::class)
                        <x-table.cell>
                            <label>
                                <input type="checkbox" class="checkbox" wire:model="selected" value="{{ $part->getKey() }}" />
                            </label>
                        </x-table.cell>
                    @endcanany

                    @if (
                        Gate::any(['update', 'generateQrCode'], \Selvah\Models\Part::class) ||
                        Gate::any(['create'], \Selvah\Models\PartEntry::class) ||
                        Gate::any(['create'], \Selvah\Models\PartExit::class))
                        <x-table.cell>
                            <div class="dropdown dropdown-right
                                @if ($loop->index >= ($loop->count - 2))
                                    dropdown-end
                                @else
                                    dropdown-bottom
                                @endif
                            ">
                                <label tabindex="0" class="btn btn-ghost btn-sm m-1">
                                    <i class="fa-solid fa-ellipsis"></i>
                                </label>
                                <ul tabindex="0" class="dropdown-content menu items-start p-2 shadow bg-base-100 rounded-box w-52 z-[1]">
                                    @can('update', \Selvah\Models\Part::class)
                                        <li class="w-full">
                                            <a href="#" wire:click.prevent="edit({{ $part->getKey() }})" class="text-blue-500 tooltip tooltip-top text-left" data-tip="Modifier cette pièce détachée">
                                                <i class="fa-solid fa-pen-to-square"></i> Modifier cette pièce
                                            </a>
                                        </li>
                                    @endcan
                                    @can('generateQrCode', \Selvah\Models\Part::class)
                                        <li class="w-full">
                                            <button type="button" class="text-purple-500 tooltip tooltip-top text-left" wire:click="showQrCode({{ $part->getKey() }})" data-tip="Générer un QR Code pour cette pièce détachée">
                                                <i class="fa-solid fa-qrcode"></i> Générer un QR Code
                                            </button>
                                        </li>
                                    @endcan
                                    @can('create', \Selvah\Models\PartEntry::class)
                                        <li class="w-full">
                                            <a href="{{ route('part-entries.index', ['qrcodeid' => $part->getKey(), 'qrcode' => 'true']) }}" class="text-green-500 tooltip tooltip-top text-left" data-tip="Créer une entrée pour cette pièce détachée">
                                                <i class="fa-solid fa-arrow-right-to-bracket"></i> Créer une Entrée
                                            </a>
                                        </li>
                                    @endcan
                                    @can('create', \Selvah\Models\PartExit::class)
                                        <li class="w-full">
                                            <a href="{{ route('part-exits.index', ['qrcodeid' => $part->getKey(), 'qrcode' => 'true']) }}" class="text-yellow-500 tooltip tooltip-top text-left" data-tip="Créer une sortie pour cette pièce détachée">
                                                <i class="fa-solid fa-right-from-bracket"></i> Créer une Sortie
                                            </a>
                                        </li>
                                    @endcan
                                </ul>
                            </div>
                        </x-table.cell>
                    @endif
                    <x-table.cell>
                        <a class="link link-hover link-primary font-bold" href="{{ $part->show_url }}">
                            {{ $part->name }}
                        </a>
                    </x-table.cell>
                    <x-table.cell>
                        @unless (is_null($part->material_id))
                            <a class="link link-hover link-primary font-bold" href="{{ $part->material->show_url }}">
                                {{ $part->material->name }}
                            </a>
                        @endunless
                    </x-table.cell>
                    <x-table.cell>
                        <span class="tooltip tooltip-top text-left" data-tip="{{ $part->description }}">
                            {{ Str::limit($part->description, 50) }}
                        </span>
                    </x-table.cell>
                    <x-table.cell>{{ $part->user->username }}</x-table.cell>
                    <x-table.cell class="prose">
                        <code class="text-neutral-content  bg-[color:var(--tw-prose-pre-bg)] rounded-sm">
                            {{ $part->reference}}
                        </code>
                    </x-table.cell>
                    <x-table.cell>{{ $part->supplier }}</x-table.cell>
                    <x-table.cell class="prose">
                        <code class="text-neutral-content bg-[color:var(--tw-prose-pre-bg)] rounded-sm">
                            {{ $part->price }}€
                        </code>
                    </x-table.cell>
                    <x-table.cell class="prose">
                        <code class="text-neutral-content  bg-[color:var(--tw-prose-pre-bg)] rounded-sm">
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
                    <x-table.cell class="prose">
                        <code class="text-neutral-content  bg-[color:var(--tw-prose-pre-bg)] rounded-sm">
                            {{ $part->part_entry_count }}
                        </code>
                    </x-table.cell>
                    <x-table.cell class="prose">
                        <code class="text-neutral-content  bg-[color:var(--tw-prose-pre-bg)] rounded-sm">
                            {{ $part->part_exit_count }}
                        </code>
                    </x-table.cell>
                    <x-table.cell class="capitalize">{{ $part->created_at->translatedFormat( 'D j M Y H:i') }}</x-table.cell>
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
    <form wire:submit.prevent="deleteSelected">
        <input type="checkbox" id="deleteModal" class="modal-toggle" wire:model="showDeleteModal" />
        <label for="deleteModal" class="modal cursor-pointer">
            <label class="modal-box relative">
                <label for="deleteModal" class="btn btn-sm btn-circle absolute right-2 top-2">✕</label>
                <h3 class="font-bold text-lg">
                    Supprimer les Pièces Détachées
                </h3>
                @if (empty($selected))
                    <p class="my-7">
                        Vous n'avez sélectionné aucune pièce détachée à supprimer.
                    </p>
                @else
                    <p class="my-7">
                        Voulez-vous vraiment supprimer ces pièces détachées ? <span class="font-bold text-red-500">Cette opération n'est pas réversible.</span>
                    </p>
                @endif
                <div class="modal-action">
                    <button type="submit" class="btn btn-error gap-2" @if (empty($selected)) disabled @endif>
                        <i class="fa-solid fa-trash-can"></i>
                        Supprimer
                    </button>
                    <label for="deleteModal" class="btn btn-neutral">Fermer</label>
                </div>
            </label>
        </label>
    </form>

    <!-- Edit Parts Modal -->
    <div>
        <form wire:submit.prevent="save">
            <input type="checkbox" id="editModal" class="modal-toggle" wire:model="showModal" />
            <label for="editModal" class="modal cursor-pointer">
                <label class="modal-box relative">
                    <label for="editModal" class="btn btn-sm btn-circle absolute right-2 top-2">✕</label>
                    <h3 class="font-bold text-lg">
                        {!! $isCreating ? 'Créer une Pièce Détachée' : 'Editer la Pièce Détachée' !!}
                    </h3>

                    <x-form.text wire:model.defer="model.name" id="name" name="model.name" label="Nom" placeholder="Nom de la pièce détachée..." />

                    @php $message = "Veuillez décrire au mieux la pièce détachée.";@endphp
                    <x-form.textarea wire:model.defer="model.description" name="model.description" label="Description" placeholder="Description de la pièce détachée..." :info="true" :infoText="$message" />

                    @php $message = "Sélectionnez le matériel auquel appartient la pièce détachée.<br><i>Note: si la pièce détachée appartient à aucun matériel, sélectionnez <b>\"Aucun matériel\"</b></i> ";@endphp
                    <x-select
                        :options="$materials"
                        class="select-primary"
                        wire:model.live="form.material_id"
                        name="form.material_id"
                        label="Materiel"
                        :label-info="$message"
                        placeholder="Sélectionnez un Matériel"
                    />

                    <x-form.text wire:model.defer="model.reference" id="reference" name="model.reference" label="Référence" placeholder="Référence de la pièce détachée..." />

                    <x-form.text wire:model.defer="model.supplier" id="supplier" name="model.supplier" label="Fournisseur" placeholder="Fournisseur de la pièce détachée..." />

                    @php $message = "Prix de la pièce détachée à l'unité, sans les centimes.";@endphp
                    <x-form.number wire:model.defer="model.price" id="price" name="model.price" label="Prix" placeholder="Prix de la pièce détachée..." :info="true" :infoText="$message" />

                    <x-form.checkbox wire:model="model.number_warning_enabled" wire:click="$toggle('numberWarningEnabled')" name="number_warning_enabled" label="Alerte de stock">
                        Cochez pour appliquer une alerte sur le stock
                    </x-form.checkbox>

                    @if ($form->numberWarningEnabled)
                        <x-form.number wire:model.defer="model.number_warning_minimum" id="price" name="model.number_warning_minimum" label="Quantité pour l'alerte" placeholder="Quantité pour l'alerte..." />
                    @endif

                    <x-form.checkbox wire:model="model.number_critical_enabled" wire:click="$toggle('numberCriticalEnabled')" name="number_critical_enabled" label="Alerte de stock critique">
                        Cochez pour appliquer une alerte critique sur le stock
                    </x-form.checkbox>

                    @if ($form->numberCriticalEnabled)
                        <x-form.number wire:model.defer="model.number_critical_minimum" id="price" name="model.number_critical_minimum" label="Quantité pour l'alerte critique" placeholder="Quantité pour l'alerte critique..." />
                    @endif

                    <div class="modal-action">
                        <button type="submit" class="btn btn-success gap-2">
                            {!! $isCreating ? '<i class="fa-solid fa-plus"></i> Créer' : '<i class="fa-solid fa-pen-to-square"></i> Editer' !!}
                        </button>
                        <label for="editModal" class="btn btn-neutral">Fermer</label>
                    </div>
                </label>
            </label>
        </form>
    </div>

    <!-- QrCode Matériels Modal -->
    <div>
        <form onsubmit="return false;">
            <input type="checkbox" id="QrCodeModal" class="modal-toggle" wire:model="showQrCodeModal" />
            <label for="QrCodeModal" class="modal cursor-pointer">
                <label class="modal-box relative">
                    <label for="QrCodeModal" class="btn btn-sm btn-circle absolute right-2 top-2">✕</label>
                    <h3 class="font-bold text-lg mb-2">
                        Générer un QR Code
                    </h3>

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
                        <x-form.radio wire:model="qrCodeSize" value="{{ $key }}" name="size">
                            {{ $value['text'] }}
                        </x-form.radio>
                    @endforeach

                    <x-form.text wire:model="qrCodeLabel" id="label" name="label" label="Label du QR Code" placeholder="Texte du label..." />

                    <div>
                        <div class="flex justify-center my-3">
                            <img id="qrCodeImg" src="{{ $qrCodeImg }}" alt="QR Code image" />
                        </div>
                    </div>

                    <div class="modal-action flex-col md:flex-row gap-2">
                        <a href="#" class="btn btn-info gap-2 !ml-0" onclick="printJS(document.getElementById('qrCodeImg').src, 'image');return false;">
                            <i class="fa-solid fa-print"></i> Imprimer
                        </a>
                        <a href="{{ $qrCodeImg }}" download="qrcode_{{ \Illuminate\Support\Str::slug($modelQrCode?->name) }}.png" class="btn btn-success gap-2 !ml-0">
                            <i class="fa-solid fa-download"></i> Télécharger
                        </a>
                        <label for="QrCodeModal" class="btn btn-neutral !ml-0">Fermer</label>
                    </div>
                </label>
            </label>
        </form>
    </div>

</div>

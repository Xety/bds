<div>
    <div class="flex flex-col lg:flex-row gap-4 justify-between">
        <div>
            @canany(['export', 'delete'], \BDS\Models\Supplier::class)
                <div class="dropdown">
                    <label tabindex="0" class="btn btn-neutral m-1">
                        Actions
                        <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-caret-down-fill align-bottom" viewBox="0 0 16 16">
                            <path d="M7.247 11.14 2.451 5.658C1.885 5.013 2.345 4 3.204 4h9.592a1 1 0 0 1 .753 1.659l-4.796 5.48a1 1 0 0 1-1.506 0z"/>
                        </svg>
                    </label>
                    <ul tabindex="0" class="dropdown-content menu p-2 shadow bg-base-100 rounded-box w-52 z-[1]">
                        @can('delete', \BDS\Models\Supplier::class)
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
            @if (settings('supplier_create_enabled', true) && auth()->user()->can('create', \BDS\Models\Supplier::class))
                <x-button type="button" class="btn btn-success gap-2" wire:click="create" spinner>
                    <x-icon name="fas-plus" class="h-5 w-5"></x-icon>
                    Nouveau Fournisseur
                </x-button>
            @endif
        </div>
    </div>

    <x-table.table class="mb-6">
        <x-slot name="head">
            @canany(['export', 'delete'], \BDS\Models\Supplier::class)
                <x-table.heading>
                    <label>
                        <input type="checkbox" class="checkbox" wire:model.live="selectPage" />
                    </label>
                </x-table.heading>
            @endcanany
            @can('update', \BDS\Models\Supplier::class)
                <x-table.heading>Actions</x-table.heading>
            @endcan
            <x-table.heading sortable wire:click="sortBy('name')" :direction="$sortField === 'name' ? $sortDirection : null">Nom</x-table.heading>
            <x-table.heading sortable wire:click="sortBy('user_id')" :direction="$sortField === 'user_id' ? $sortDirection : null">Créateur</x-table.heading>
            <x-table.heading sortable wire:click="sortBy('description')" :direction="$sortField === 'description' ? $sortDirection : null">Description</x-table.heading>
            <x-table.heading sortable wire:click="sortBy('part_count')" :direction="$sortField === 'part_count' ? $sortDirection : null">Nombre de <br>pièces détachées</x-table.heading>
            <x-table.heading sortable wire:click="sortBy('created_at')" :direction="$sortField === 'created_at' ? $sortDirection : null">Créé le</x-table.heading>
        </x-slot>

        <x-slot name="body">
            @can('search', \BDS\Models\Supplier::class)
                <x-table.row>
                    @can('delete', \BDS\Models\Supplier::class)
                        <x-table.cell></x-table.cell>
                    @endcan
                    @can('update', \BDS\Models\Supplier::class)
                        <x-table.cell></x-table.cell>
                    @endcan
                    <x-table.cell>
                        <x-input wire:model.live.debounce.400ms="filters.name" name="filters.name" type="text"  />
                    </x-table.cell>
                    <x-table.cell>
                        <x-input wire:model.live.debounce.400ms="filters.user" name="filters.user" type="text" />
                    </x-table.cell>
                    <x-table.cell>
                        <x-input wire:model.live.debounce.400ms="filters.description" name="filters.description" type="text" />
                    </x-table.cell>
                        <x-table.cell>
                        </x-table.cell>
                    <x-table.cell>
                        <x-date-picker wire:model.live="filters.created_min" name="filters.created_min" class="input-sm" icon="fas-calendar" icon-class="h-4 w-4" placeholder="Date minimum de création" />
                        <x-date-picker wire:model.live="filters.created_max" name="filters.created_max" class="input-sm mt-2" icon="fas-calendar" icon-class="h-4 w-4 mt-[0.25rem]" placeholder="Date maximum de création" />
                    </x-table.cell>
                </x-table.row>
            @endcan

            @if ($selectPage)
                <x-table.row wire:key="row-message">
                    <x-table.cell colspan="6">
                        @unless ($selectAll)
                            <div>
                                <span>Vous avez sélectionné <strong>{{ $suppliers->count() }}</strong> fournisseur(s), voulez-vous tous les sélectionner <strong>{{ $suppliers->total() }}</strong>?</span>
                                <button type="button" wire:click="selectAll" class="btn btn-neutral btn-sm gap-2 ml-1">
                                    <i class="fa-solid fa-check"></i>
                                    Tout sélectionner
                                </button>
                            </div>
                        @else
                            <span>Vous sélectionnez actuellement <strong>{{ $suppliers->total() }}</strong> fournisseur(s).</span>
                        @endif
                    </x-table.cell>
                </x-table.row>
            @endif

            @forelse($suppliers as $supplier)
                <x-table.row wire:loading.class.delay="opacity-50" wire:key="row-{{ $supplier->getKey() }}">
                    @canany(['export', 'delete'], \BDS\Models\Supplier::class)
                        <x-table.cell>
                            <label>
                                <input type="checkbox" class="checkbox" wire:model.live="selected" value="{{ $supplier->getKey() }}" />
                            </label>
                        </x-table.cell>
                    @endcanany
                    @can('update', \BDS\Models\Supplier::class)
                        <x-table.cell>
                            <a href="#" wire:click.prevent="edit({{ $supplier->getKey() }})" class="tooltip tooltip-right" data-tip="Modifier ce fournisseur">
                                <x-icon name="fas-pen-to-square" class="h-4 w-4"></x-icon>
                            </a>
                        </x-table.cell>
                    @endcan
                    <x-table.cell>
                        <a class="link link-hover link-primary font-bold" href="{{ $supplier->show_url }}">
                            {{ $supplier->name }}
                        </a>
                    </x-table.cell>
                    <x-table.cell>
                        <a class="link link-hover link-primary font-bold" href="{{ $supplier->user->show_url }}">
                            {{ $supplier->user->full_name }}
                        </a>
                    </x-table.cell>
                    <x-table.cell>
                        <span class="tooltip tooltip-top text-left" data-tip="{{ $supplier->description }}">
                            {{ Str::limit($supplier->description, 50) }}
                        </span>
                    </x-table.cell>
                        <x-table.cell>
                            <code class="code rounded-sm">
                                {{ $supplier->part_count }}
                            </code>
                        </x-table.cell>
                    <x-table.cell class="capitalize">
                        {{ $supplier->created_at->translatedFormat( 'D j M Y H:i') }}
                    </x-table.cell>
                </x-table.row>
            @empty
                <x-table.row>
                    <x-table.cell colspan="6">
                        <div class="text-center p-2">
                            <span class="text-muted">Aucun fournisseur trouvé...</span>
                        </div>
                    </x-table.cell>
                </x-table.row>
            @endforelse
        </x-slot>
    </x-table.table>

    <div class="grid grid-cols-1">
        {{ $suppliers->links() }}
    </div>


    <!-- Delete Modal -->
    <x-modal wire:model="showDeleteModal" title="Supprimer les Fournisseurs">
        @if (empty($selected))
            <p class="my-7">
                Vous n'avez sélectionné aucun fournisseur à supprimer.
            </p>
        @else
            <p class="my-7">
                Voulez-vous vraiment supprimer ces fournisseurs ? <span class="font-bold text-red-500">Cette opération n'est pas réversible.</span>
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

    <!-- Create/Edit Modal -->
    <x-modal wire:model="showModal" title="{{ $isCreating ? 'Créer un Fournisseur' : 'Editer le Fournisseur' }}">

        <x-input wire:model="form.name" name="form.name" label="Nom" placeholder="Nom..." type="text" />

         <x-textarea wire:model="form.description" name="form.description" label="Description" placeholder="Informations complémentaires..." rows="3"/>

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

</div>

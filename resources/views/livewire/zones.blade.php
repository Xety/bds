<div>
    <div class="flex flex-col lg:flex-row gap-4 justify-between">
        <div>
            @canany(['delete'], \BDS\Models\Zone::class)
                <div class="dropdown">
                    <label tabindex="0" class="btn btn-neutral m-1">
                        Actions
                        <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-caret-down-fill align-bottom" viewBox="0 0 16 16">
                            <path d="M7.247 11.14 2.451 5.658C1.885 5.013 2.345 4 3.204 4h9.592a1 1 0 0 1 .753 1.659l-4.796 5.48a1 1 0 0 1-1.506 0z"/>
                        </svg>
                    </label>
                    <ul tabindex="0" class="dropdown-content menu p-2 shadow bg-base-100 rounded-box w-52 z-[1]">
                        @can('delete', \BDS\Models\Zone::class)
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
            @can('create', \BDS\Models\Zone::class)
                <x-button type="button" class="btn btn-success gap-2" wire:click="create" spinner>
                    <x-icon name="fas-plus" class="h-5 w-5"></x-icon>
                    Nouvelle Zone
                </x-button>
            @endcan
        </div>
    </div>

    <x-table.table class="mb-6">
        <x-slot name="head">
            @canany(['delete'], \BDS\Models\Zone::class)
                <x-table.heading>
                    <label>
                        <input type="checkbox" class="checkbox" wire:model.live="selectPage" />
                    </label>
                </x-table.heading>
            @endcanany
            @can('update', \BDS\Models\Zone::class)
                <x-table.heading>Actions</x-table.heading>
            @endcan
            <x-table.heading sortable wire:click="sortBy('name')" :direction="$sortField === 'name' ? $sortDirection : null">Nom</x-table.heading>
            <x-table.heading sortable wire:click="sortBy('parent_id')" :direction="$sortField === 'parent_id' ? $sortDirection : null">Zone Parent</x-table.heading>
            <x-table.heading sortable wire:click="sortBy('allow_material')" :direction="$sortField === 'allow_material' ? $sortDirection : null">Assignation des Matériels</x-table.heading>
            <x-table.heading sortable wire:click="sortBy('material_count')" :direction="$sortField === 'material_count' ? $sortDirection : null">Nombre de Matériels</x-table.heading>
            <x-table.heading sortable wire:click="sortBy('created_at')" :direction="$sortField === 'created_at' ? $sortDirection : null">Créé le</x-table.heading>
        </x-slot>

        <x-slot name="body">
            @can('search', \BDS\Models\Zone::class)
                <x-table.row>
                    @can('delete', \BDS\Models\Zone::class)
                        <x-table.cell></x-table.cell>
                    @endcan
                    @can('update', \BDS\Models\Zone::class)
                        <x-table.cell></x-table.cell>
                    @endcan
                    <x-table.cell>
                        <x-input wire:model.live.debounce.400ms="filters.name" name="filters.name" type="text" />
                    </x-table.cell>
                    <x-table.cell>
                        <x-input wire:model.live.debounce.400ms="filters.parent" name="filters.parent" type="text" />
                    </x-table.cell>
                    <x-table.cell>
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
                            class="select-primary"
                            wire:model.live="filters.allow_material"
                            name="filters.allow_material"
                        />
                    </x-table.cell>
                    <x-table.cell></x-table.cell>
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
                                <span>Vous avez sélectionné <strong>{{ $zones->count() }}</strong> zone(s), voulez-vous tous les sélectionner <strong>{{ $zones->total() }}</strong>?</span>
                                <x-button type="button" wire:click='setSelectAll' class="btn btn-neutral btn-sm gap-2 ml-1" spinner>
                                    <x-icon name="fas-check" class="h-5 w-5"></x-icon>
                                    Tout sélectionner
                                </x-button>
                            </div>
                        @else
                            <span>Vous sélectionnez actuellement <strong>{{ $zones->total() }}</strong> zone(s).</span>
                        @endif
                    </x-table.cell>
                </x-table.row>
            @endif

            @forelse($zones as $zone)
                <x-table.row wire:loading.class.delay="opacity-50" wire:key="row-{{ $zone->getKey() }}">
                    @canany(['delete'], \BDS\Models\Zone::class)
                        <x-table.cell>
                            <label>
                                <input type="checkbox" class="checkbox" wire:model.live="selected" value="{{ $zone->getKey() }}" />
                            </label>
                        </x-table.cell>
                    @endcanany
                    @can('update', \BDS\Models\Zone::class)
                         <x-table.cell>
                            <a href="#" wire:click.prevent="edit({{ $zone->getKey() }})" class="tooltip tooltip-right" data-tip="Editer cette zone">
                                <x-icon name="fas-pen-to-square" class="h-4 w-4"></x-icon>
                            </a>
                        </x-table.cell>
                    @endcan
                    <x-table.cell>
                        <span class="text-primary font-bold">
                            {{ $zone->name }}
                        </span>
                    </x-table.cell>
                    <x-table.cell>
                        @if($zone->parent)
                            <span class="text-primary font-bold">
                                {{ $zone->parent->name }}
                            </span>
                        @else
                            Aucune Zone Parent
                        @endif
                    </x-table.cell>
                    <x-table.cell>
                        @if ($zone->allow_material)
                            <span class="text-success font-bold">
                            Oui
                        </span>
                        @else
                            <span class="text-error font-bold">
                            Non
                        </span>
                        @endif
                    </x-table.cell>
                    <x-table.cell>
                        <code class="code rounded-sm">{{ $zone->material_count }}</code>
                    </x-table.cell>
                    <x-table.cell class="capitalize">
                        {{ $zone->created_at->translatedFormat( 'D j M Y H:i') }}
                    </x-table.cell>
                </x-table.row>
            @empty
                <x-table.row>
                    <x-table.cell colspan="7">
                        <div class="text-center p-2">
                            <span class="text-muted">Aucune zone trouvée...</span>
                        </div>
                    </x-table.cell>
                </x-table.row>
            @endforelse
        </x-slot>
    </x-table.table>

    <div class="grid grid-cols-1">
        {{ $zones->links() }}
    </div>


    <!-- Delete Zones Modal -->
    <x-modal wire:model="showDeleteModal" title="Supprimer les Zones">
        @if (empty($selected))
            <p class="my-7">
                Vous n'avez sélectionné aucune permission à supprimer.
            </p>
        @else
            <p class="my-7">
                Êtes-vous sûr de vouloir supprimer ces zones ? <span class="font-bold text-red-500">Cette opération n'est pas réversible.</span>
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

    <!-- Create/Edit Zone Modal -->
    <x-modal wire:model="showModal" title="{{ $isCreating ? 'Créer une Zone' : 'Editer la Zone' }}">

        <x-input wire:model="form.name" name="form.name" label="Nom" placeholder="Nom..." type="text" />

        <x-select
            :options="$zonesList"
            class="select-primary"
            wire:model="form.parent_id"
            name="form.parent_id"
            label="Zone Parent"
            placeholder="Aucun parent"
        />

        <x-checkbox wire:model="form.allow_material" name="form.allow_material" label="Autorisé les matériels" text="Autoriser l'assignation de matérial dans cette Zone"  class="pt-4"
                    :checked="$form->allow_material" />

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

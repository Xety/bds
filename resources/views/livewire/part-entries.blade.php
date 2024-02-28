<div>
    <div class="flex flex-col lg:flex-row gap-4 justify-between">
        <div class="flex items-center gap-4">
            @canany(['export', 'delete'], \BDS\Models\PartEntry::class)
                <div class="dropdown">
                    <label tabindex="0" class="btn btn-neutral m-1">
                        Actions
                        <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-caret-down-fill align-bottom" viewBox="0 0 16 16">
                            <path d="M7.247 11.14 2.451 5.658C1.885 5.013 2.345 4 3.204 4h9.592a1 1 0 0 1 .753 1.659l-4.796 5.48a1 1 0 0 1-1.506 0z"/>
                        </svg>
                    </label>
                    <ul tabindex="0" class="dropdown-content menu p-2 shadow bg-base-100 rounded-box w-52 z-[1]">
                        @can('export', \BDS\Models\PartEntry::class)
                            <li>
                                <button type="button" class="text-blue-500" wire:click="exportSelected()">
                                    <x-icon name="fas-download" class="h-5 w-5"></x-icon>
                                    Exporter
                                </button>
                            </li>
                        @endcan
                        @if(Gate::allows('delete',\BDS\Models\PartEntry::class) && getPermissionsTeamId() !== settings('site_id_verdun_siege'))
                            <li>
                                <button type="button" class="text-red-500" wire:click="$toggle('showDeleteModal')">
                                    <x-icon name="fas-trash-can" class="h-5 w-5"></x-icon>
                                    Supprimer
                                </button>
                            </li>
                        @endif
                    </ul>
                </div>
            @endcanany

            @if (Gate::allows('viewOtherSite', \BDS\Models\PartEntry::class) && getPermissionsTeamId() === settings('site_id_verdun_siege'))
                <x-toggle label="Voir les Entrées de pièces des autres sites" wire:model.live="viewOtherSitePartEntry" />
            @endif
        </div>
        <div class="mb-4">
            @if (settings('part_entry_create_enabled', true) && Gate::allows('create', \BDS\Models\PartEntry::class))
                <x-button type="button" class="btn btn-success gap-2" wire:click="create" spinner>
                    <x-icon name="fas-plus" class="h-5 w-5"></x-icon>
                    Nouvelle Entrée de Pièce
                </x-button>
            @endif
        </div>
    </div>

    <x-table.table class="mb-6">
        <x-slot name="head">
            @if(Gate::any(['export', 'delete'], \BDS\Models\PartEntry::class) && getPermissionsTeamId() === settings('site_id_verdun_siege'))
                <x-table.heading>
                    <label>
                        <input type="checkbox" class="checkbox" wire:model.live="selectPage" />
                    </label>
                </x-table.heading>
            @else
                <x-table.heading></x-table.heading>
            @endif

            @can('update', \BDS\Models\PartEntry::class)
                <x-table.heading>Actions</x-table.heading>
            @endcan

            <x-table.heading sortable wire:click="sortBy('part_id')" :direction="$sortField === 'part_id' ? $sortDirection : null">Pièce Détachée</x-table.heading>
            <x-table.heading>Site</x-table.heading>
            <x-table.heading sortable wire:click="sortBy('user_id')" :direction="$sortField === 'user_id' ? $sortDirection : null">Entrée par</x-table.heading>
            <x-table.heading sortable wire:click="sortBy('number')" :direction="$sortField === 'number' ? $sortDirection : null">Nombre de pièce</x-table.heading>
            <x-table.heading sortable wire:click="sortBy('order_id')" :direction="$sortField === 'order_id' ? $sortDirection : null">Commande n°</x-table.heading>
            <x-table.heading sortable wire:click="sortBy('created_at')" :direction="$sortField === 'created_at' ? $sortDirection : null">Créé le</x-table.heading>
        </x-slot>

        <x-slot name="body">
            @can('search', \BDS\Models\PartEntry::class)
                <x-table.row>
                    @canany(['export', 'delete'], \BDS\Models\PartEntry::class)
                        <x-table.cell></x-table.cell>
                    @endcanany
                    @can('update', \BDS\Models\PartEntry::class)
                        <x-table.cell></x-table.cell>
                    @endcan
                    <x-table.cell>
                        <x-input class="min-w-max" wire:model.live.debounce.400ms="filters.part" name="filters.part" type="text"  />
                    </x-table.cell>
                    <x-table.cell>
                        <x-input class="min-w-max" wire:model.live.debounce.400ms="filters.site" name="filters.site" type="text"  />
                    </x-table.cell>
                    <x-table.cell>
                        <x-input class="min-w-max" wire:model.live.debounce.400ms="filters.user" name="filters.user" type="text"  />
                    </x-table.cell>
                    <x-table.cell>
                        <x-input class="min-w-max" wire:model.live.debounce.250ms="filters.number_min" name="filters.number_min" class="input-sm" placeholder="Mini" type="number" min="0" step="1" />
                        <x-input class="min-w-max" wire:model.live.debounce.250ms="filters.number_max" name="filters.number_max" class="input-sm mt-2" placeholder="Maxi" type="number" min="0" step="1" />
                    </x-table.cell>
                    <x-table.cell>
                        <x-input class="min-w-max" wire:model.live.debounce.400ms="filters.order" name="filters.order" type="text"  />
                    </x-table.cell>
                    <x-table.cell>
                        <x-date-picker class="min-w-max" wire:model.live="filters.created_min" name="filters.created_min" class="input-sm" placeholder="Date mini" />
                        <x-date-picker class="min-w-max" wire:model.live="filters.created_max" name="filters.created_max" class="input-sm mt-2" placeholder="Date maxi" />
                    </x-table.cell>
                </x-table.row>
            @endcan

            @if ($selectPage)
                <x-table.row wire:key="row-message">
                    <x-table.cell colspan="7">
                        @unless ($selectAll)
                            <div>
                                <span>Vous avez sélectionné <strong>{{ $partEntries->count() }}</strong> entrée(s), voulez-vous tous les sélectionner <strong>{{ $partEntries->total() }}</strong>?</span>
                                <button type="button" wire:click="selectAll" class="btn btn-neutral btn-sm gap-2 ml-1">
                                    <i class="fa-solid fa-check"></i>
                                    Tout sélectionner
                                </button>
                            </div>
                        @else
                            <span>Vous sélectionnez actuellement <strong>{{ $partEntries->total() }}</strong> entrée(s).</span>
                        @endif
                    </x-table.cell>
                </x-table.row>
            @endif

            @forelse($partEntries as $partEntry)
                <x-table.row wire:loading.class.delay="opacity-50" wire:key="row-{{ $partEntry->getKey() }}">
                    @if(Gate::any(['export', 'delete'], $partEntry) &&
                        (getPermissionsTeamId() === $partEntry->part->site_id ||  getPermissionsTeamId() === settings('site_id_verdun_siege')))
                        <x-table.cell>
                            <label>
                                <input type="checkbox" class="checkbox" wire:model.live="selected" value="{{ $partEntry->getKey() }}" />
                            </label>
                        </x-table.cell>
                    @else
                        <x-table.cell></x-table.cell>
                    @endif

                    @if(Gate::allows('update', \BDS\Models\PartEntry::class) && getPermissionsTeamId() === $partEntry->part->site_id)
                        <x-table.cell>
                            <a href="#" wire:click.prevent="edit({{ $partEntry->getKey() }})" class="tooltip tooltip-right" data-tip="Modifier cette entrée">
                                <x-icon name="fas-pen-to-square" class="h-4 w-4"></x-icon>
                            </a>
                        </x-table.cell>
                    @else
                        <x-table.cell></x-table.cell>
                    @endif

                    <x-table.cell>
                        <a class="link link-hover link-primary font-bold" href="{{ $partEntry->part->show_url }}">
                            {{ $partEntry->part->name }}
                        </a>
                    </x-table.cell>
                    <x-table.cell>
                        <a class="link link-hover link-primary font-bold" href="{{ $partEntry->part->site->show_url }}">
                            {{ $partEntry->part->site->name }}
                        </a>
                    </x-table.cell>
                    <x-table.cell>
                        <a class="link link-hover link-primary font-bold" href="{{ $partEntry->user->show_url }}">
                            {{ $partEntry->user->full_name }}
                        </a>
                    </x-table.cell>
                    <x-table.cell>
                        <code class="code rounded-sm">
                            {{ $partEntry->number }}
                        </code>
                    </x-table.cell>
                    <x-table.cell>
                        @if ($partEntry->order_id)
                            <code class="code rounded-sm">
                                {{ $partEntry->order_id}}
                            </code>
                        @endif
                    </x-table.cell>
                    <x-table.cell class="capitalize">
                        {{ $partEntry->created_at->translatedFormat( 'D j M Y H:i') }}
                    </x-table.cell>
                </x-table.row>
            @empty
                <x-table.row>
                    <x-table.cell colspan="8">
                        <div class="text-center p-2">
                            <span class="text-muted">Aucune entrée trouvée...</span>
                        </div>
                    </x-table.cell>
                </x-table.row>
            @endforelse
        </x-slot>
    </x-table.table>

    <div class="grid grid-cols-1">
        {{ $partEntries->links() }}
    </div>


    <!-- Delete PartEntries Modal -->
    <x-modal wire:model="showDeleteModal" title="Supprimer les Entrées de Pièces">
        @if (empty($selected))
            <p class="my-7">
                Vous n'avez sélectionné aucune entrée de pièce à supprimer.
            </p>
        @else
            <p class="my-7">
                Voulez-vous vraiment supprimer ces entrées de pièces détachées ? <span class="font-bold text-red-500">Cette opération n'est pas réversible.</span>
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

    <!-- Create/Edit PartEntries Modal -->
    <x-modal wire:model="showModal" title="{!! $isCreating ? 'Créer une Entrée' : 'Editer l\'Entrée' !!}">

        {{-- Only display those fields for the creating modal --}}
        @if ($isCreating)
            @php $message = "Sélectionnez la pièce détachée auquelle appartient l'entrée.";@endphp
            <x-choices
                label="Pièce Détachée"
                :label-info="$message"
                wire:model="form.part_id"
                :options="$form->partsSearchable"
                search-function="search"
                no-result-text="Aucun résultat..."
                debounce="300ms"
                min-chars="2"
                single
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
                        {{ $option->site->name }}
                    </x-slot:sub-value>
                </x-list-item>
                @endscope

                {{-- Selection slot--}}
                @scope('selection', $option)
                {{ $option->name }} ({{ $option->id }})
                @endscope
            </x-choices>

            @php $message = "Nombre de pièce rentrée en stock.";@endphp
            <x-input wire:model="form.number" name="form.number" type="number" label="Nombre de pièce" placeholder="Nombre de pièce..." min="1" step="1" :label-info="$message"  />
        @endif

        @php $message = "N° de commande, laissez vide si aucun numéro.";@endphp
        <x-input wire:model="form.order_id" name="form.order_id" type="text" label="N° commande" placeholder="N° commande..." :label-info="$message" />


        <x-slot:actions>
            <x-button class="btn btn-success gap-2" type="button" wire:click="save" spinner>
                @if($isCreating)
                    <x-icon name="fas-plus" class="h-5 w-5"></x-icon> Créer
                @else
                    <x-icon name="fas-pen-to-square" class="h-5 w-5"></x-icon> Editer
                @endif
            </x-button>
            <x-button @click="$wire.showModal = false" class="btn btn-neutral">
                Fermer
            </x-button>
        </x-slot:actions>
    </x-modal>


</div>

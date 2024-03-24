<div>
    <div class="flex flex-col lg:flex-row gap-4 justify-between">
        <div class="flex items-center gap-4">
            @canany(['export', 'delete'], \BDS\Models\PartExit::class)
                <div class="dropdown">
                    <label tabindex="0" class="btn btn-neutral m-1">
                        Actions
                        <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-caret-down-fill align-bottom" viewBox="0 0 16 16">
                            <path d="M7.247 11.14 2.451 5.658C1.885 5.013 2.345 4 3.204 4h9.592a1 1 0 0 1 .753 1.659l-4.796 5.48a1 1 0 0 1-1.506 0z"/>
                        </svg>
                    </label>
                    <ul tabindex="0" class="dropdown-content menu p-2 shadow bg-base-100 rounded-box w-52 z-[1]">
                        @can('export', \BDS\Models\PartExit::class)
                            <li>
                                <button type="button" class="text-blue-500" wire:click="exportSelected()">
                                    <x-icon name="fas-download" class="h-5 w-5"></x-icon>
                                    Exporter
                                </button>
                            </li>
                        @endcan
                        @if(Gate::allows('delete',\BDS\Models\PartExit::class) && getPermissionsTeamId() !== settings('site_id_verdun_siege'))
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

            @if (Gate::allows('viewOtherSite', \BDS\Models\PartExit::class) && getPermissionsTeamId() === settings('site_id_verdun_siege'))
                <x-toggle label="Voir les Entrées de pièces des autres sites" wire:model.live="viewOtherSitePartExit" />
            @endif
        </div>
        <div class="mb-4">
            @if (settings('part_exit_create_enabled', true) && Gate::allows('create', \BDS\Models\PartExit::class))
                <x-button type="button" class="btn btn-success gap-2" wire:click="create" spinner>
                    <x-icon name="fas-plus" class="h-5 w-5"></x-icon>
                    Nouvelle Sortie de Pièce
                </x-button>
            @endif
        </div>
    </div>

    <x-table.table class="mb-6">
        <x-slot name="head">
            @canany(['export', 'delete'], \BDS\Models\Company::class)
                <x-table.heading>
                    <label>
                        <input type="checkbox" class="checkbox" wire:model.live="selectPage" />
                    </label>
                </x-table.heading>
            @endcanany

            @if(Gate::allows('update', \BDS\Models\PartExit::class) && getPermissionsTeamId() !== settings('site_id_verdun_siege'))
                <x-table.heading>Actions</x-table.heading>
            @endif
            <x-table.heading sortable wire:click="sortBy('maintenance_id')" :direction="$sortField === 'maintenance_id' ? $sortDirection : null">Maintenance n°</x-table.heading>
            <x-table.heading sortable wire:click="sortBy('part_id')" :direction="$sortField === 'part_id' ? $sortDirection : null">Pièce Détachée</x-table.heading>
            <x-table.heading>Site</x-table.heading>
            <x-table.heading sortable wire:click="sortBy('user_id')" :direction="$sortField === 'user_id' ? $sortDirection : null">Sortie par</x-table.heading>
            <x-table.heading sortable wire:click="sortBy('description')" :direction="$sortField === 'description' ? $sortDirection : null">Description</x-table.heading>
            <x-table.heading sortable wire:click="sortBy('number')" :direction="$sortField === 'number' ? $sortDirection : null">Nombre de pièce</x-table.heading>
            <x-table.heading sortable wire:click="sortBy('price')" :direction="$sortField === 'price' ? $sortDirection : null">Prix (U)</x-table.heading>
            <x-table.heading sortable wire:click="sortBy('created_at')" :direction="$sortField === 'created_at' ? $sortDirection : null">Créé le</x-table.heading>
        </x-slot>

        <x-slot name="body">
            @can('search', \BDS\Models\PartExit::class)
                <x-table.row>
                    @canany(['export', 'delete'], \BDS\Models\PartExit::class)
                        <x-table.cell></x-table.cell>
                    @endcanany
                    @if(Gate::allows('update', \BDS\Models\PartExit::class) && getPermissionsTeamId() !== settings('site_id_verdun_siege'))
                        <x-table.cell></x-table.cell>
                    @endif
                    <x-table.cell>
                        <x-input class="min-w-max" wire:model.live.debounce.400ms="filters.maintenance" name="filters.maintenance" type="text"  />
                    </x-table.cell>
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
                        <x-input class="min-w-max" wire:model.live.debounce.400ms="filters.description" name="filters.description" type="text"  />
                    </x-table.cell>
                    <x-table.cell>
                        <x-input class="min-w-max" wire:model.live.debounce.250ms="filters.number_min" name="filters.number_min" class="input-sm" placeholder="Mini" type="number" min="0" step="1" />
                        <x-input class="min-w-max" wire:model.live.debounce.250ms="filters.number_max" name="filters.number_max" class="input-sm mt-2" placeholder="Maxi" type="number" min="0" step="1" />
                    </x-table.cell>
                    <x-table.cell></x-table.cell>
                    <x-table.cell>
                        <x-date-picker class="min-w-max" wire:model.live="filters.created_min" name="filters.created_min" class="input-sm" placeholder="Date mini" />
                        <x-date-picker class="min-w-max" wire:model.live="filters.created_max" name="filters.created_max" class="input-sm mt-2" placeholder="Date maxi" />
                    </x-table.cell>
                </x-table.row>
            @endcan

            @if ($selectPage)
                <x-table.row wire:key="row-message">
                    <x-table.cell colspan="10">
                        @unless ($selectAll)
                            <div>
                                <span>Vous avez sélectionné <strong>{{ $partExits->count() }}</strong> sortie(s), voulez-vous toutes les sélectionner <strong>{{ $partExits->total() }}</strong>?</span>
                                <x-button type="button" wire:click='setSelectAll' class="btn btn-neutral btn-sm gap-2 ml-1" spinner>
                                    <x-icon name="fas-check" class="inline h-4 w-4"></x-icon>
                                    Tout sélectionner
                                </x-button>
                            </div>
                        @else
                            <span>Vous avez sélectionné actuellement <strong>{{ $partExits->total() }}</strong> sortie(s).</span>
                        @endif
                    </x-table.cell>
                </x-table.row>
            @endif

            @forelse($partExits as $partExit)
                <x-table.row wire:loading.class.delay="opacity-50" wire:key="row-{{ $partExit->getKey() }}">
                    @if(Gate::any(['export', 'delete'], $partExit) &&
                        (getPermissionsTeamId() === $partExit->part->site_id ||  getPermissionsTeamId() === settings('site_id_verdun_siege')))
                        <x-table.cell>
                            <label>
                                <input type="checkbox" class="checkbox" wire:model.live="selected" value="{{ $partExit->getKey() }}" />
                            </label>
                        </x-table.cell>
                    @endif

                    @if(Gate::allows('update', $partExit))
                        <x-table.cell>
                            <a href="#" wire:click.prevent="edit({{ $partExit->getKey() }})" class="tooltip tooltip-right" data-tip="Modifier cette sortie">
                                <x-icon name="fas-pen-to-square" class="h-4 w-4"></x-icon>
                            </a>
                        </x-table.cell>
                    @endif
                    <x-table.cell>
                        @unless (is_null($partExit->maintenance))
                            <a class="link link-hover link-primary tooltip tooltip-right text-left" href="{{ $partExit->maintenance->show_url }}" data-tip="Voir la fiche Maintenance">
                                <span class="font-bold">{{ $partExit->maintenance->getKey() }}</span>
                            </a>
                        @endunless
                    </x-table.cell>
                    <x-table.cell>
                        <a class="link link-hover link-primary font-bold" href="{{ $partExit->part->show_url }}">
                            {{ $partExit->part->name }}
                        </a>
                    </x-table.cell>
                    <x-table.cell>
                        <a class="link link-hover link-primary font-bold" href="{{ $partExit->part->site->show_url }}">
                            {{ $partExit->part->site->name }}
                        </a>
                    </x-table.cell>
                    <x-table.cell>
                        <a class="link link-hover link-primary font-bold" href="{{ $partExit->user->show_url }}">
                            {{ $partExit->user->full_name }}
                        </a>
                    </x-table.cell>
                    <x-table.cell>
                        {{ Str::limit($partExit->description, 80) }}
                    </x-table.cell>
                    <x-table.cell>
                        <code class="code rounded-sm">
                            {{ $partExit->number }}
                        </code>
                    </x-table.cell>
                    <x-table.cell>
                        <code class="code rounded-sm">
                            {{ $partExit->price }}€
                        </code>
                    </x-table.cell>
                    <x-table.cell class="capitalize">
                        {{ $partExit->created_at->translatedFormat( 'D j M Y H:i') }}
                    </x-table.cell>
                </x-table.row>
            @empty
                <x-table.row>
                    <x-table.cell colspan="10">
                        <div class="text-center p-2">
                            <span class="text-muted">Aucune sortie trouvée...</span>
                        </div>
                    </x-table.cell>
                </x-table.row>
            @endforelse
        </x-slot>
    </x-table.table>

    <div class="grid grid-cols-1">
        {{ $partExits->links() }}
    </div>


    <!-- Delete PartExits Modal -->
    <x-modal wire:model="showDeleteModal" title="Supprimer les Sorties de Pièces">
        @if (empty($selected))
            <p class="my-7">
                Vous n'avez sélectionné aucune sortie de pièce à supprimer.
            </p>
        @else
            <p class="my-7">
                Voulez-vous vraiment supprimer ces sorties de pièces détachées ? <span class="font-bold text-red-500">Cette opération n'est pas réversible.</span>
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

    <!-- Create/Edit PartExits Modal -->
    <x-modal wire:model="showModal" title="{{ $isCreating ? 'Créer une Sortie' : 'Editer la Sortie' }}">

        {{-- Only display those fields for the creating modal --}}
        @if ($isCreating)
            @php $message = "Sélectionnez la pièce détachée auquelle appartient la sortie.";@endphp
            <x-choices
                label="Pièce Détachée"
                :label-info="$message"
                wire:model="form.part_id"
                :options="$form->partsSearchable"
                search-function="searchPart"
                no-result-text="Aucun résultat..."
                debounce="300ms"
                min-chars="2"
                single
                searchable>

                {{-- Item slot--}}
                @scope('item', $option)
                <x-list-item :item="$option">
                    <x-slot:avatar>
                        <x-icon name="fas-gear" class="bg-blue-100 p-2 w-8 h-8 rounded-full" />
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
        @endif

        @php $message = "Sélectionnez la maintenance auquelle appartient la sortie.<br>Si la sortie n'est pas liée à une maintenance, sélectionnez <b>\"Aucune maintenance\"</b>";@endphp
        <x-choices
            label="Maintenance"
            :label-info="$message"
            wire:model="form.maintenance_id"
            :options="$form->maintenancesSearchable"
            search-function="searchMaintenance"
            no-result-text="Aucun résultat..."
            debounce="300ms"
            min-chars="2"
            single
            searchable>

            {{-- Item slot--}}
            @scope('item', $option)
            <x-list-item :item="$option">
                <x-slot:avatar>
                    <x-icon name="fas-screwdriver-wrench" class="bg-blue-100 p-2 w-8 h-8 rounded-full" />
                </x-slot:avatar>

                <x-slot:value>
                    N° {{ $option->id }}
                </x-slot:value>

                <x-slot:sub-value>
                    {{ $option->material->zone->site->name }}
                </x-slot:sub-value>

                <x-slot:actions>
                    {{ $option->material->name }}
                </x-slot:actions>
            </x-list-item>
            @endscope

            {{-- Selection slot--}}
            @scope('selection', $option)
            N° {{ $option->id }} ({{ $option->material->name }})
            @endscope
        </x-choices>

        @if ($isCreating)
            @php $message = "Nombre de pièce sortie du stock.";@endphp
            <x-input wire:model="form.number" name="form.number" type="number" label="Nombre de pièce" placeholder="Nombre de pièce..." min="1" step="1" :label-info="$message"  />
        @endif

        @php $message = "Renseignez ici toute information utile sur la sortie de la pièce si aucune maintenance n'est liée ou si besoin de plus de précision.";@endphp
        <x-textarea wire:model="form.description" name="form.description" label="Description de la sortie" placeholder="Informations complémentaires..." rows="3" :label-info="$message" />

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

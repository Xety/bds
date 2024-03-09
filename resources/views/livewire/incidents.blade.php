<div>
    <div class="flex flex-col lg:flex-row gap-4 justify-between">
        <div>
            @canany(['export', 'delete'], \BDS\Models\Incident::class)
                <div class="dropdown">
                    <label tabindex="0" class="btn btn-neutral m-1">
                        Actions
                        <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-caret-down-fill align-bottom" viewBox="0 0 16 16">
                            <path d="M7.247 11.14 2.451 5.658C1.885 5.013 2.345 4 3.204 4h9.592a1 1 0 0 1 .753 1.659l-4.796 5.48a1 1 0 0 1-1.506 0z"/>
                        </svg>
                    </label>
                    <ul tabindex="0" class="dropdown-content menu p-2 shadow bg-base-100 rounded-box w-52 z-[1]">
                        @can('export', \BDS\Models\Incident::class)
                            <li>
                                <button type="button" class="text-blue-500" wire:click="exportSelected()">
                                    <x-icon name="fas-download" class="h-5 w-5"></x-icon>
                                    Exporter
                                </button>
                            </li>
                        @endcan
                        @if (auth()->user()->can('delete', \BDS\Models\Incident::class) && getPermissionsTeamId() !== settings('site_id_verdun_siege'))
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
        </div>
        <div class="mb-4">
            @if (settings('incident_create_enabled', true) && auth()->user()->can('create', \BDS\Models\Incident::class))
                <x-button type="button" class="btn btn-success gap-2" wire:click="create" spinner>
                    <x-icon name="fas-plus" class="h-5 w-5"></x-icon>
                    Nouvel Incident
                </x-button>
            @endif
        </div>
    </div>

    <x-table.table class="mb-6">
        <x-slot name="head">
            @canany(['export', 'delete'], \BDS\Models\Incident::class)
                <x-table.heading>
                    <label>
                        <input type="checkbox" class="checkbox" wire:model.live="selectPage" />
                    </label>
                </x-table.heading>
            @endcanany
            @if(Gate::allows('update', \BDS\Models\Incident::class) && getPermissionsTeamId() !== settings('site_id_verdun_siege'))
                <x-table.heading>Actions</x-table.heading>
            @endif
            <x-table.heading sortable wire:click="sortBy('id')" :direction="$sortField === 'id' ? $sortDirection : null">#Id</x-table.heading>
            <x-table.heading sortable wire:click="sortBy('maintenance_id')" :direction="$sortField === 'maintenance_id' ? $sortDirection : null">Maintenance</x-table.heading>
            <x-table.heading sortable wire:click="sortBy('material_id')" :direction="$sortField === 'material_id' ? $sortDirection : null">Matériel</x-table.heading>
            <x-table.heading>Zone</x-table.heading>
            @if(getPermissionsTeamId() === settings('site_id_verdun_siege'))
                <x-table.heading sortable wire:click="sortBy('site_id')" :direction="$sortField === 'site_id' ? $sortDirection : null">Site</x-table.heading>
            @endif
            <x-table.heading sortable wire:click="sortBy('user_id')" :direction="$sortField === 'user_id' ? $sortDirection : null">Créateur</x-table.heading>
            <x-table.heading sortable wire:click="sortBy('description')" :direction="$sortField === 'description' ? $sortDirection : null">Description</x-table.heading>
            <x-table.heading sortable wire:click="sortBy('started_at')" :direction="$sortField === 'started_at' ? $sortDirection : null">Incident créé le</x-table.heading>
            <x-table.heading sortable wire:click="sortBy('impact')" :direction="$sortField === 'impact' ? $sortDirection : null">Impact</x-table.heading>
            <x-table.heading sortable wire:click="sortBy('is_finished')" :direction="$sortField === 'is_finished' ? $sortDirection : null">Résolu</x-table.heading>
            <x-table.heading sortable wire:click="sortBy('finished_at')" :direction="$sortField === 'finished_at' ? $sortDirection : null">Résolu le</x-table.heading>
        </x-slot>

        <x-slot name="body">
            @can('search', \BDS\Models\Incident::class)
                <x-table.row>
                    @can('delete', \BDS\Models\Incident::class)
                        <x-table.cell></x-table.cell>
                    @endcan
                    @if(Gate::allows('update', \BDS\Models\Incident::class) && getPermissionsTeamId() !== settings('site_id_verdun_siege'))
                        <x-table.cell></x-table.cell>
                    @endif
                    <x-table.cell>
                        <x-input wire:model.live.debounce.400ms="filters.id" name="filters.id" type="number" min="1" step="1"  />
                    </x-table.cell>
                    <x-table.cell>
                        <x-input wire:model.live.debounce.400ms="filters.maintenance" name="filters.maintenance" type="text" />
                    </x-table.cell>
                    <x-table.cell>
                        <x-input wire:model.live.debounce.400ms="filters.material" name="filters.material" type="text" />
                    </x-table.cell>
                    <x-table.cell>
                        <x-input wire:model.live.debounce.400ms="filters.zone" name="filters.zone" type="text" />
                    </x-table.cell>
                    @if(getPermissionsTeamId() === settings('site_id_verdun_siege'))
                        <x-table.cell>
                            <x-input wire:model.live.debounce.400ms="filters.site" name="filters.site" type="text" />
                        </x-table.cell>
                    @endif
                    <x-table.cell>
                        <x-input wire:model.live.debounce.400ms="filters.creator" name="filters.creator" type="text" />
                    </x-table.cell>
                    <x-table.cell>
                        <x-input wire:model.live.debounce.400ms="filters.description" name="filters.description" type="text" />
                    </x-table.cell>
                    <x-table.cell>
                        <x-date-picker wire:model.live="filters.started_min" name="filters.started_min" class="input-sm" icon="fas-calendar" icon-class="h-4 w-4" placeholder="Date minimum de création" />
                        <x-date-picker wire:model.live="filters.started_max" name="filters.started_max" class="input-sm mt-2" icon="fas-calendar" icon-class="h-4 w-4 mt-[0.25rem]" placeholder="Date maximum de création" />
                    </x-table.cell>
                    <x-table.cell>
                        <x-select
                            :options="\BDS\Models\Incident::IMPACT"
                            class="select-primary"
                            wire:model.live="filters.impact"
                            name="filters.impact"
                            placeholder="Tous"
                        />
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
                            wire:model.live="filters.finished"
                            name="filters.finished"
                        />
                    </x-table.cell>
                    <x-table.cell>
                        <x-date-picker wire:model.live="filters.finished_min" name="filters.finished_min" class="input-sm" icon="fas-calendar" icon-class="h-4 w-4" placeholder="Date minimum de fin" />
                        <x-date-picker wire:model.live="filters.finished_max" name="filters.finished_max" class="input-sm mt-2" icon="fas-calendar" icon-class="h-4 w-4 mt-[0.25rem]" placeholder="Date maximum de fin" />
                    </x-table.cell>
                </x-table.row>
            @endcan

            @if ($selectPage)
                <x-table.row wire:key="row-message">
                    <x-table.cell colspan="11">
                        @unless ($selectAll)
                            <div>
                                <span>Vous avez sélectionné <strong>{{ $incidents->count() }}</strong> incident(s), voulez-vous tous les sélectionner <strong>{{ $incidents->total() }}</strong>?</span>
                                <x-button type="button" wire:click='setSelectAll' class="btn btn-neutral btn-sm gap-2 ml-1" spinner>
                                    <x-icon name="fas-check" class="inline h-4 w-4"></x-icon>
                                    Tout sélectionner
                                </x-button>
                            </div>
                        @else
                            <span>Vous sélectionnez actuellement <strong>{{ $incidents->total() }}</strong> incident(s).</span>
                        @endif
                    </x-table.cell>
                </x-table.row>
            @endif

            @forelse($incidents as $incident)
                <x-table.row wire:loading.class.delay="opacity-50" wire:key="row-{{ $incident->getKey() }}">
                    @canany(['export', 'delete'], \BDS\Models\Incident::class)
                        <x-table.cell>
                            <label>
                                <input type="checkbox" class="checkbox" wire:model.live="selected" value="{{ $incident->getKey() }}" />
                            </label>
                        </x-table.cell>
                    @endcanany
                    @can('update', $incident)
                        <x-table.cell>
                            <a href="#" wire:click.prevent="edit({{ $incident->getKey() }})" class="tooltip tooltip-right" data-tip="Modifier l'incident">
                                <x-icon name="fas-pen-to-square" class="h-4 w-4"></x-icon>
                            </a>
                        </x-table.cell>
                    @endcan
                    <x-table.cell>{{ $incident->getKey() }}</x-table.cell>
                    <x-table.cell>
                        @if($incident->maintenance)
                            <a class="link link-hover link-primary font-bold tooltip tooltip-top " href="{{ $incident->maintenance->show_url }}" data-tip="Voir la maintenance">
                                #{{ $incident->maintenance->id }}
                            </a>
                        @endif
                    </x-table.cell>
                    <x-table.cell>
                        <a class="link link-hover link-primary font-bold" href="{{ $incident->material->show_url }}">
                            {{ $incident->material->name }}
                        </a>
                    </x-table.cell>
                    <x-table.cell>
                        {{ $incident->material->zone->name }}
                    </x-table.cell>
                    @if(getPermissionsTeamId() === settings('site_id_verdun_siege'))
                        <x-table.cell>
                            <a class="link link-hover link-primary font-bold" href="{{ $incident->site->show_url }}">
                                {{ $incident->site->name }}
                            </a>
                        </x-table.cell>
                    @endif
                    <x-table.cell>
                        <a class="link link-hover link-primary font-bold" href="{{ $incident->user->show_url }}">
                            {{ $incident->user->full_name }}
                        </a>
                    </x-table.cell>
                    <x-table.cell>
                        <span class="tooltip tooltip-top text-left" data-tip="{{ $incident->description }}">
                            {{ Str::limit($incident->description, 50) }}
                        </span>
                    </x-table.cell>
                    <x-table.cell class="capitalize">
                        {{ $incident->started_at->translatedFormat( 'D j M Y H:i') }}
                    </x-table.cell>
                    <x-table.cell>
                        @switch($incident->impact)
                            @case("mineur")
                                    <span class="font-bold text-yellow-500">{{ collect(\BDS\Models\Incident::IMPACT)->sole('id', $incident->impact)['name'] }}</span>
                                @break

                            @case("moyen")
                                    <span class="font-bold text-orange-500">{{ collect(\BDS\Models\Incident::IMPACT)->sole('id', $incident->impact)['name'] }}</span>
                                @break

                            @default
                                    <span class="font-bold text-red-500">{{ collect(\BDS\Models\Incident::IMPACT)->sole('id', $incident->impact)['name'] }}</span>
                        @endswitch
                    </x-table.cell>
                    <x-table.cell>
                        @if ($incident->is_finished)
                            <span class="font-bold text-green-500">Oui</span>
                        @else
                            <span class="font-bold text-red-500">Non</span>
                        @endif
                    </x-table.cell>
                    <x-table.cell class="capitalize">
                        {{ $incident->finished_at?->translatedFormat( 'D j M Y H:i') }}
                    </x-table.cell>
                </x-table.row>
            @empty
                <x-table.row>
                    <x-table.cell colspan="12">
                        <div class="text-center p-2">
                            <span class="text-muted">Aucun incident trouvé...</span>
                        </div>
                    </x-table.cell>
                </x-table.row>
            @endforelse
        </x-slot>
    </x-table.table>

    <div class="grid grid-cols-1">
        {{ $incidents->links() }}
    </div>


    <!-- Delete Modal -->
    <x-modal wire:model="showDeleteModal" title="Supprimer les Incidents">
        @if (empty($selected))
            <p class="my-7">
                Vous n'avez sélectionné aucun incident à supprimer.
            </p>
        @else
            <p class="my-7">
                Voulez-vous vraiment supprimer ces incidents ? <span class="font-bold text-red-500">Cette opération n'est pas réversible.</span>
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
    <x-modal wire:model="showModal" title="{!! $isCreating ? 'Créer un Incident' : 'Editer l\'Incident' !!}">
        @php $message = "Sélectionnez la maintenance qui a permis de résoudre l'incident.(Laissez vide si aucune maintenance)";@endphp
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
                    #{{ $option->id }}
                </x-slot:value>

                <x-slot:sub-value>
                    {{ $option->material->name }}
                </x-slot:sub-value>

                <x-slot:actions>
                    {{ $option->material->zone->name }}
                </x-slot:actions>
            </x-list-item>
            @endscope

            {{-- Selection slot--}}
            @scope('selection', $option)
            #{{ $option->id }} ({{ $option->material->name }})
            @endscope
        </x-choices>

        @php $message = "Sélectionnez le matériel qui a rencontré un problème dans la liste. (<b>Si plusieurs matériels, merci de créer un incident par matériel</b>)";@endphp
        <x-choices
            label="Matériel"
            :label-info="$message"
            wire:model="form.material_id"
            :options="$form->materialsSearchable"
            search-function="searchMaterial"
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
                    {{ $option->zone->site->name }}
                </x-slot:sub-value>

                <x-slot:actions>
                    {{ $option->zone->name }}
                </x-slot:actions>
            </x-list-item>
            @endscope

            {{-- Selection slot--}}
            @scope('selection', $option)
            {{ $option->name }} ({{ $option->id }})
            @endscope
        </x-choices>

        @php $message = "Veuillez décrire au mieux le problème.";@endphp
         <x-textarea wire:model="form.description" name="form.description" label="Description de l'incident" placeholder="Description de l'incident..." rows="3" :label-info="$message" />

        @php $message = "Sélectionnez l'impact de l'incident :<br><b>Mineur:</b> Incident légé sans impact sur la production.<br><b>Moyen:</b> Incident moyen ayant entrainé un arrêt partiel et/ou une perte de produit.<br><b>Critique:</b> Incident grave ayant impacté la production et/ou un arrêt.";@endphp
        <x-select
            :options="\BDS\Models\Incident::IMPACT"
            class="select-primary"
            wire:model="form.impact"
            name="form.impact"
            label="Impact de l'incident"
            :label-info="$message"
            placeholder="Sélectionnez l'impact"
        />

        @php $message = "Date à laquelle a eu lieu l'incident.";@endphp
        <x-date-picker wire:model="form.started_at" name="form.started_at" class="form-control" :label-info="$message" icon="fas-calendar" icon-class="h-4 w-4" label="Incident survenu le" placeholder="Incident survenu le..." />

        <x-checkbox wire:model.live="form.is_finished" name="form.is_finished" label="Incident résolu ?" text="Cochez si l'incident est résolu" />
        @if ($form->is_finished)
            @php $message = "Date à laquelle l'incident a été résolu.";@endphp
            <x-date-picker wire:model="form.finished_at" name="form.finished_at" class="form-control" :label-info="$message" icon="fas-calendar" icon-class="h-4 w-4" label="Incident résolu le" placeholder="Incident résolu le..." />
        @endif


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

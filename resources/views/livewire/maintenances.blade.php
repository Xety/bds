<div>
    <div class="flex flex-col lg:flex-row gap-4 justify-between">
        <div>
            @canany(['export', 'delete'], \BDS\Models\Maintenance::class)
                <div class="dropdown">
                    <label tabindex="0" class="btn btn-neutral m-1">
                        Actions
                        <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-caret-down-fill align-bottom" viewBox="0 0 16 16">
                            <path d="M7.247 11.14 2.451 5.658C1.885 5.013 2.345 4 3.204 4h9.592a1 1 0 0 1 .753 1.659l-4.796 5.48a1 1 0 0 1-1.506 0z"/>
                        </svg>
                    </label>
                    <ul tabindex="0" class="dropdown-content menu p-2 shadow bg-base-100 rounded-box w-52 z-[1]">
                        @can('export', \BDS\Models\Maintenance::class)
                            <li>
                                <button type="button" class="text-blue-500" wire:click="exportSelected()">
                                    <x-icon name="fas-download" class="h-5 w-5"></x-icon>
                                    Exporter
                                </button>
                            </li>
                        @endcan
                        @can('delete', \BDS\Models\Maintenance::class)
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
            @if (settings('maintenance_create_enabled', true) && auth()->user()->can('create', \BDS\Models\Maintenance::class))
                <x-button type="button" class="btn btn-success gap-2" wire:click="create" spinner>
                    <x-icon name="fas-plus" class="h-5 w-5"></x-icon>
                    Nouvelle Maintenance
                </x-button>
            @endif
        </div>
    </div>

    <x-table.table class="mb-6">
        <x-slot name="head">
            @canany(['export', 'delete'], \BDS\Models\Maintenance::class)
                <x-table.heading>
                    <label>
                        <input type="checkbox" class="checkbox" wire:model.live="selectPage" />
                    </label>
                </x-table.heading>
            @endcanany
            @can('update', \BDS\Models\Maintenance::class)
                <x-table.heading>Actions</x-table.heading>
            @endcan
            <x-table.heading sortable wire:click="sortBy('id')" :direction="$sortField === 'id' ? $sortDirection : null">#Id</x-table.heading>
            <x-table.heading sortable wire:click="sortBy('gmao_id')" :direction="$sortField === 'gmao_id' ? $sortDirection : null">GMAO ID</x-table.heading>
            <x-table.heading sortable wire:click="sortBy('material_id')" :direction="$sortField === 'material_id' ? $sortDirection : null">Matériel</x-table.heading>
            <x-table.heading sortable wire:click="sortBy('user_id')" :direction="$sortField === 'user_id' ? $sortDirection : null">Créateur</x-table.heading>
            <x-table.heading sortable wire:click="sortBy('description')" :direction="$sortField === 'description' ? $sortDirection : null">Description</x-table.heading>
            <x-table.heading sortable wire:click="sortBy('reason')" :direction="$sortField === 'reason' ? $sortDirection : null">Raison</x-table.heading>
            <x-table.heading sortable wire:click="sortBy('type')" :direction="$sortField === 'type' ? $sortDirection : null">Type</x-table.heading>
            <x-table.heading sortable wire:click="sortBy('realization')" :direction="$sortField === 'realization' ? $sortDirection : null">Réalisation</x-table.heading>
            <x-table.heading sortable wire:click="sortBy('started_at')" :direction="$sortField === 'started_at' ? $sortDirection : null">Incident créé le</x-table.heading>
            <x-table.heading sortable wire:click="sortBy('is_finished')" :direction="$sortField === 'is_finished' ? $sortDirection : null">Résolu</x-table.heading>
            <x-table.heading sortable wire:click="sortBy('finished_at')" :direction="$sortField === 'finished_at' ? $sortDirection : null">Résolu le</x-table.heading>
        </x-slot>

        <x-slot name="body">
            @can('search', \BDS\Models\Incident::class)
                <x-table.row>
                    @can('delete', \BDS\Models\Incident::class)
                        <x-table.cell></x-table.cell>
                    @endcan
                    @can('update', \BDS\Models\Incident::class)
                        <x-table.cell></x-table.cell>
                    @endcan
                    <x-table.cell>
                        <x-input wire:model.live.debounce.400ms="filters.id" name="filters.id" type="number" min="1" step="1"  />
                    </x-table.cell>
                    <x-table.cell>
                        <x-input wire:model.live.debounce.400ms="filters.gmao" name="filters.gmao" type="text" />
                    </x-table.cell>
                    <x-table.cell>
                        <x-input wire:model.live.debounce.400ms="filters.material" name="filters.material" type="text" />
                    </x-table.cell>
                    <x-table.cell>
                        <x-input wire:model.live.debounce.400ms="filters.creator" name="filters.creator" type="text" />
                    </x-table.cell>
                    <x-table.cell>
                        <x-input wire:model.live.debounce.400ms="filters.description" name="filters.description" type="text" />
                    </x-table.cell>
                    <x-table.cell>
                        <x-input wire:model.live.debounce.400ms="filters.reason" name="filters.reason" type="text" />
                    </x-table.cell>
                    <x-table.cell>
                        <x-select
                            :options="\BDS\Models\Maintenance::TYPES"
                            class="select-primary"
                            wire:model.live="filters.type"
                            name="filters.type"
                            placeholder="Tous"
                        />
                    </x-table.cell>
                    <x-table.cell>
                        <x-select
                            :options="\BDS\Models\Maintenance::REALIZATIONS"
                            class="select-primary"
                            wire:model.live="filters.realization"
                            name="filters.realization"
                            placeholder="Tous"
                        />
                    </x-table.cell>
                    <x-table.cell>
                        <x-date-picker wire:model.live="filters.started_min" name="filters.started_min" class="input-sm" icon="fas-calendar" icon-class="h-4 w-4" placeholder="Date minimum de création" />
                        <x-date-picker wire:model.live="filters.started_max" name="filters.started_max" class="input-sm mt-2" icon="fas-calendar" icon-class="h-4 w-4 mt-[0.25rem]" placeholder="Date maximum de création" />
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
                    <x-table.cell colspan="13">
                        @unless ($selectAll)
                            <div>
                                <span>Vous avez sélectionné <strong>{{ $maintenances->count() }}</strong> maintenance(s), voulez-vous tous les sélectionner <strong>{{ $maintenances->total() }}</strong>?</span>
                                <x-button type="button" wire:click='setSelectAll' class="btn btn-neutral btn-sm gap-2 ml-1" spinner>
                                    <x-icon name="fas-check" class="inline h-4 w-4"></x-icon>
                                    Tout sélectionner
                                </x-button>
                            </div>
                        @else
                            <span>Vous sélectionnez actuellement <strong>{{ $maintenances->total() }}</strong> maintenances(s).</span>
                        @endif
                    </x-table.cell>
                </x-table.row>
            @endif

            @forelse($maintenances as $maintenance)
                <x-table.row wire:loading.class.delay="opacity-50" wire:key="row-{{ $maintenance->getKey() }}">
                    @canany(['export', 'delete'], \BDS\Models\Maintenance::class)
                        <x-table.cell>
                            <label>
                                <input type="checkbox" class="checkbox" wire:model.live="selected" value="{{ $maintenance->getKey() }}" />
                            </label>
                        </x-table.cell>
                    @endcanany
                    @can('update', \BDS\Models\Maintenance::class)
                        <x-table.cell>
                            <a href="#" wire:click.prevent="edit({{ $maintenance->getKey() }})" class="tooltip tooltip-right" data-tip="Modifier la maintenance">
                                <x-icon name="fas-pen-to-square" class="h-4 w-4"></x-icon>
                            </a>
                        </x-table.cell>
                    @endcan
                    <x-table.cell>{{ $maintenance->getKey() }}</x-table.cell>
                    <x-table.cell>
                        @if($maintenance->gmao_id)
                            <code class="code rounded-sm">
                                {{ $maintenance->gmao_id }}
                            </code>
                        @endif
                    </x-table.cell>
                    <x-table.cell>
                        <a class="link link-hover link-primary font-bold" href="{{ $maintenance->material->show_url }}">
                            {{ $maintenance->material->name }}
                        </a>
                    </x-table.cell>
                    <x-table.cell>
                        <a class="link link-hover link-primary font-bold" href="{{ $maintenance->user->show_url }}">
                            {{ $maintenance->user->full_name }}
                        </a>
                    </x-table.cell>
                    <x-table.cell>
                        <span class="tooltip tooltip-top text-left" data-tip="{{ $maintenance->description }}">
                            {{ Str::limit($maintenance->description, 50) }}
                        </span>
                    </x-table.cell>
                    <x-table.cell>
                        <span class="tooltip tooltip-top text-left" data-tip="{{ $maintenance->reason }}">
                            {{ Str::limit($maintenance->reason, 50) }}
                        </span>
                    </x-table.cell>
                    <x-table.cell>
                        @if ($maintenance->type === 'curative')
                            <span class="font-bold text-red-500">Curative</span>
                        @else
                            <span class="font-bold text-green-500">Préventive</span>
                        @endif
                    </x-table.cell>
                    <x-table.cell>
                        @if ($maintenance->realization === 'external')
                            <span class="font-bold text-red-500">Externe</span>
                        @elseif ($maintenance->realization === 'internal')
                            <span class="font-bold text-green-500">Interne</span>
                        @else
                            <span class="font-bold text-yellow-500">Interne et Externe</span>
                        @endif
                    </x-table.cell>
                    <x-table.cell class="capitalize">
                        {{ $maintenance->started_at->translatedFormat( 'D j M Y H:i') }}
                    </x-table.cell>
                    <x-table.cell>
                        @if ($maintenance->is_finished)
                            <span class="font-bold text-green-500">Oui</span>
                        @else
                            <span class="font-bold text-red-500">Non</span>
                        @endif
                    </x-table.cell>
                    <x-table.cell class="capitalize">
                        {{ $maintenance->finished_at?->translatedFormat( 'D j M Y H:i') }}
                    </x-table.cell>
                </x-table.row>
            @empty
                <x-table.row>
                    <x-table.cell colspan="13">
                        <div class="text-center p-2">
                            <span class="text-muted">Aucune maintenance trouvé...</span>
                        </div>
                    </x-table.cell>
                </x-table.row>
            @endforelse
        </x-slot>
    </x-table.table>

    <div class="grid grid-cols-1">
        {{ $maintenances->links() }}
    </div>


    <!-- Delete Modal -->
    <x-modal wire:model="showDeleteModal" title="Supprimer les Maintenances">
        @if (empty($selected))
            <p class="my-7">
                Vous n'avez sélectionné aucune maintenance à supprimer.
            </p>
        @else
            <p class="my-7">
                Voulez-vous vraiment supprimer ces maintenances ? <span class="font-bold text-red-500">Cette opération n'est pas réversible.</span>
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
    <x-modal wire:model="showModal" title="{!! $isCreating ? 'Créer une Maintenance' : 'Editer la Maintenance' !!}">


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

        @php $message = "Sélectionnez le type de la maintenance :<br><b>Mineur:</b> Incident légé sans impact sur la production.<br><b>Moyen:</b> Incident moyen ayant entrainé un arrêt partiel et/ou une perte de produit.<br><b>Critique:</b> Incident grave ayant impacté la production et/ou un arrêt.";@endphp
        <x-select
            :options="\BDS\Models\Maintenance::TYPES"
            class="select-primary"
            wire:model="form.type"
            name="form.type"
            label="Type de Maintenance"
            :label-info="$message"
            placeholder="Sélectionnez le type"
        />

        @php $message = "Date à laquelle à commencée la maintenance.";@endphp
        <x-date-picker wire:model="form.started_at" name="form.started_at" class="form-control" :label-info="$message" icon="fas-calendar" icon-class="h-4 w-4" label="Maintenance commencée le" placeholder="Maintenance commencée le..." />

        <x-checkbox wire:model.live="form.is_finished" name="form.is_finished" label="Maintenance résolue ?" text="Cochez si la maintenance est résolue" />
        @if ($form->is_finished)
            @php $message = "Date à laquelle la maintenance a été résolue.";@endphp
            <x-date-picker wire:model="form.finished_at" name="form.finished_at" class="form-control" :label-info="$message" icon="fas-calendar" icon-class="h-4 w-4" label="Maintenance résolue le" placeholder="Maintenance résolue le..." />
        @endif

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

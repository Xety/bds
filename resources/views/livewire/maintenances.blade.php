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
                        @if (auth()->user()->can('delete', \BDS\Models\Maintenance::class) && getPermissionsTeamId() !== settings('site_id_verdun_siege'))
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
            @if(Gate::allows('update', \BDS\Models\Maintenance::class) && getPermissionsTeamId() !== settings('site_id_verdun_siege'))
                <x-table.heading>Actions</x-table.heading>
            @endif
            <x-table.heading sortable wire:click="sortBy('id')" :direction="$sortField === 'id' ? $sortDirection : null">#Id</x-table.heading>
            <x-table.heading sortable wire:click="sortBy('gmao_id')" :direction="$sortField === 'gmao_id' ? $sortDirection : null">GMAO ID</x-table.heading>
            <x-table.heading sortable wire:click="sortBy('material_id')" :direction="$sortField === 'material_id' ? $sortDirection : null">Matériel</x-table.heading>
            @if(getPermissionsTeamId() === settings('site_id_verdun_siege'))
                <x-table.heading sortable wire:click="sortBy('site_id')" :direction="$sortField === 'site_id' ? $sortDirection : null">Site</x-table.heading>
            @endif
            <x-table.heading sortable wire:click="sortBy('user_id')" :direction="$sortField === 'user_id' ? $sortDirection : null">Créateur</x-table.heading>
            <x-table.heading sortable wire:click="sortBy('description')" :direction="$sortField === 'description' ? $sortDirection : null">Description</x-table.heading>
            <x-table.heading sortable wire:click="sortBy('reason')" :direction="$sortField === 'reason' ? $sortDirection : null">Raison</x-table.heading>
            <x-table.heading sortable wire:click="sortBy('type')" :direction="$sortField === 'type' ? $sortDirection : null">Type</x-table.heading>
            <x-table.heading sortable wire:click="sortBy('realization')" :direction="$sortField === 'realization' ? $sortDirection : null">Réalisation</x-table.heading>
            <x-table.heading sortable wire:click="sortBy('started_at')" :direction="$sortField === 'started_at' ? $sortDirection : null">Commencé le</x-table.heading>
            <x-table.heading sortable wire:click="sortBy('is_finished')" :direction="$sortField === 'is_finished' ? $sortDirection : null">Résolu</x-table.heading>
            <x-table.heading sortable wire:click="sortBy('finished_at')" :direction="$sortField === 'finished_at' ? $sortDirection : null">Résolu le</x-table.heading>
        </x-slot>

        <x-slot name="body">
            @can('search', \BDS\Models\Maintenance::class)
                <x-table.row>
                    @can('delete', \BDS\Models\Maintenance::class)
                        <x-table.cell></x-table.cell>
                    @endcan
                    @if(Gate::allows('update', \BDS\Models\Maintenance::class) && getPermissionsTeamId() !== settings('site_id_verdun_siege'))
                        <x-table.cell></x-table.cell>
                    @endif
                    <x-table.cell>
                        <x-input wire:model.live.debounce.400ms="filters.id" name="filters.id" type="number" min="1" step="1"  />
                    </x-table.cell>
                    <x-table.cell>
                        <x-input wire:model.live.debounce.400ms="filters.gmao" name="filters.gmao" type="text" />
                    </x-table.cell>
                    <x-table.cell>
                        <x-input wire:model.live.debounce.400ms="filters.material" name="filters.material" type="text" />
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
                        <x-input wire:model.live.debounce.400ms="filters.reason" name="filters.reason" type="text" />
                    </x-table.cell>
                    <x-table.cell>
                        <x-select
                            :options="\BDS\Enums\Maintenance\Types::toSelectArray()"
                            class="select-primary"
                            wire:model.live="filters.type"
                            name="filters.type"
                        />
                    </x-table.cell>
                    <x-table.cell>
                        <x-select
                            :options="\BDS\Enums\Maintenance\Realizations::toSelectArray()"
                            class="select-primary"
                            wire:model.live="filters.realization"
                            name="filters.realization"
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
                    @if(Gate::any(['export', 'delete'], $maintenance))
                        <x-table.cell>
                            <label>
                                <input type="checkbox" class="checkbox" wire:model.live="selected" value="{{ $maintenance->getKey() }}" />
                            </label>
                        </x-table.cell>
                    @endif
                    @can('update', $maintenance)
                        <x-table.cell>
                            <a href="#" wire:click.prevent="edit({{ $maintenance->getKey() }})" class="tooltip tooltip-right" data-tip="Modifier la maintenance">
                                <x-icon name="fas-pen-to-square" class="h-4 w-4"></x-icon>
                            </a>
                        </x-table.cell>
                    @endcan
                    <x-table.cell>
                        <a class="link link-hover link-primary tooltip tooltip-right text-left" href="{{ $maintenance->show_url }}" data-tip="Voir la fiche Maintenance">
                            <span class="font-bold">#{{ $maintenance->getKey() }}</span>
                        </a>
                    </x-table.cell>
                    <x-table.cell>
                        @if($maintenance->gmao_id)
                            <code class="code rounded-sm">
                                {{ $maintenance->gmao_id }}
                            </code>
                        @endif
                    </x-table.cell>
                    <x-table.cell>
                        @if($maintenance->material)
                            <a class="link link-hover link-primary font-bold" href="{{ $maintenance->material->show_url }}">
                                {{ $maintenance->material->name }}
                            </a>
                        @endif
                    </x-table.cell>
                    @if(getPermissionsTeamId() === settings('site_id_verdun_siege'))
                        <x-table.cell>
                            <a class="link link-hover link-primary font-bold" href="{{ $maintenance->site->show_url }}">
                                {{ $maintenance->site->name }}
                            </a>
                        </x-table.cell>
                    @endif
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
                        <span class="font-bold {{ $maintenance->type->color() }}">
                            {{ $maintenance->type->label() }}
                        </span>
                    </x-table.cell>
                    <x-table.cell>
                        <span class="font-bold {{ $maintenance->realization->color() }}">
                            {{ $maintenance->realization->label() }}
                        </span>
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
                            <span class="text-muted">Aucune maintenance trouvée...</span>
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
    <x-modal wire:model="showModal" title="{!! $isCreating ? 'Créer une Maintenance' : 'Editer la Maintenance' !!}" modal-class="w-11/12 max-w-5xl">

        <x-input wire:model="form.gmao_id" name="form.gmao_id" label="N° GMAO" placeholder="N° GMAO..." type="text" />

        @php $message = "Sélectionnez le matériel pour lequel la maintenance a eu lieu.<br><i>Note: si la maintenance appartient à aucun matériel, laissez vide.</i> ";@endphp
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

        @php $message = "Sélectionnez le(s) incident(s) pour le(s)quel(s) la maintenance a eu lieu.<br><i>Note: si la maintenance n'a résolu aucun incident, laissez vide.</i> ";@endphp
        <x-choices
            label="Incident(s)"
            :label-info="$message"
            wire:model="form.incidents"
            :options="$form->incidentsSearchable"
            search-function="searchIncidents"
            no-result-text="Aucun résultat..."
            debounce="300ms"
            min-chars="1"
            searchable>

            {{-- Item slot--}}
            @scope('item', $option)
            <x-list-item :item="$option">
                <x-slot:avatar>
                    <x-icon name="fas-triangle-exclamation" class="bg-blue-100 p-2 w-8 h-8 rounded-full" />
                </x-slot:avatar>

                <x-slot:value>
                    #{{ $option->id }}
                </x-slot:value>

                <x-slot:sub-value>
                    {{ $option?->material->name }}
                </x-slot:sub-value>

                <x-slot:actions>
                    {{ $option?->material->zone->name }}
                </x-slot:actions>
            </x-list-item>
            @endscope

            {{-- Selection slot--}}
            @scope('selection', $option)
            #{{ $option->id }} ({{ $option?->material->name }})
            @endscope
        </x-choices>

        @php $message = "Veuillez décrire au mieux le déroulé de la maintenance.";@endphp
         <x-textarea wire:model="form.description" name="form.description" label="Description de la maintenance" placeholder="Description de la maintenance..." rows="3" :label-info="$message" />

        @php $message = "Veuillez décrire au mieux la raison de la maintenance.";@endphp
        <x-textarea wire:model="form.reason" name="form.reason" label="Raison de la maintenance" placeholder="Raison de la maintenance..." rows="3" :label-info="$message" />

        @php $message = "Sélectionnez le type de la maintenance :<br><b>Curative:</b> Maintenance servant à réparer un accident.<br><b>Préventive:</b> Maintenance servant à éviter un accident.";@endphp
        <x-select
            :options="\BDS\Enums\Maintenance\Types::toSelectArray(false)"
            class="select-primary"
            wire:model="form.type"
            name="form.type"
            label="Type de Maintenance"
            :label-info="$message"
            placeholder="Sélectionnez le type"
        />

        @php $message = "Sélectionnez la réalisation :<br><b>Interne:</b> Réalisé par un opérateur.<br><b>Externe:</b> Réalisé par une entreprise extérieur.<br><b>Interne et Externe:</b> Réalisé par une entreprise extérieur et un/des opérateur(s).";@endphp
        <x-select
            :options="\BDS\Enums\Maintenance\Realizations::toSelectArray(false)"
            class="select-primary"
            wire:model.live="form.realization"
            name="form.realization"
            label="Type de Réalisation"
            :label-info="$message"
            placeholder="Sélectionnez la réalisation"
        />

        @if($form->realization == 'internal' || $form->realization == 'both')
            @php $message = "Indiquez le(s) opérateur(s) ayant effectué(s) la maintenance. <b>UNIQUEMENT si un opérateur est intervenu lors de la maintenance.</b>"; @endphp
            <x-choices
                label="Opérateur(s)"
                :label-info="$message"
                wire:model="form.operators"
                :options="$form->operatorsSearchable"
                search-function="searchOperators"
                no-result-text="Aucun résultat..."
                debounce="300ms"
                min-chars="2"
                searchable>

                {{-- Item slot--}}
                @scope('item', $option)
                <x-list-item :item="$option">
                    <x-slot:avatar>
                        <x-icon name="fas-user" class="bg-blue-100 p-2 w-8 h-8 rounded-full" />
                    </x-slot:avatar>

                    <x-slot:value>
                        {{ $option->full_name }}
                    </x-slot:value>

                    <x-slot:sub-value>
                        {{ $option->username }}
                    </x-slot:sub-value>

                    <x-slot:actions>
                        @foreach ($option->roles as $role)
                            <span class="block font-semibold truncate" style="{{ $role->formatted_color }};">
                                {{ $role->name }}
                            </span>
                        @endforeach
                    </x-slot:actions>
                </x-list-item>
                @endscope

                {{-- Selection slot--}}
                @scope('selection', $option)
                    {{ $option->full_name }}
                @endscope
            </x-choices>
        @endif

        @if($form->realization == 'external' || $form->realization == 'both')
            @php $message = "Indiquez l'(es) entreprise(s) ayant effectuée(s) la maintenance. ";@endphp
            <x-choices
                label="Entreprise(s)"
                :label-info="$message"
                wire:model="form.companies"
                :options="$form->companiesSearchable"
                search-function="searchCompanies"
                no-result-text="Aucun résultat..."
                debounce="300ms"
                min-chars="2"
                searchable>

                {{-- Item slot--}}
                @scope('item', $option)
                <x-list-item :item="$option">
                    <x-slot:avatar>
                        <x-icon name="fas-briefcase" class="bg-blue-100 p-2 w-8 h-8 rounded-full" />
                    </x-slot:avatar>

                    <x-slot:value>
                        {{ $option->name }}
                    </x-slot:value>

                    <x-slot:sub-value>
                        {{ $option->site->name }}
                    </x-slot:sub-value>
                </x-list-item>
                @endscope

                {{-- Selection slot--}}
                @scope('selection', $option)
                {{ $option->name }}
                @endscope
            </x-choices>
        @endif

        @php $message = "Date à laquelle à commencée la maintenance.";@endphp
        <x-date-picker wire:model="form.started_at" name="form.started_at" class="form-control" :label-info="$message" icon="fas-calendar" icon-class="h-4 w-4" label="Maintenance commencée le" placeholder="Maintenance commencée le..." />

        <x-checkbox wire:model.live="form.is_finished" name="form.is_finished" label="Maintenance terminée ?" text="Cochez si la maintenance est terminée" />
        @if ($form->is_finished)
            @php $message = "Date à laquelle la maintenance a été terminée.";@endphp
            <x-date-picker wire:model="form.finished_at" name="form.finished_at" class="form-control" :label-info="$message" icon="fas-calendar" icon-class="h-4 w-4" label="Maintenance terminée le" placeholder="Maintenance terminée le..." />
        @endif

        @if ($isCreating && Gate::allows('create', \BDS\Models\PartExit::class))
            <div class="divider text-base-content text-opacity-70 uppercase">PIÈCES DÉTACHÉES</div>

            <x-button wire:click="addPart" label="Ajouter une pièce détachée" icon="fas-plus" class="btn btn-primary" />

            @foreach($form->parts as $key => $value)
                <x-choices
                    class="!h-12 !pr-8 xl:pr-16 pl-0 xl:pl-4"
                    flex-class="mt-4"
                    wire:model="form.parts.{{ $key }}.part_id"
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

                    <x-slot:prepend>
                        <x-button wire:click="removePart({{ $key }})" icon="fas-trash" class="rounded-r-none btn-error h-full" />
                    </x-slot:prepend>
                    <x-slot:append>
                        <input wire:model="form.parts.{{ $key }}.number" placeholder="Quantité..." class="input input-primary w-full h-full rounded-l-none @error("form.parts." . $key . ".number") input-error @enderror pl-1" type="number" name="form.parts.{{ $key }}.number" min="1" step="1">
                    </x-slot:append>
                </x-choices>
                <!-- ERRORS -->
                @error("form.parts." . $key . ".number")
                    <div class="text-red-500 label-text-alt p-1">{{ $message }}</div>
                @enderror
                @error("form.parts." . $key)
                    <div class="text-red-500 label-text-alt p-1">{{ $message }}</div>
                @enderror
            @endforeach
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

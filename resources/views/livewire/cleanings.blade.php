<div>
    <div class="flex flex-col lg:flex-row gap-4 justify-between">
        <div>
            @canany(['export', 'delete'], \BDS\Models\Cleaning::class)
                <div class="dropdown">
                    <label tabindex="0" class="btn btn-neutral m-1">
                        Actions
                        <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-caret-down-fill align-bottom" viewBox="0 0 16 16">
                            <path d="M7.247 11.14 2.451 5.658C1.885 5.013 2.345 4 3.204 4h9.592a1 1 0 0 1 .753 1.659l-4.796 5.48a1 1 0 0 1-1.506 0z"/>
                        </svg>
                    </label>
                    <ul tabindex="0" class="dropdown-content menu p-2 shadow bg-base-100 rounded-box w-52 z-[1]">
                        @can('export', \BDS\Models\Cleaning::class)
                            <li>
                                <button type="button" class="text-blue-500" wire:click="exportSelected()">
                                    <x-icon name="fas-download" class="h-5 w-5"></x-icon>
                                    Exporter
                                </button>
                            </li>
                        @endcan
                        @if (auth()->user()->can('delete', \BDS\Models\Cleaning::class) && getPermissionsTeamId() !== settings('site_id_verdun_siege'))
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
            @if(Gate::allows('generatePlan', \BDS\Models\Cleaning::class) && settings('cleaning_create_enabled', true))
                <x-button type="button" class="btn btn-info gap-2" wire:click="generatePlan" spinner>
                    <x-icon name="fas-file-lines" class="h-5 w-5"></x-icon>
                    Générer le Plan de Nettoyage
                </x-button>
            @endcan
            @if (settings('cleaning_create_enabled', true) && auth()->user()->can('create', \BDS\Models\Cleaning::class))
                <x-button type="button" class="btn btn-success gap-2" wire:click="create" spinner>
                    <x-icon name="fas-plus" class="h-5 w-5"></x-icon>
                    Nouveau Nettoyage
                </x-button>
            @endif
        </div>
    </div>

    <x-table.table class="mb-6">
        <x-slot name="head">
            @canany(['export', 'delete'], \BDS\Models\Cleaning::class)
                <x-table.heading>
                    <label>
                        <input type="checkbox" class="checkbox" wire:model.live="selectPage" />
                    </label>
                </x-table.heading>
            @endcanany
            @if(Gate::allows('update', \BDS\Models\Cleaning::class) && getPermissionsTeamId() !== settings('site_id_verdun_siege'))
                <x-table.heading>Actions</x-table.heading>
            @endif
            <x-table.heading sortable wire:click="sortBy('id')" :direction="$sortField === 'id' ? $sortDirection : null">#Id</x-table.heading>
            <x-table.heading sortable wire:click="sortBy('material_id')" :direction="$sortField === 'material_id' ? $sortDirection : null">Matériel</x-table.heading>
            <x-table.heading>Zone</x-table.heading>
            @if(getPermissionsTeamId() === settings('site_id_verdun_siege'))
                <x-table.heading sortable wire:click="sortBy('site_id')" :direction="$sortField === 'site_id' ? $sortDirection : null">Site</x-table.heading>
            @endif
            <x-table.heading sortable wire:click="sortBy('user_id')" :direction="$sortField === 'user_id' ? $sortDirection : null">Créateur</x-table.heading>
            <x-table.heading sortable wire:click="sortBy('description')" :direction="$sortField === 'description' ? $sortDirection : null">Description</x-table.heading>
            <x-table.heading sortable wire:click="sortBy('type')" :direction="$sortField === 'type' ? $sortDirection : null">Fréquence</x-table.heading>
            {{var_dump(getPermissionsTeamId())}}
                @if(getPermissionsTeamId() === settings('site_id_selvah'))
                <x-table.heading sortable wire:click="sortBy('ph_test_water')" :direction="$sortField === 'ph_test_water' ? $sortDirection : null">PH de l'eau</x-table.heading>
                <x-table.heading sortable wire:click="sortBy('ph_test_water_after_cleaning')" :direction="$sortField === 'ph_test_water_after_cleaning' ? $sortDirection : null">PH de l'eau <br>après nettoyage</x-table.heading>
            @endif
            <x-table.heading sortable wire:click="sortBy('created_at')" :direction="$sortField === 'created_at' ? $sortDirection : null">Créé le</x-table.heading>
        </x-slot>

        <x-slot name="body">
            @can('search', \BDS\Models\Cleaning::class)
                <x-table.row>
                    @canany(['export', 'delete'], \BDS\Models\Cleaning::class)
                        <x-table.cell></x-table.cell>
                    @endcanany
                    @if(Gate::allows('update', \BDS\Models\Cleaning::class) && getPermissionsTeamId() !== settings('site_id_verdun_siege'))
                        <x-table.cell></x-table.cell>
                    @endif
                    <x-table.cell>
                        <x-input wire:model.live.debounce.400ms="filters.id" name="filters.id" type="number" min="1" step="1"  />
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
                        <x-select
                            :options="\BDS\Enums\Frequences::toSelectArray()"
                            class="select-primary"
                            wire:model.live="filters.type"
                            name="filters.type"
                        />
                    </x-table.cell>
                    @if(getPermissionsTeamId() === settings('site_id_selvah'))
                        <x-table.cell></x-table.cell>
                        <x-table.cell></x-table.cell>
                    @endif
                    <x-table.cell>
                        <x-date-picker wire:model.live="filters.created_min" name="filters.created_min" class="input-sm" icon="fas-calendar" icon-class="h-4 w-4" placeholder="Date minimum de création" />
                        <x-date-picker wire:model.live="filters.created_max" name="filters.created_max" class="input-sm mt-2" icon="fas-calendar" icon-class="h-4 w-4 mt-[0.25rem]" placeholder="Date maximum de création" />
                    </x-table.cell>
                </x-table.row>
            @endcan

            @if ($selectPage)
                <x-table.row wire:key="row-message">
                    <x-table.cell colspan="11">
                        @unless ($selectAll)
                            <div>
                                <span>Vous avez sélectionné <strong>{{ $cleanings->count() }}</strong> nettoyage(s), voulez-vous tous les sélectionner <strong>{{ $cleanings->total() }}</strong>?</span>
                                <x-button type="button" wire:click='setSelectAll' class="btn btn-neutral btn-sm gap-2 ml-1" spinner>
                                    <x-icon name="fas-check" class="inline h-4 w-4"></x-icon>
                                    Tout sélectionner
                                </x-button>
                            </div>
                        @else
                            <span>Vous sélectionnez actuellement <strong>{{ $cleanings->total() }}</strong> nettoyage(s).</span>
                        @endif
                    </x-table.cell>
                </x-table.row>
            @endif

            @forelse($cleanings as $cleaning)
                <x-table.row wire:loading.class.delay="opacity-50" wire:key="row-{{ $cleaning->getKey() }}">
                    @canany(['export', 'delete'], \BDS\Models\Cleaning::class)
                        <x-table.cell>
                            <label>
                                <input type="checkbox" class="checkbox" wire:model.live="selected" value="{{ $cleaning->getKey() }}" />
                            </label>
                        </x-table.cell>
                    @endcanany
                    @can('update', $cleaning)
                        <x-table.cell>
                            <a href="#" wire:click.prevent="edit({{ $cleaning->getKey() }})" class="tooltip tooltip-right" data-tip="Modifier ce nettoyage">
                                <x-icon name="fas-pen-to-square" class="h-4 w-4"></x-icon>
                            </a>
                        </x-table.cell>
                    @endcan
                    <x-table.cell>{{ $cleaning->getKey() }}</x-table.cell>
                    <x-table.cell>
                        <a class="link link-hover link-primary font-bold" href="{{ $cleaning->material->show_url }}">
                            {{ $cleaning->material->name }}
                        </a>
                    </x-table.cell>
                    <x-table.cell>
                        {{ $cleaning->material->zone->name }}
                    </x-table.cell>
                    @if(getPermissionsTeamId() === settings('site_id_verdun_siege'))
                        <x-table.cell>
                            <a class="link link-hover link-primary font-bold" href="{{ $cleaning->site->show_url }}">
                                {{ $cleaning->site->name }}
                            </a>
                        </x-table.cell>
                    @endif
                    <x-table.cell>
                        <a class="link link-hover link-primary font-bold" href="{{ $cleaning->user->show_url }}">
                            {{ $cleaning->user->full_name }}
                        </a>
                    </x-table.cell>
                    <x-table.cell>
                        <span class="tooltip tooltip-top text-left" data-tip="{{ $cleaning->description }}">
                            {{ Str::limit($cleaning->description, 50) }}
                        </span>
                    </x-table.cell>
                    <x-table.cell>
                        {{ $cleaning->type->label()  }}
                    </x-table.cell>
                    @if(session('current_site_id') == 2)
                        <x-table.cell>
                            @if ($cleaning->type->value == 'weekly' && $cleaning->selvah_ph_test_water !== null)
                                <code class="code rounded-sm">
                                    @if ($cleaning->selvah_ph_test_water !== $cleaning->selvah_ph_test_water_after_cleaning)
                                        <span class="font-bold text-red-500">
                                        {{ $cleaning->selvah_ph_test_water }}
                                    </span>
                                    @else
                                        <span class="font-bold text-green-500">
                                        {{ $cleaning->selvah_ph_test_water }}
                                    </span>
                                    @endif
                                </code>
                            @endif
                        </x-table.cell>
                        <x-table.cell>
                            @if ($cleaning->type->value == 'weekly' && $cleaning->selvah_ph_test_water_after_cleaning !== null)
                                <code class="code rounded-sm">
                                    @if ($cleaning->selvah_ph_test_water_after_cleaning !== $cleaning->selvah_ph_test_water)
                                        <span class="font-bold text-red-500">
                                            {{ $cleaning->selvah_ph_test_water_after_cleaning }}
                                        </span>
                                    @else
                                        <span class="font-bold text-green-500">
                                            {{ $cleaning->selvah_ph_test_water_after_cleaning }}
                                        </span>
                                    @endif
                                </code>
                            @endif
                        </x-table.cell>
                    @endif

                    <x-table.cell class="capitalize">
                        {{ $cleaning->created_at->translatedFormat( 'D j M Y H:i') }}
                    </x-table.cell>
                </x-table.row>
            @empty
                <x-table.row>
                    <x-table.cell colspan="11">
                        <div class="text-center p-2">
                            <span class="text-muted">Aucun nettoyage trouvé...</span>
                        </div>
                    </x-table.cell>
                </x-table.row>
            @endforelse
        </x-slot>
    </x-table.table>

    <div class="grid grid-cols-1">
        {{ $cleanings->links() }}
    </div>


    <!-- Delete Cleaning Modal -->
    <x-modal wire:model="showDeleteModal" title="Supprimer les Nettoyages">
        @if (empty($selected))
            <p class="my-7">
                Vous n'avez sélectionné aucun nettoyage à supprimer.
            </p>
        @else
            <p class="my-7">
                Voulez-vous vraiment supprimer ces nettoyages ? <span class="font-bold text-red-500">Cette opération n'est pas réversible.</span>
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

    <!-- Create/Edit Cleaning Modal -->
    <x-modal wire:model="showModal" title="{{ $isCreating ? 'Créer un Nettoyage' : 'Editer le Nettoyage' }}">
        @php $message = "Sélectionnez le matériel que vous avez nettoyé.";@endphp
        <x-choices
            label="Matériel"
            :label-info="$message"
            wire:model.live="form.material_id"
            :options="$form->materialsSearchable"
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

        @php $message = "Si vous avez des informations complémentaires à renseigner, veuillez le faire dans la case ci-dessous.";@endphp
         <x-textarea wire:model="form.description" name="form.description" label="Description du nettoyage" placeholder="Informations complémentaires..." rows="3" :label-info="$message" />

        @php $message = "Sélectionnez la fréquence de nettoyage.";@endphp
        <x-select
            :options="\BDS\Enums\Frequences::toSelectArray(false)"
            class="select-primary"
            wire:model.live="form.type"
            name="form.type"
            label="Fréquence de nettoyage"
            :label-info="$message"
            placeholder="Sélectionnez la fréquence"
        />

        @if ($form->type == 'weekly' && $materialCleaningTestPhEnabled && getPermissionsTeamId() === settings('site_id_selvah'))
            <div class="divider text-base-content text-opacity-70 uppercase">SELVAH</div>

            @php $message = "Veuillez renseigner le PH de l'eau du réseau.";@endphp
            <x-input wire:model="form.selvah_ph_test_water" name="form.selvah_ph_test_water" type="number" label="Test PH de l'eau du réseau" placeholder="PH..." min="1" step="0.5" :label-info="$message"  />

            @php $message = "Veuillez renseigner le PH de l'eau après nettoyage.";@endphp
            <x-input wire:model="form.selvah_ph_test_water_after_cleaning" name="form.selvah_ph_test_water_after_cleaning" type="number" label="Test PH après nettoyage" placeholder="PH..." min="1" step="0.5" :label-info="$message"  />
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

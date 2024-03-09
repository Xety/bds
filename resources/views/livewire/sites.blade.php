<div>
    <div class="flex flex-col lg:flex-row gap-4 justify-between">
        <div>
            @canany(['delete'], \BDS\Models\Site::class)
                <div class="dropdown">
                    <label tabindex="0" class="btn btn-neutral m-1">
                        Actions
                        <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-caret-down-fill align-bottom" viewBox="0 0 16 16">
                            <path d="M7.247 11.14 2.451 5.658C1.885 5.013 2.345 4 3.204 4h9.592a1 1 0 0 1 .753 1.659l-4.796 5.48a1 1 0 0 1-1.506 0z"/>
                        </svg>
                    </label>
                    <ul tabindex="0" class="dropdown-content menu p-2 shadow bg-base-100 rounded-box w-52 z-[1]">
                        @can('delete', \BDS\Models\Site::class)
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
            @can('create', \BDS\Models\Site::class)
                <x-button type="button" class="btn btn-success gap-2" wire:click="create" spinner>
                    <x-icon name="fas-plus" class="h-5 w-5"></x-icon>
                    Nouveau Site
                </x-button>
            @endcan
        </div>
    </div>

    <x-table.table class="mb-6">
        <x-slot name="head">
            @canany(['delete'], \BDS\Models\Site::class)
                <x-table.heading>
                    <label>
                        <input type="checkbox" class="checkbox" wire:model.live="selectPage" />
                    </label>
                </x-table.heading>
            @endcanany
            @can('update', \BDS\Models\Site::class)
                <x-table.heading>Actions</x-table.heading>
            @endcan
                <x-table.heading sortable wire:click="sortBy('id')" :direction="$sortField === 'id' ? $sortDirection : null">Id</x-table.heading>
            <x-table.heading sortable wire:click="sortBy('name')" :direction="$sortField === 'name' ? $sortDirection : null">Nom</x-table.heading>
            <x-table.heading>Responsables</x-table.heading>
            <x-table.heading sortable wire:click="sortBy('zone_count')" :direction="$sortField === 'zone_count' ? $sortDirection : null">Nombre de Zones</x-table.heading>
            <x-table.heading sortable wire:click="sortBy('created_at')" :direction="$sortField === 'created_at' ? $sortDirection : null">Créé le</x-table.heading>
        </x-slot>

        <x-slot name="body">
            @can('search', \BDS\Models\Site::class)
                <x-table.row>
                    @can('delete', \BDS\Models\Site::class)
                        <x-table.cell></x-table.cell>
                    @endcan
                    @can('update', \BDS\Models\Site::class)
                        <x-table.cell></x-table.cell>
                    @endcan
                    <x-table.cell></x-table.cell>
                    <x-table.cell>
                        <x-input wire:model.live.debounce.400ms="filters.name" name="filters.name" type="text" />
                    </x-table.cell>
                    <x-table.cell>
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
                    <x-table.cell colspan="4">
                        @unless ($selectAll)
                            <div>
                                <span>Vous avez sélectionné <strong>{{ $sites->count() }}</strong> site(s), voulez-vous tous les sélectionner <strong>{{ $sites->total() }}</strong>?</span>
                                <x-button type="button" wire:click='setSelectAll' class="btn btn-neutral btn-sm gap-2 ml-1" spinner>
                                    <x-icon name="fas-check" class="inline h-4 w-4"></x-icon>
                                    Tout sélectionner
                                </x-button>
                            </div>
                        @else
                            <span>Vous sélectionnez actuellement <strong>{{ $sites->total() }}</strong> zone(s).</span>
                        @endif
                    </x-table.cell>
                </x-table.row>
            @endif

            @forelse($sites as $site)
                <x-table.row wire:loading.class.delay="opacity-50" wire:key="row-{{ $site->getKey() }}">
                    @canany(['delete'], \BDS\Models\Site::class)
                        <x-table.cell>
                            <label>
                                <input type="checkbox" class="checkbox" wire:model.live="selected" value="{{ $site->getKey() }}" />
                            </label>
                        </x-table.cell>
                    @endcanany
                    @can('update', \BDS\Models\Site::class)
                         <x-table.cell>
                            <a href="#" wire:click.prevent="edit({{ $site->getKey() }})" class="tooltip tooltip-right" data-tip="Editer ce site">
                                <x-icon name="fas-pen-to-square" class="h-4 w-4"></x-icon>
                            </a>
                        </x-table.cell>
                    @endcan
                    <x-table.cell>
                        {{ $site->getKey() }}
                    </x-table.cell>
                    <x-table.cell>
                        <a class="link link-hover link-primary font-bold" href="{{ $site->show_url }}">
                            {{ $site->name }}
                        </a>
                    </x-table.cell>
                    <x-table.cell>
                        @foreach($site->managers as $manager)
                            <a class="link link-hover text-primary font-bold block" href="{{ route('users.show', $manager) }}">
                                {{ $manager->full_name }}
                            </a>
                        @endforeach
                    </x-table.cell>
                    <x-table.cell>
                        <code class="code rounded-sm">
                            {{ $site->zone_count }}
                        </code>
                    </x-table.cell>
                    <x-table.cell class="capitalize">
                        {{ $site->created_at->translatedFormat( 'D j M Y H:i') }}
                    </x-table.cell>
                </x-table.row>
            @empty
                <x-table.row>
                    <x-table.cell colspan="4">
                        <div class="text-center p-2">
                            <span class="text-muted">Aucune site trouvée...</span>
                        </div>
                    </x-table.cell>
                </x-table.row>
            @endforelse
        </x-slot>
    </x-table.table>

    <div class="grid grid-cols-1">
        {{ $sites->links() }}
    </div>


    <!-- Delete Sites Modal -->
    <x-modal wire:model="showDeleteModal" title="Supprimer les Sites">
        @if (empty($selected))
            <p class="my-7">
                Vous n'avez sélectionné aucun site à supprimer.
            </p>
        @else
            <p class="my-7">
                Êtes-vous sûr de vouloir supprimer ces sites ? <span class="font-bold text-red-500">Cette opération n'est pas réversible.</span>
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

    <!-- Create/Edit Site Modal -->
    <x-modal wire:model="showModal" title="{{ $isCreating ? 'Créer un Site' : 'Editer le Site' }}">

        <x-input wire:model="form.name" name="form.name" label="Nom" placeholder="Nom..." type="text" />

        @if($isCreating === false)
            @php $message = "Sélectionnez le/les responsables du site. <i>Note : Ces responsables servent uniquement pour obtenir les informations de ceux-ci afin de les afficher pour les saisonnier.</i>";@endphp
            <x-select
                :options="$users"
                class="select-primary"
                wire:model="form.managers"
                name="form.managers"
                label="Responsables"
                :label-info="$message"
                size="5"
                multiple
            />
        @endif

        @php $message = "Uniquement si le site dispose d'un mail.";@endphp
        <x-input wire:model="form.email" name="form.email" label="Email" placeholder="Email du site..." :label-info="$message" type="email" />

        @php $message = "Uniquement si le site dispose d'un téléphone de bureau.";@endphp
        <x-input wire:model="form.office_phone" name="form.office_phone" label="Téléphone bureau" placeholder="Téléphone bureau" :label-info="$message" type="text" />

        @php $message = "Uniquement si le site dispose d'un téléphone portable.";@endphp
        <x-input wire:model="form.cell_phone" name="form.cell_phone" label="Téléphone portable" placeholder="Téléphone portable" :label-info="$message" type="text" />

        <x-input wire:model="form.address" name="form.address" label="Adresse du site" placeholder="Adresse du site" type="text" />

        <div class="flex justify-between">
            <x-input wire:model="form.zip_code" name="form.zip_code" label="Code Postal" placeholder="Code postal du site" type="text" />
            <x-input wire:model="form.city" name="form.city" label="Ville" placeholder="Ville du site" type="text" />
        </div>


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

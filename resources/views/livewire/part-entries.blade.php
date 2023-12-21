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

            @can('viewOtherSite',\BDS\Models\PartEntry::class)
                <x-toggle label="Voir les Entrées de pièces des autres sites" wire:model.live="viewOtherSitePartEntry" />
            @endcan
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

                    @can('update', \BDS\Models\PartEntry::class)
                        <x-table.cell>
                            <a href="#" wire:click.prevent="edit({{ $partEntry->getKey() }})" class="tooltip tooltip-right" data-tip="Modifier cette entrée">
                                <x-icon name="fas-pen-to-square" class="h-4 w-4"></x-icon>
                            </a>
                        </x-table.cell>
                    @endcan

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
                        {{ $partEntry->user->full_name }}
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
    <form wire:submit.prevent="deleteSelected">
        <input type="checkbox" id="deleteModal" class="modal-toggle" wire:model="showDeleteModal" />
        <label for="deleteModal" class="modal cursor-pointer">
            <label class="modal-box relative">
                <label for="deleteModal" class="btn btn-sm btn-circle absolute right-2 top-2">✕</label>
                <h3 class="font-bold text-lg">
                    Supprimer les Entrées
                </h3>
                @if (empty($selected))
                    <p class="my-7">
                        Vous n'avez sélectionné aucune entrée à supprimer.
                    </p>
                @else
                    <p class="my-7">
                        Voulez-vous vraiment supprimer ces entrées de pièces détachées ? <span class="font-bold text-red-500">Cette opération n'est pas réversible.</span>
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

    <!-- Edit PartEntries Modal -->
    <form wire:submit.prevent="save">
        <input type="checkbox" id="editModal" class="modal-toggle" wire:model="showModal" />
        <label for="editModal" class="modal cursor-pointer">
            <label class="modal-box relative">
                <label for="editModal" class="btn btn-sm btn-circle absolute right-2 top-2">✕</label>
                <h3 class="font-bold text-lg">
                    {!! $isCreating ? 'Créer une Entrée' : 'Editer l\'Entrée' !!}
                </h3>

                {{-- Only display those fields for the creating modal --}}
                @if ($isCreating)
                    @php $message = "Sélectionnez la pièce détachée auquelle appartient l'entrée.";@endphp
                    <x-form.select wire:model.defer="model.part_id" name="model.part_id"  label="Pièce Détachée" :info="true" :infoText="$message">
                        <option  value="0">Sélectionnez une pièce détachée</option>
                        @foreach($parts as $part)
                            <option value="{{ $part['id'] }}">{{$part['name']}} @if (isset($part['material'])) ({{ $part['material']['name'] }}) @endif</option>
                        @endforeach
                    </x-form.select>

                    @php $message = "Nombre de pièce rentrée en stock.";@endphp
                    <x-form.number wire:model.defer="model.number" name="model.number" label="Nombre de pièce" placeholder="Nombre de pièce..." :info="true" :infoText="$message" />
                @endif

                @php $message = "N° de commande, laissez vide si aucun numéro.";@endphp
                <x-form.text wire:model.defer="model.order_id" name="model.order_id" label="N° commande" placeholder="N° commande..." :info="true" :infoText="$message" />

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

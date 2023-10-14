<div>
    @include('elements.flash')

    <div class="flex flex-col lg:flex-row gap-4 justify-between">
        <div>
            @canany(['delete'], \Spatie\Permission\Models\Permission::class)
                <div class="dropdown">
                    <label tabindex="0" class="btn btn-neutral m-1">
                        Actions
                        <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-caret-down-fill align-bottom" viewBox="0 0 16 16">
                            <path d="M7.247 11.14 2.451 5.658C1.885 5.013 2.345 4 3.204 4h9.592a1 1 0 0 1 .753 1.659l-4.796 5.48a1 1 0 0 1-1.506 0z"/>
                        </svg>
                    </label>
                    <ul tabindex="0" class="dropdown-content menu p-2 shadow bg-base-100 rounded-box w-52 z-[1]">
                        @can('delete', \Spatie\Permission\Models\Permission::class)
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
            @can('create', \Spatie\Permission\Models\Permission::class)
                <x-button type="button" class="btn btn-success gap-2" wire:click="create" spinner>
                    <x-icon name="fas-plus" class="h-5 w-5"></x-icon>
                    Nouvelle Permission
                </x-button>
            @endcan
        </div>
    </div>

    <x-table.table class="mb-6">
        <x-slot name="head">
            @canany(['delete'], \Spatie\Permission\Models\Permission::class)
                <x-table.heading>
                    <label>
                        <input type="checkbox" class="checkbox" wire:model.live="selectPage" />
                    </label>
                </x-table.heading>
            @endcanany
            @can('update', \Spatie\Permission\Models\Permission::class)
                <x-table.heading>Actions</x-table.heading>
            @endcan
            <x-table.heading sortable wire:click="sortBy('name')" :direction="$sortField === 'name' ? $sortDirection : null">Nom</x-table.heading>
            <x-table.heading sortable wire:click="sortBy('description')" :direction="$sortField === 'description' ? $sortDirection : null">Description</x-table.heading>
            <x-table.heading sortable wire:click="sortBy('created_at')" :direction="$sortField === 'created_at' ? $sortDirection : null">Créé le</x-table.heading>
        </x-slot>

        <x-slot name="body">
            @if ($selectPage)
                <x-table.row wire:key="row-message">
                    <x-table.cell colspan="6">
                        @unless ($selectAll)
                            <div>
                                <span>Vous avez sélectionné <strong>{{ $permissions->count() }}</strong> permission(s), voulez-vous tous les selectionner <strong>{{ $permissions->total() }}</strong>?</span>
                                <button type="button" wire:click="selectAll" class="btn btn-neutral btn-sm gap-2 ml-1">
                                    <i class="fa-solid fa-check"></i>
                                    Tout sélectionner
                                </button>
                            </div>
                        @else
                            <span>Vous sélectionnez actuellement <strong>{{ $permissions->total() }}</strong> permission(s).</span>
                        @endif
                    </x-table.cell>
                </x-table.row>
            @endif

            @forelse($permissions as $permission)
                <x-table.row wire:loading.class.delay="opacity-50" wire:key="row-{{ $permission->getKey() }}">
                    @canany(['delete'], \Spatie\Permission\Models\Permission::class)
                        <x-table.cell>
                            <label>
                                <input type="checkbox" class="checkbox" wire:model.live="selected" value="{{ $permission->getKey() }}" />
                            </label>
                        </x-table.cell>
                    @endcanany
                    @can('update', \Spatie\Permission\Models\Permission::class)
                        <x-table.cell>
                            <a href="#" wire:click.prevent="edit({{ $permission->getKey() }})" class="tooltip tooltip-right" data-tip="Editer cette permission">
                                <x-icon name="fas-pen-to-square" class="h-4 w-4"></x-icon>
                            </a>
                        </x-table.cell>
                    @endcan
                    <x-table.cell class="prose">
                        <code class="text-neutral-content bg-[color:var(--tw-prose-pre-bg)] rounded-sm">
                            {{ $permission->name }}
                        </code>
                    </x-table.cell>
                    <x-table.cell>
                        {{ $permission->description }}
                    </x-table.cell>
                    <x-table.cell class="capitalize">{{ $permission->created_at?->translatedFormat( 'D j M Y H:i') }}</x-table.cell>
                </x-table.row>
            @empty
                <x-table.row>
                    <x-table.cell colspan="6">
                        <div class="text-center p-2">
                            <span class="text-muted">Aucune permission trouvée...</span>
                        </div>
                    </x-table.cell>
                </x-table.row>
            @endforelse
        </x-slot>
    </x-table.table>

    <div class="grid grid-cols-1">
        {{ $permissions->links() }}
    </div>


    <!-- Delete Permissions Modal -->
    <form wire:submit.prevent="deleteSelected">
        <input type="checkbox" id="deleteModal" class="modal-toggle" wire:model="showDeleteModal" />
        <label for="deleteModal" class="modal cursor-pointer">
            <label class="modal-box relative">
                <label for="deleteModal" class="btn btn-sm btn-circle absolute right-2 top-2">✕</label>
                <h3 class="font-bold text-lg">
                    Supprimer les Permissions
                </h3>
                @if (empty($selected))
                    <p class="my-7">
                        Vous n'avez sélectionné aucune permission à supprimer.
                    </p>
                @else
                    <p class="my-7">
                       Êtes-vous sûr de vouloir supprimer ces permissions ? <span class="font-bold text-red-500">Cette opération n'est pas réversible.</span>
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

    <!-- Edit Permission Modal -->
    <form wire:submit.prevent="save">
        <input type="checkbox" id="editModal" class="modal-toggle" wire:model="showModal" />
        <label for="editModal" class="modal cursor-pointer">
            <label class="modal-box relative">
                <label for="editModal" class="btn btn-sm btn-circle absolute right-2 top-2">✕</label>
                <h3 class="font-bold text-lg">
                    {!! $isCreating ? 'Créer une Permission' : 'Editer la Permission' !!}
                </h3>

                <x-form.text wire:model="model.name" id="name" name="model.name" label="Nom" placeholder="Nom..." />

                <x-form.textarea wire:model="model.description" name="model.description" label="Description" placeholder="Description..." />

                <div class="modal-action">
                    <x-button class="btn btn-success gap-2" type="button" wire:click="save" spinner>
                        @if($isCreating)
                            <x-icon name="fas-user-plus" class="h-5 w-5"></x-icon> Créer
                        @else
                            <x-icon name="fas-user-pen" class="h-5 w-5"></x-icon> Editer
                        @endif
                    </x-button>
                    <label for="editModal" class="btn btn-neutral">Fermer</label>
                </div>
            </label>
        </label>
    </form>

</div>

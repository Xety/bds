<div>
    @include('elements.flash')

    <div class="flex flex-col lg:flex-row gap-6 justify-between">
        <div class="mb-4 w-full lg:w-auto lg:min-w-[350px]">
            <x-form.text wire:model="search" placeholder="Rechercher des Rôles..." class="lg:max-w-lg" />
        </div>
        <div class="mb-4">
            @canany(['delete'], \Spatie\Permission\Models\Role::class)
                <div class="dropdown lg:dropdown-end">
                    <label tabindex="0" class="btn btn-neutral m-1">
                        Actions
                        <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-caret-down-fill align-bottom" viewBox="0 0 16 16">
                            <path d="M7.247 11.14 2.451 5.658C1.885 5.013 2.345 4 3.204 4h9.592a1 1 0 0 1 .753 1.659l-4.796 5.48a1 1 0 0 1-1.506 0z"/>
                        </svg>
                    </label>
                    <ul tabindex="0" class="dropdown-content menu p-2 shadow bg-base-100 rounded-box w-52 z-[1]">
                        @can('delete', \Spatie\Permission\Models\Role::class)
                            <li>
                                <button type="button" class="text-red-500" wire:click="$toggle('showDeleteModal')">
                                    <i class="fa-solid fa-trash-can"></i> Supprimer
                                </button>
                            </li>
                        @endcan
                    </ul>
                </div>
            @endcanany

            @can('create', \Spatie\Permission\Models\Role::class)
                <a href="#" wire:click.prevent="create" class="btn btn-success gap-2">
                    <i class="fa-solid fa-plus"></i>
                    Nouveau Rôle
                </a>
            @endcan
        </div>
    </div>

    <x-table.table class="mb-6">
        <x-slot name="head">
            @canany(['delete'], \Spatie\Permission\Models\Role::class)
                <x-table.heading>
                    <label>
                        <input type="checkbox" class="checkbox" wire:model="selectPage" />
                    </label>
                </x-table.heading>
            @endcanany
            @can('update', \Spatie\Permission\Models\Role::class)
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
                                <span>Vous avez sélectionné <strong>{{ $roles->count() }}</strong> rôle(s), voulez-vous tous les selectionner <strong>{{ $roles->total() }}</strong>?</span>
                                <button type="button" wire:click="selectAll" class="btn btn-neutral btn-sm gap-2 ml-1">
                                    <i class="fa-solid fa-check"></i>
                                    Tout sélectionner
                                </button>
                            </div>
                        @else
                            <span>Vous sélectionnez actuellement <strong>{{ $roles->total() }}</strong> rôle(s).</span>
                        @endif
                    </x-table.cell>
                </x-table.row>
            @endif

            @forelse($roles as $role)
                <x-table.row wire:loading.class.delay="opacity-50" wire:key="row-{{ $role->getKey() }}">
                    @canany(['delete'], \Spatie\Permission\Models\Role::class)
                        <x-table.cell>
                            <label>
                                <input type="checkbox" class="checkbox" wire:model="selected" value="{{ $role->getKey() }}" />
                            </label>
                        </x-table.cell>
                    @endcanany
                    @can('update', \Spatie\Permission\Models\Role::class)
                        <x-table.cell>
                            <a href="#" wire:click.prevent="edit({{ $role->getKey() }})" class="tooltip tooltip-right" data-tip="Editer ce rôle">
                                <i class="fa-solid fa-pen-to-square"></i>
                            </a>
                        </x-table.cell>
                    @endcan
                    <x-table.cell class="font-bold" style="{{ $role->css }}">
                        {{ $role->name }}
                    </x-table.cell>
                    <x-table.cell>
                        {{ $role->description }}
                    </x-table.cell>
                    <x-table.cell class="capitalize">{{ $role->created_at->translatedFormat( 'D j M Y H:i') }}</x-table.cell>
                </x-table.row>
            @empty
                <x-table.row>
                    <x-table.cell colspan="6">
                        <div class="text-center p-2">
                            <span class="text-muted">Aucun rôle trouvé...</span>
                        </div>
                    </x-table.cell>
                </x-table.row>
            @endforelse
        </x-slot>
    </x-table.table>

    <div class="grid grid-cols-1">
        {{ $roles->links() }}
    </div>


    <!-- Delete Roles Modal -->
    <form wire:submit.prevent="deleteSelected">
        <input type="checkbox" id="deleteModal" class="modal-toggle" wire:model="showDeleteModal" />
        <label for="deleteModal" class="modal cursor-pointer">
            <label class="modal-box relative">
                <label for="deleteModal" class="btn btn-sm btn-circle absolute right-2 top-2">✕</label>
                <h3 class="font-bold text-lg">
                    Supprimer les Rôles
                </h3>
                @if (empty($selected))
                    <p class="my-7">
                        Vous n'avez sélectionné aucun rôle à supprimer.
                    </p>
                @else
                    <p class="my-7">
                        Êtes-vous sûr de vouloir supprimer ces rôles ? <span class="font-bold text-red-500">Cette opération n'est pas réversible.</span>
                    </p>
                @endif
                <div class="modal-action">
                    <button type="submit" class="btn btn-neutral btn-error gap-2" @if (empty($selected)) disabled @endif>
                        <i class="fa-solid fa-trash-can"></i>
                        Supprimer
                    </button>
                    <label for="deleteModal" class="btn btn-neutral">Fermer</label>
                </div>
            </label>
        </label>
    </form>

    <!-- Edit Role Modal -->
    <form wire:submit.prevent="save">
        <input type="checkbox" id="editModal" class="modal-toggle" wire:model="showModal" />
        <label for="editModal" class="modal cursor-pointer">
            <label class="modal-box relative">
                <label for="editModal" class="btn btn-sm btn-circle absolute right-2 top-2">✕</label>
                <h3 class="font-bold text-lg">
                    {!! $isCreating ? 'Créer un Rôle' : 'Editer le Rôle' !!}
                </h3>

                <x-form.text wire:model="model.name" id="name" name="model.name" label="Nom" placeholder="Nom..." />

                <x-form.text wire:model="model.css" name="model.css" label="CSS" />

                <x-form.select size="8" wire:model="permissionsSelected" name="permissionsSelected"  label="Permissions" multiple>
                    @foreach($permissions as $permissionId => $permissionName)
                    <option  value="{{ $permissionId }}">{{$permissionName}}</option>
                    @endforeach
                </x-form.select>

                <x-form.textarea wire:model="model.description" name="model.description" label="Description" placeholder="Description..." />

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

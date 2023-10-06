<div>
    @include('elements.flash')

    <div class="flex flex-col lg:flex-row gap-4 justify-between">
        <div>
            @canany(['delete'], \BDS\Models\User::class)
                <div class="dropdown">
                    <label tabindex="0" class="btn btn-neutral m-1">
                        Actions
                        <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-caret-down-fill align-bottom" viewBox="0 0 16 16">
                            <path d="M7.247 11.14 2.451 5.658C1.885 5.013 2.345 4 3.204 4h9.592a1 1 0 0 1 .753 1.659l-4.796 5.48a1 1 0 0 1-1.506 0z"/>
                        </svg>
                    </label>
                    <ul tabindex="0" class="dropdown-content menu p-2 shadow bg-base-100 rounded-box w-52 z-[1]">
                        @can('delete', \BDS\Models\User::class)
                            <li>
                                <button type="button" class="text-red-500" wire:click="$toggle('showDeleteModal')">
                                    <i class="fa-solid fa-trash-can"></i> Supprimer
                                </button>
                            </li>
                        @endcan
                    </ul>
                </div>
            @endcanany
        </div>
        <div class="mb-4">
            @can('create', \BDS\Models\User::class)
                <a href="#" wire:click.prevent="create" class="btn btn-success gap-2">
                    <i class="fa-solid fa-plus"></i>
                    Nouvel Utilisateur
                </a>
            @endcan
        </div>
    </div>

    <x-table.table class="mb-6">
        <x-slot name="head">
            @can('delete', \BDS\Models\User::class)
                <x-table.heading>
                    <label>
                        <input type="checkbox" class="checkbox" wire:model.live="selectPage" />
                    </label>
                </x-table.heading>
            @endcan
            @can('update', \BDS\Models\User::class)
                <x-table.heading>Actions</x-table.heading>
            @endcan
            <x-table.heading sortable wire:click="sortBy('id')" :direction="$sortField === 'id' ? $sortDirection : null">#Id</x-table.heading>
            <x-table.heading sortable wire:click="sortBy('username')" :direction="$sortField === 'username' ? $sortDirection : null">Nom d'Utilisateur</x-table.heading>
            <x-table.heading sortable wire:click="sortBy('first_name')" :direction="$sortField === 'first_name' ? $sortDirection : null">Prénom</x-table.heading>
            <x-table.heading sortable wire:click="sortBy('last_name')" :direction="$sortField === 'last_name' ? $sortDirection : null">Nom</x-table.heading>
            <x-table.heading sortable wire:click="sortBy('email')" :direction="$sortField === 'email' ? $sortDirection : null">Email</x-table.heading>
            <x-table.heading>Rôles</x-table.heading>
            <x-table.heading>Supprimé</x-table.heading>
            <x-table.heading sortable wire:click="sortBy('last_login')" :direction="$sortField === 'last_login' ? $sortDirection : null">Dernière connexion</x-table.heading>
            <x-table.heading sortable wire:click="sortBy('created_at')" :direction="$sortField === 'created_at' ? $sortDirection : null">Créé le</x-table.heading>
        </x-slot>

        <x-slot name="body">
            @can('search', \BDS\Models\User::class)
                <x-table.row wire:key="row-message">
                    @can('delete', \BDS\Models\User::class)
                        <x-table.cell></x-table.cell>
                    @endcan
                    @can('update', \BDS\Models\User::class)
                        <x-table.cell></x-table.cell>
                    @endcan
                    <x-table.cell></x-table.cell>
                    <x-table.cell>
                        <x-form.text wire:model.live.debounce.250ms="filters.username" class="" />
                    </x-table.cell>
                    <x-table.cell>
                        <x-form.text wire:model.live.debounce.250ms="filters.first_name" class="" />
                    </x-table.cell>
                    <x-table.cell>
                        <x-form.text wire:model.live.debounce.250ms="filters.last_name" class="" />
                    </x-table.cell>
                    <x-table.cell>
                        <x-form.text wire:model.live.debounce.250ms="filters.email" class="" />
                    </x-table.cell>
                    <x-table.cell>
                        <x-form.text wire:model.live.debounce.250ms="filters.role" class="" />
                    </x-table.cell>
                    <x-table.cell>
                        <x-form.select wire:model.live.debounce.250ms="filters.is_deleted">
                            <option value="">Tous</option>
                            <option  value="yes">Oui</option>
                            <option  value="no">Non</option>
                        </x-form.select>
                    </x-table.cell>
                    <x-table.cell></x-table.cell>
                    <x-table.cell>
                        <x-form.date class="input input-xs input-bordered join-item w-full mb-2" wire:model.live.debounce.250ms="filters.created-min" :join="true" :joinIcon="'fa-solid fa-calendar'" placeholder="Date minimum de création" />
                        <x-form.date wire:model.live.debounce.250ms="filters.created-max" :join="true" :joinIcon="'fa-solid fa-calendar'" placeholder="Date maximum de création" />
                    </x-table.cell>
                </x-table.row>
            @endcan

            @if ($selectPage)
                <x-table.row wire:key="row-message">
                    <x-table.cell colspan="11">
                        @unless ($selectAll)
                            <div>
                                <span>Vous avez sélectionné <strong>{{ $users->count() }}</strong> utilisateur(s), voulez-vous tous les sélectionner <strong>{{ $users->total() }}</strong>?</span>
                                <button type="button" wire:click="selectAll" class="btn btn-neutral btn-sm gap-2 ml-1">
                                    <i class="fa-solid fa-check"></i>
                                    Tout sélectionner
                                </button>
                            </div>
                        @else
                            <span>Vous sélectionnez actuellement <strong>{{ $users->total() }}</strong> utilisateur(s).</span>
                        @endif
                    </x-table.cell>
                </x-table.row>
            @endif

            @forelse($users as $user)
                <x-table.row wire:loading.class.delay="opacity-50" wire:key="row-{{ $user->getKey() }}">
                    @canany(['delete'], \BDS\Models\User::class)
                        <x-table.cell>
                            <label>
                                <input type="checkbox" class="checkbox" wire:model.live="selected" value="{{ $user->getKey() }}" />
                            </label>
                        </x-table.cell>
                    @endcanany
                    @can('update', \BDS\Models\User::class)
                        <x-table.cell>
                            <a href="#" wire:click.prevent="edit({{ $user->getKey() }})" class="tooltip tooltip-right" data-tip="Modifier cet utilisateur">
                                <i class="fa-solid fa-pen-to-square"></i>
                            </a>
                        </x-table.cell>
                    @endcan
                    <x-table.cell>{{ $user->getKey() }}</x-table.cell>
                    <x-table.cell>
                        <span class="text-primary">
                            {{ $user->username }}
                        </span>
                    </x-table.cell>
                    <x-table.cell>
                        {{ $user->first_name }}
                    </x-table.cell>
                    <x-table.cell>
                        {{ $user->last_name }}
                    </x-table.cell>
                    <x-table.cell>{{ $user->email }}</x-table.cell>
                    <x-table.cell>
                        @forelse ($user->roles as $role)
                            <span class="block" style="{{ $role->css }}">
                                {{ $role->name }}
                            </span>
                        @empty
                            Cet utilisateur n'a pas de rôle.
                        @endforelse
                    </x-table.cell>
                    <x-table.cell>
                        @if ($user->deleted_at)
                            <span class="text-error font-bold tooltip tooltip-top" datat-tip="Supprimé le {{ $user->deleted_at }}">
                                Oui
                            </span>
                        @else
                            <span class="text-success font-bold">
                                Non
                            </span>
                        @endif
                    </x-table.cell>
                    <x-table.cell class="capitalize">
                        {{ $user->last_login_date?->translatedFormat( 'D j M Y H:i') }}
                    </x-table.cell>
                    <x-table.cell class="capitalize">
                        {{ $user->created_at->translatedFormat( 'D j M Y H:i') }}
                    </x-table.cell>
                </x-table.row>
            @empty
                <x-table.row>
                    <x-table.cell colspan="11">
                        <div class="text-center p-2">
                            <span class="text-muted">Aucun utilisateur trouvé...</span>
                        </div>
                    </x-table.cell>
                </x-table.row>
            @endforelse
        </x-slot>
    </x-table.table>

    <div class="grid grid-cols-1">
        {{ $users->links() }}
    </div>


    <!-- Delete Users Modal -->
    <form wire:submit.prevent="deleteSelected">
        <input type="checkbox" id="deleteModal" class="modal-toggle" wire:model.live="showDeleteModal" />
        <label for="deleteModal" class="modal cursor-pointer">
            <label class="modal-box relative">
                <label for="deleteModal" class="btn btn-sm btn-circle absolute right-2 top-2">✕</label>
                <h3 class="font-bold text-lg">
                    Supprimer les Utilisateurs
                </h3>
                @if (empty($selected))
                    <p class="my-7">
                        Vous n'avez sélectionné aucun utilisateur à supprimer.
                    </p>
                @else
                    <p class="my-7">
                        Voulez-vous vraiment supprimer ces utilisateurs ? <span class="font-bold text-red-500 block">Cette opération va désactiver la connexion aux comptes sélectionnés.</span>
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

    <!-- Edit Users Modal -->
    <form wire:submit.prevent="save">
        <input type="checkbox" id="editModal" class="modal-toggle" wire:model.live="showModal" />
        <label for="editModal" class="modal cursor-pointer">
            <label class="modal-box relative">
                <label for="editModal" class="btn btn-sm btn-circle absolute right-2 top-2">✕</label>
                <h3 class="font-bold text-lg">
                    {!! $isCreating ? 'Créer un Utilisateur' : 'Editer l\'Utilisateur' !!}
                </h3>

                @if ($form->user?->trashed())
                    <div>
                        <x-alert type="error" class="max-w-lg mb-4" title="Attention">
                            <span class="font-bold">Cet utilisateur a été supprimé le {{ $form->user->deleted_at->translatedFormat( 'D j M Y à H:i') }} par {{ $form->user->deletedUser->full_name }}.</span>
                            <br> Vous devez le restaurer avant de faire une modification de cet utilisateur.
                        </x-alert>
                    </div>
                @endif

                <x-form.text wire:model="form.username" name="form.username" label="Nom d'Utilisateur" placeholder="Nom d'Utilisateur..." disabled />

                <x-form.text wire:model="form.first_name" name="form.first_name" label="Prénom" placeholder="Prénom..." wire:keyup.debounce.250ms="generateUsername()" />
                <x-form.text wire:model="form.last_name" name="form.last_name" label="Nom" placeholder="Nom..." wire:keyup.debounce.250ms="generateUsername()" />

                <x-form.email wire:model="form.email" name="form.email" label="Email" placeholder="Email..." />

                @php $message = "Uniquement si vous disposez d'un téléphone à votre bureau.";@endphp
                <x-form.text wire:model="form.office_phone" name="form.office_phone" label="Téléphone bureau" placeholder="Téléphone bureau" :info="true" :infoText="$message" />

                @php $message = "Uniquement un numéro de téléphone portable utilisé dans le cadre professionnel.";@endphp
                <x-form.text wire:model="form.cell_phone" name="form.cell_phone" label="Téléphone portable" placeholder="Téléphone portable" :info="true" :infoText="$message" />

                <div>
                    <x-alert type="info" class="max-w-lg mt-4" title="Information">
                        Le ou les rôle(s) sélectionné(s) seront appliqué <span class="font-bold italic">uniquement</span> sur le site <span class="font-bold">{{ $site->name }}</span>.
                    </x-alert>
                </div>
                @php $message = "Sélectionnez le/les rôle(s) de l'utilisateur.";@endphp
                <x-form.select wire:model="form.rolesSelected" name="form.rolesSelected"  label="Rôles" multiple :info="true" :infoText="$message">
                    @foreach($roles as $roleId => $roleName)
                    <option  value="{{ $roleId }}">{{$roleName}}</option>
                    @endforeach
                </x-form.select>

                <div class="modal-action">
                    @if ($form->user?->trashed() && auth()->user()->can('restore', \BDS\Models\User::class))
                        <button type="button" wire:click='restore()' class="btn btn-info gap-2">
                            <i class="fa-solid fa-lock-open"></i> Restaurer
                        </button>
                    @else
                        <button type="submit" class="btn btn-success gap-2">
                            {!! $isCreating ? '<i class="fa-solid fa-plus"></i> Créer' : '<i class="fa-solid fa-pen-to-square"></i> Editer' !!}
                        </button>
                    @endif

                    <label for="editModal" class="btn btn-neutral">Fermer</label>
                </div>
            </label>
        </label>
    </form>

</div>

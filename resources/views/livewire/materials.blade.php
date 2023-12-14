<div>
    <div class="flex flex-col lg:flex-row gap-4 justify-between">
        <div>
            @canany(['export', 'delete'], \BDS\Models\Material::class)
                <div class="dropdown">
                    <label tabindex="0" class="btn btn-neutral m-1">
                        Actions
                        <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-caret-down-fill align-bottom" viewBox="0 0 16 16">
                            <path d="M7.247 11.14 2.451 5.658C1.885 5.013 2.345 4 3.204 4h9.592a1 1 0 0 1 .753 1.659l-4.796 5.48a1 1 0 0 1-1.506 0z"/>
                        </svg>
                    </label>
                    <ul tabindex="0" class="dropdown-content menu p-2 shadow bg-base-100 rounded-box w-52 z-[1]">
                        @can('export', \BDS\Models\Material::class)
                            <li>
                                <button type="button" class="text-blue-500" wire:click="exportSelected()">
                                    <x-icon name="fas-download" class="h-5 w-5"></x-icon>
                                    Exporter
                                </button>
                            </li>
                        @endcan
                        @can('delete', \BDS\Models\Material::class)
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
            @can('create', \BDS\Models\Material::class)
                <x-button type="button" class="btn btn-success gap-2" wire:click="create" spinner>
                    <x-icon name="fas-plus" class="h-5 w-5"></x-icon>
                    Nouveau Matériel
                </x-button>
            @endcan
        </div>
    </div>

    <x-table.table class="mb-6">
        <x-slot name="head">
            @canany(['export', 'delete'], \BDS\Models\Material::class)
                <x-table.heading>
                    <label>
                        <input type="checkbox" class="checkbox" wire:model.live="selectPage" />
                    </label>
                </x-table.heading>
            @endcanany

            @if (
                Gate::any(['update', 'generateQrCode'], \BDS\Models\Material::class) ||
                Gate::any(['create'], \BDS\Models\Incident::class) ||
                Gate::any(['create'], \BDS\Models\Maintenance::class))
                <x-table.heading>Actions</x-table.heading>
            @endif

            <x-table.heading sortable wire:click="sortBy('id')" :direction="$sortField === 'id' ? $sortDirection : null">#Id</x-table.heading>
            <x-table.heading sortable wire:click="sortBy('name')" :direction="$sortField === 'name' ? $sortDirection : null">Nom</x-table.heading>
            <x-table.heading sortable wire:click="sortBy('zone_id')" :direction="$sortField === 'zone_id' ? $sortDirection : null">Zone</x-table.heading>
            <x-table.heading sortable wire:click="sortBy('user_id')" :direction="$sortField === 'user_id' ? $sortDirection : null">Créateur</x-table.heading>
            <x-table.heading sortable wire:click="sortBy('description')" :direction="$sortField === 'description' ? $sortDirection : null">Description</x-table.heading>
            <x-table.heading sortable wire:click="sortBy('incident_count')" :direction="$sortField === 'incident_count' ? $sortDirection : null">Nombre <br>d'incidents</x-table.heading>
            <x-table.heading sortable wire:click="sortBy('part_count')" :direction="$sortField === 'part_count' ? $sortDirection : null">Nombre de <br>pièces détachées</x-table.heading>
            <x-table.heading sortable wire:click="sortBy('maintenance_count')" :direction="$sortField === 'maintenance_count' ? $sortDirection : null">Nombre de <br>maintenances</x-table.heading>
            <x-table.heading sortable wire:click="sortBy('cleaning_count')" :direction="$sortField === 'cleaning_count' ? $sortDirection : null">Nombre de <br>nettoyages</x-table.heading>
            <x-table.heading sortable wire:click="sortBy('cleaning_alert')" :direction="$sortField === 'cleaning_alert' ? $sortDirection : null">Alerte de <br>Nettoyage</x-table.heading>
            <x-table.heading sortable wire:click="sortBy('created_at')" :direction="$sortField === 'created_at' ? $sortDirection : null">Créé le</x-table.heading>
        </x-slot>

        <x-slot name="body">
            @can('search', \BDS\Models\Material::class)
                <x-table.row>
                    @canany(['export', 'delete'], \BDS\Models\Material::class)
                        <x-table.cell></x-table.cell>
                    @endcanany
                    @if (
                        Gate::any(['update', 'generateQrCode'], \BDS\Models\Material::class) ||
                        Gate::any(['create'], \BDS\Models\Incident::class) ||
                        Gate::any(['create'], \BDS\Models\Maintenance::class))
                        <x-table.cell></x-table.cell>
                    @endif
                    <x-table.cell>
                        <x-input wire:model.live.debounce.400ms="filters.id" name="filters.id" type="number" min="1" step="1"  />
                    </x-table.cell>
                    <x-table.cell>
                        <x-input wire:model.live.debounce.400ms="filters.name" name="filters.name" type="text" />
                    </x-table.cell>
                    <x-table.cell>
                        <x-input wire:model.live.debounce.400ms="filters.zone" name="filters.zone" type="text" />
                    </x-table.cell>
                    <x-table.cell>
                        <x-input wire:model.live.debounce.400ms="filters.creator" name="filters.creator" type="text" />
                    </x-table.cell>
                    <x-table.cell>
                        <x-input wire:model.live.debounce.400ms="filters.description" name="filters.description" type="text" />
                    </x-table.cell>
                    <x-table.cell></x-table.cell>
                    <x-table.cell></x-table.cell>
                    <x-table.cell></x-table.cell>
                    <x-table.cell></x-table.cell>
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
                            wire:model.live="filters.cleaning_alert"
                            name="filters.cleaning_alert"
                        />
                    </x-table.cell>
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
                                <span>Vous avez sélectionné <strong>{{ $materials->count() }}</strong> matériel(s), voulez-vous tous les sélectionner <strong>{{ $materials->total() }}</strong>?</span>
                                <button type="button" wire:click="selectAll" class="btn btn-neutral btn-sm gap-2 ml-1">
                                    <x-icon name="fas-check" class="inline h-4 w-4"></x-icon>
                                    Tout sélectionner
                                </button>
                            </div>
                        @else
                            <span>Vous sélectionnez actuellement <strong>{{ $materials->total() }}</strong> matériel(s).</span>
                        @endif
                    </x-table.cell>
                </x-table.row>
            @endif

            @forelse($materials as $material)
                <x-table.row wire:loading.class.delay="opacity-50" wire:key="row-{{ $material->getKey() }}">
                    @canany(['export', 'delete'], \BDS\Models\Material::class)
                        <x-table.cell>
                            <label>
                                <input type="checkbox" class="checkbox" wire:model.live="selected" value="{{ $material->getKey() }}" />
                            </label>
                        </x-table.cell>
                    @endcanany

                    @if (
                        Gate::any(['update', 'generateQrCode'], $material) ||
                        Gate::any(['create'], \BDS\Models\Incident::class) ||
                        Gate::any(['create'], \BDS\Models\Maintenance::class) ||
                        Gate::any(['create'], \BDS\Models\Cleaning::class))
                        <x-table.cell>
                            <x-dropdown top hover class="w-60">
                                <x-slot:trigger>
                                    <x-icon name="fas-ellipsis" class="h-5 w-5 cursor-pointer"></x-icon>
                                </x-slot:trigger>

                                @can('update', $material)
                                    <x-menu-item
                                        title="Modifier ce matériel"
                                        icon="fas-pen-to-square"
                                        tooltip
                                        tooltip-content="Modifier ce matériel"
                                        wire:click.prevent="edit({{ $material->getKey() }})" class="text-blue-500 text-left" />
                                @endcan
                                @can('generateQrCode', $material)
                                    <x-menu-item
                                        title="Générer un QR Code"
                                        icon="fas-qrcode"
                                        tooltip
                                        tooltip-content="Générer un QR Code pour ce matériel"
                                        wire:click.prevent="showQrCode({{ $material->getKey() }})"
                                        class="text-purple-500" />
                                @endcan
                                @can('create', \BDS\Models\Incident::class)
                                    <x-menu-item
                                        wire:navigate
                                        title="Créer un Incident"
                                        icon="fas-triangle-exclamation"
                                        tooltip
                                        tooltip-content="Créer un incident pour ce matériel"
                                        link="{{ route('incidents.index', ['materialId' => $material->getKey(), 'creating' => 'true']) }}"
                                        class="text-red-500" />
                                @endcan
                                @can('create', \BDS\Models\Maintenance::class)
                                    <x-menu-item
                                        wire:navigate
                                        title="Créer une Maintenance"
                                        icon="fas-screwdriver-wrench"
                                        tooltip
                                        tooltip-content="Créer une maintenance pour ce matériel"
                                        link="{{ route('maintenances.index', ['materialId' => $material->getKey(), 'creating' => 'true']) }}"
                                        class="text-yellow-500" />
                                @endcan
                                @can('create', \BDS\Models\Cleaning::class)
                                    <x-menu-item
                                        wire:navigate title="Créer un Nettoyage"
                                        icon="fas-broom"
                                        tooltip
                                        tooltip-content="Créer un nettoyage pour ce matériel"
                                        link="{{ route('cleanings.index', ['materialId' => $material->getKey(), 'qrcode' => 'true']) }}"
                                        class="text-green-500" />
                                @endcan
                            </x-dropdown>
                        </x-table.cell>
                    @endif
                    <x-table.cell>{{ $material->getKey() }}</x-table.cell>
                    <x-table.cell>
                        <a class="link link-hover link-primary font-bold" href="{{ $material->show_url }}">
                            {{ $material->name }}
                        </a>
                    </x-table.cell>
                    <x-table.cell>
                        {{ $material->zone->name }}
                    </x-table.cell>
                    <x-table.cell>
                        <a class="link link-hover text-primary font-bold" href="{{ route('users.show', $material->user) }}">
                            {{ $material->user->full_name }}
                        </a>
                    </x-table.cell>
                    <x-table.cell>
                        <span class="tooltip tooltip-top text-left" data-tip="{{ $material->description }}">
                            {{ Str::limit($material->description, 50) }}
                        </span>
                    </x-table.cell>
                    <x-table.cell>
                        <code class="code rounded-sm">
                            {{ $material->incident_count }}
                        </code>
                    </x-table.cell>
                    <x-table.cell>
                        <code class="code rounded-sm">
                            {{ $material->part_count }}
                        </code>
                    </x-table.cell>
                    <x-table.cell>
                        <code class="code rounded-sm">
                            {{ $material->maintenance_count }}
                        </code>
                    </x-table.cell>
                    <x-table.cell>
                        <code class="code rounded-sm">
                            {{ $material->cleaning_count }}
                        </code>
                    </x-table.cell>
                    <x-table.cell>
                        @if ($material->cleaning_alert)
                            <span class="font-bold text-red-500">Activée</span>
                        @else
                            <span class="font-bold text-green-500">Désactivée</span>
                        @endif
                    </x-table.cell>
                    <x-table.cell class="capitalize">
                        {{ $material->created_at->translatedFormat( 'D j M Y H:i') }}
                    </x-table.cell>
                </x-table.row>
            @empty
                <x-table.row>
                    <x-table.cell colspan="13">
                        <div class="text-center p-2">
                            <span class="text-muted">Aucun matériel trouvé...</span>
                        </div>
                    </x-table.cell>
                </x-table.row>
            @endforelse
        </x-slot>
    </x-table.table>

    <div class="grid grid-cols-1">
        {{ $materials->links() }}
    </div>

    <!-- Delete Materials Modal -->
    <x-modal wire:model="showDeleteModal" title="Supprimer les Matériels">
        @if (empty($selected))
            <p class="my-7">
                Vous n'avez sélectionné aucun matériel à supprimer.
            </p>
        @else
            <p class="my-7">
                Voulez-vous vraiment supprimer ces matériels ? <span class="font-bold text-red-500">Cette opération n'est pas réversible.</span>
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

    <!-- Create/Edit Material Modal -->
    <x-modal wire:model="showModal" title="{{ $isCreating ? 'Créer un Matériel' : 'Editer le Matériel' }}">
        <div class="divider text-base-content text-opacity-70 uppercase">Général</div>

        <x-input wire:model="form.name" name="form.name" label="Nom" placeholder="Nom..." type="text" />

        @php $message = "Sélectionnez la zone dans laquelle le matériel appartient.";@endphp
        <x-select
            :options="$zones"
            class="select-primary"
            wire:model="form.zone_id"
            name="form.zone_id"
            label="Zone"
            :label-info="$message"
            placeholder="Sélectionnez la Zone"
        />

        @php $message = "Veuillez décrire au mieux le matériel.";@endphp
        <x-textarea wire:model="form.description" name="form.description" label="Description du matériel" placeholder="Description du matériel..." rows="3" :label-info="$message" />

        <div class="divider text-base-content text-opacity-70 uppercase">Nettoyage</div>

        {{-- SELVAH ONLY --}}
        @if(getPermissionsTeamId() === settings('site_id_selvah'))
            <x-checkbox wire:model="form.selvah_cleaning_test_ph_enabled" name="form.selvah_cleaning_test_ph_enabled" label="Activer le test de PH" text="Cochez pour activer le test de PH obligatoire pour ce matériel" />
        @endif

        <x-checkbox wire:model.live="form.cleaning_alert" name="form.cleaning_alert" label="Activer l'alerte de nettoyage" text="Cochez pour activer l'alerte de nettoyage" />

        @if ($form->cleaning_alert)
            @php $message = "Cocher pour avoir l'alerte de nettoyage par Email ou laisser décocher pour avoir uniquement une notification.";@endphp
            <x-checkbox wire:model="form.cleaning_alert_email" name="form.cleaning_alert_email" label="Activer l'alerte par Email" text="Cochez pour activer l'alerte de nettoyage par E-mail" />

            @php $message = "Veuillez renseigner la fréquence de nettoyage. <br>Exemple: tout les <b>2</b> jours";@endphp
            <x-input wire:model.live="form.cleaning_alert_frequency_repeatedly" name="form.cleaning_alert_frequency_repeatedly" label="Fréquence de nettoyage" type="number" min="0" max="365" step="1" :label-info="$message" />

            @php $message = "Veuillez renseigner la fréquence de répétition de nettoyage. <br>Exemple: tout les 2 <b>jours</b>";@endphp
            <x-select
                :options="\BDS\Models\Material::CLEANING_TYPES"
                class="select-primary"
                wire:model.live="form.cleaning_alert_frequency_type"
                name="form.cleaning_alert_frequency_type"
                label="Type de fréquence de nettoyage"
                :label-info="$message"
                placeholder="Sélectionnez la Fréquence"
            />

            @if($form->cleaning_alert_frequency_repeatedly && $form->cleaning_alert_frequency_type)
                <p class="my-3">
                    La fréquence de nettoyage sera : <span class="font-bold lowercase">Tout les {{ $form->cleaning_alert_frequency_repeatedly }} {{ collect(\BDS\Models\Material::CLEANING_TYPES)->sole('id', $form->cleaning_alert_frequency_type)['name'] }}</span>
                </p>
            @endif
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

    <!-- QrCode Matériels Modal -->
    <x-modal wire:model="showQrCodeModal" title="Générer un QR Code">

        <span class="text-sm mb-3">
            Le QR Code sera généré pour le matériel <span class="font-bold">{{ $modelQrCode?->name }}</span>
        </span>

        <div class="form-control">
            <label class="label" for="size">
                <span class="label-text">Taille</span>
                <span class="label-text-alt">
                    <div class="dropdown dropdown-hover dropdown-bottom dropdown-end">
                        <label tabindex="0" class="hover:cursor-pointer text-info">
                            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" class="w-4 h-4 stroke-current"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                        </label>
                        <div tabindex="0" class="card compact dropdown-content z-[1] shadow bg-base-100 dark:bg-base-200 rounded-box w-64">
                            <div class="card-body">
                                <p>
                                    Sélectionnez la taille du QR Code généré : <br/>
                                        <b>Très Petit</b> (100 pixels)<br/>
                                        <b>Petit</b> (150 pixels)<br/>
                                        <b>Normal</b> (200 pixels)<br/>
                                        <b>Moyen</b> (300 pixels)<br/>
                                        <b>Grand</b> (400 pixels)<br/>
                                        <b>Très Grand</b> (500 pixels)<br/>
                                </p>
                            </div>
                        </div>
                    </div>
                </span>
            </label>
        </div>
        @foreach ($allowedQrCodeSize as $key => $value)
            <x-form.radio wire:model.live="qrCodeSize" value="{{ $key }}" name="size">
                {{ $value['text'] }}
            </x-form.radio>
        @endforeach

        <x-input wire:model.live="qrCodeLabel" name="qrCodeLabel" label="Label du QR Code" placeholder="Texte du label..." type="text" />

        <div>
            <div class="flex justify-center my-3">
                <img id="qrCodeImg" src="{{ $qrCodeImg }}" alt="QR Code image" />
            </div>
        </div>

        <x-slot:actions>
            <a href="#" class="btn btn-info gap-2" onclick="printJS(document.getElementById('qrCodeImg').src, 'image');return false;">
                <x-icon name="fas-print" class="h-5 w-5"></x-icon> Imprimer
            </a>
            <a href="{{ $qrCodeImg }}" download="qrcode_{{ \Illuminate\Support\Str::slug($modelQrCode?->name) }}.png" class="btn btn-success gap-2">
                <x-icon name="fas-download" class="h-5 w-5"></x-icon> Télécharger
            </a>
            <x-button @click="$wire.showQrCodeModal = false" class="btn btn-neutral">
                Fermer
            </x-button>
        </x-slot:actions>
    </x-modal>

</div>

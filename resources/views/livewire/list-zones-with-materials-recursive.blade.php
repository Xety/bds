@foreach($zones as $zone)
    <li>
        <details>
            <summary>
                <div class="flex gap-2">
                    <x-icon name="fas-map-signs" class="h-4 w-4"></x-icon>
                    {{ $zone->name }}

                    @canany(['update', 'create'], $zone)
                        <div class="dropdown dropdown-top">
                            <label tabindex="0" class="cursor-pointer">
                                <x-icon name="iconsax-bul-menu" class="h-5 w-5 text-primary" />
                            </label>
                            <ul tabindex="0" class="dropdown-content z-[1] menu items-start p-2 shadow bg-base-100 rounded-box w-56">
                                <li class="w-full">
                                    <a href="{{ route('zones.index', ['zoneId' => $zone->getKey(), 'editing' => 'true']) }}" class="text-blue-500">
                                        <x-icon name="fas-pen-to-square" class="h-4 w-4"></x-icon>
                                        Modifier cette zone
                                    </a>
                                </li>
                                <li class="w-full">
                                    <a href="{{ route('zones.index', ['zoneSubId' => $zone->getKey(), 'creating' => 'true']) }}" class="text-green-500">
                                        <x-icon name="fas-plus" class="h-4 w-4"></x-icon>
                                        Créer une sous-zone
                                    </a>
                                </li>
                            </ul>
                        </div>
                    @endcanany
                </div>

            </summary>
            <ul>
                @if(!empty($zone->children))
                    @include('livewire.list-zones-with-materials-recursive',['zones' => $zone->children])
                @endif

                @foreach($zone->materials as $material)
                    <li>
                        <details>
                            <summary>
                                <div class="flex gap-2">
                                    <x-icon name="fas-microchip" class="h-4 w-4"></x-icon>
                                    {{ $material->name }}

                                    @if (
                                        Gate::any(['update', 'generateQrCode'], $material) ||
                                        Gate::any(['create'], \BDS\Models\Incident::class) ||
                                        Gate::any(['create'], \BDS\Models\Maintenance::class) ||
                                        Gate::any(['create'], \BDS\Models\Cleaning::class))
                                        <x-dropdown class="w-60" bottom hover>
                                            <x-slot:trigger>
                                                <x-icon name="iconsax-bul-menu" class="h-5 w-5 text-primary"></x-icon>
                                            </x-slot:trigger>

                                            @can('update', $material)
                                                <x-menu-item
                                                    title="Modifier ce matériel"
                                                    icon="fas-pen-to-square"
                                                    tooltip
                                                    tooltip-content="Modifier ce matériel"
                                                    link="{{  route('materials.index', ['materialId' => $material->getKey(), 'editing' => 'true']) }}"
                                                    class="text-blue-500" />
                                            @endcan
                                            @can('generateQrCode', $material)
                                                <x-menu-item
                                                    title="Générer un QR Code"
                                                    icon="fas-qrcode"
                                                    tooltip
                                                    tooltip-content="Générer un QR Code pour ce matériel."
                                                    link="{{ route('materials.index', ['materialId' => $material->getKey(), 'qrcode' => 'true']) }}"
                                                    class="text-purple-500" />
                                            @endcan
                                            @can('create', \BDS\Models\Incident::class)
                                                <x-menu-item
                                                    title="Créer un Incident"
                                                    icon="fas-triangle-exclamation"
                                                    tooltip
                                                    tooltip-content="Créer un incident pour ce matériel."
                                                    link="{{ route('incidents.index', ['materialId' => $material->getKey(), 'creating' => 'true']) }}"
                                                    class="text-red-500" />
                                            @endcan
                                            @can('create', \BDS\Models\Maintenance::class)
                                                <x-menu-item
                                                    title="Créer une Maintenance"
                                                    icon="fas-screwdriver-wrench"
                                                    tooltip
                                                    tooltip-content="Créer une maintenance pour ce matériel."
                                                    link="{{ route('maintenances.index', ['materialId' => $material->getKey(), 'creating' => 'true']) }}"
                                                    class="text-yellow-500" />
                                            @endcan
                                            @can('create', \BDS\Models\Cleaning::class)
                                                <x-menu-item
                                                    title="Créer un Nettoyage"
                                                    icon="fas-broom"
                                                    tooltip
                                                    tooltip-content="Créer un nettoyage pour ce matériel."
                                                    link="{{ route('cleanings.index', ['materialId' => $material->getKey(), 'creating' => 'true']) }}"
                                                    class="text-green-500" />
                                            @endcan
                                        </x-dropdown>
                                    @endif
                                </div>
                            </summary>
                            <ul>
                                <li>
                                    <a>
                                        <x-icon name="fas-broom" class="h-4 w-4"></x-icon>
                                        Nettoyages Total : {{ $material->cleaning_count }}
                                    </a>
                                </li>
                                <li>
                                    <a>
                                        <x-icon name="fas-screwdriver-wrench" class="h-4 w-4"></x-icon>
                                        Maintenances Total : {{ $material->maintenance_count }}
                                    </a>
                                </li>
                                <li>
                                    <a>
                                        <x-icon name="fas-triangle-exclamation" class="h-4 w-4"></x-icon>
                                        Incidents Total : {{ $material->incident_count }}
                                    </a>
                                </li>
                                <li>
                                    <a>
                                        <x-icon name="fas-gear" class="h-4 w-4"></x-icon>
                                        Pièces Détachées Total : {{ $material->part_count }}
                                    </a>
                                </li>
                            </ul>
                        </details>
                    </li>
                @endforeach
            </ul>
        </details>
    </li>
@endforeach

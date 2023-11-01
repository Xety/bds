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
                                    <a href="{{ route('zones.index', ['editid' => $zone->getKey(), 'edit' => 'true']) }}" class="text-blue-500">
                                        <x-icon name="fas-pen-to-square" class="h-4 w-4"></x-icon>
                                        Modifier cette zone
                                    </a>
                                </li>
                                <li class="w-full">
                                    <a href="{{ route('zones.index', ['createsubid' => $zone->getKey(), 'create' => 'true']) }}" class="text-green-500">
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

                                    <div class="dropdown dropdown-top">
                                        <label tabindex="0" class="cursor-pointer">
                                            <x-icon name="iconsax-bul-menu" class="h-5 w-5 text-primary" />
                                        </label>
                                        <ul tabindex="0" class="dropdown-content z-[1] menu items-start p-2 shadow bg-base-100 rounded-box w-56">
                                            @can('update', $material)
                                                <li class="w-full">
                                                    <a href="{{ route('materials.index', ['editid' => $material->getKey(), 'edit' => 'true']) }}" class="text-blue-500">
                                                        <x-icon name="fas-pen-to-square" class="h-4 w-4"></x-icon>
                                                        Modifier ce matériel
                                                    </a>
                                                </li>
                                            @endcan
                                            @can('generateQrCode', $material)
                                                <li class="w-full">
                                                    <a href="{{ route('materials.index', ['qrcodeid' => $material->getKey(), 'qrcode' => 'true']) }}"
                                                       class="text-purple-500">
                                                        <x-icon name="fas-qrcode" class="h-4 w-4" /> Générer un QR Code
                                                    </a>
                                                </li>
                                            @endcan
                                        </ul>
                                    </div>
                                </div>
                            </summary>
                            <ul>
                                <li>
                                    <a>
                                        <x-icon name="fas-broom" class="h-4 w-4"></x-icon>
                                        Nettoyages Total : {{ $material->cleaning_count }}
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

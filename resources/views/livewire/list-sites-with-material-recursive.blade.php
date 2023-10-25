@foreach($zones as $zone)
    <li>
        <details>
            <summary>
                <x-icon name="fas-map-signs" class="h-4 w-4"></x-icon>
                {{ $zone->name }}
            </summary>
            <ul>
                @if(!empty($zone->children) && $zone->children->count())
                    @include('livewire.list-sites-with-material-recursive',['zones' => $zone->children])
                @endif

                @foreach($zone->materials as $material)
                    <li>
                        <details>
                            <summary>
                                <x-icon name="fas-microchip" class="h-4 w-4"></x-icon>
                                {{ $material->name }}
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

<div>
    <ul class="menu menu-xs bg-base-200 rounded-lg w-full">
        @foreach($sites as $site)
            <li>
                <details>
                    <summary>
                        <i class="fa-solid fa-map-location-dot"></i>
                        {{ $site->name }}
                    </summary>

                    <ul>
                        @foreach($site->zones as $zone)
                            <li>
                                <details>
                                    <summary>
                                        <i class="fa-solid fa-coins"></i>
                                        {{ $zone->name }}
                                    </summary>
                                    <ul>
                                        @foreach($zone->materials as $material)
                                            <li>
                                                <details>
                                                    <summary>
                                                        <i class="fa-solid fa-microchip"></i>
                                                        {{ $material->name }}
                                                    </summary>
                                                    <ul>
                                                        <li>
                                                            <a>
                                                                <i class="fa-solid fa-broom"></i>
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
                    </ul>

                </details>
            </li>
        @endforeach
    </ul>
</div>

<div>
    <ul class="menu menu-xs bg-base-200 rounded-lg w-full">
        @foreach($sites as $site)
            <li>
                <details>
                    <summary>
                        <x-icon name="fas-map-marker-alt" class="h-4 w-4"></x-icon>
                        {{ $site->name }}
                    </summary>

                    <ul>
                        @include('livewire.list-sites-with-material-recursive', ['zones' => $site->zones])
                    </ul>
                </details>
            </li>
        @endforeach
    </ul>
</div>

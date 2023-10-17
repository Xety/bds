<div>
    <ul class="menu menu-xs bg-base-200 rounded-lg w-full">
        @foreach($sites as $site)
            <li>
                <details>
                    <summary>
                        <x-icon name="fas-map-marker-alt" class="h-4 w-4"></x-icon>
                        {{ $site['name'] }}
                    </summary>

                    <ul>
                        @foreach($site['users'] as $user)
                            <li>
                                <details>
                                    <summary>
                                        <x-icon name="fas-user" class="h-4 w-4"></x-icon>
                                        {{ $user['full_name'] }}
                                    </summary>
                                    <ul>
                                        <li>
                                            <details>
                                                <summary>
                                                    <x-icon name="fas-user-shield" class="h-4 w-4"></x-icon>
                                                    Permissions Directs
                                                </summary>
                                                <ul>
                                                    @foreach($user['permissions_without_site'] as $permission)
                                                        <li>
                                                            <a>
                                                                <x-icon name="fas-user-shield" class="h-4 w-4"></x-icon>
                                                                {{ $permission['name'] }}
                                                            </a>
                                                        </li>
                                                    @endforeach
                                                </ul>
                                            </details>
                                        </li>
                                        @foreach($user['roles'] as $role)
                                            <li>
                                                <details>
                                                    <summary>
                                                        <x-icon name="fas-user-tie" class="h-4 w-4"></x-icon>
                                                        {{ $role['name'] }}
                                                    </summary>
                                                    <ul>
                                                        @foreach($role['permissions'] as $permission)
                                                            <li>
                                                                <a>
                                                                    <x-icon name="fas-user-shield" class="h-4 w-4"></x-icon>
                                                                    {{ $permission['name'] }}
                                                                </a>
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

                </details>
            </li>
        @endforeach
    </ul>
</div>

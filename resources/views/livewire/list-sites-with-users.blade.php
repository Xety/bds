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
                        @foreach($site->users as $user)
                            <li>
                                <details>
                                    <summary>
                                        <i class="fa-solid fa-user"></i>
                                        {{ $user->full_name }}
                                    </summary>
                                    <ul>
                                        @foreach($user->roles as $role)
                                            <li>
                                                <details>
                                                    <summary>
                                                        <i class="fa-solid fa-user-tie"></i>
                                                        {{ $role->name }}
                                                    </summary>
                                                    <ul>
                                                        @foreach($role->permissions as $permission)
                                                            <li>
                                                                <a>
                                                                    <i class="fa-solid fa-user-shield"></i>
                                                                    {{ $permission->name }}
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

@extends('layouts.app')
{!! config(['app.title' => 'Documentation']) !!}

@push('meta')
    <x-meta title="Documentation"/>
@endpush

@section('content')
    <x-breadcrumbs :breadcrumbs="$breadcrumbs"/>

    <section class="m-3 lg:m-10">
        <hgroup class="text-center px-5 pb-5">
            <h1 class="text-4xl">
                <x-icon name="fas-file-lines" class="h-10 w-10 inline"></x-icon>  Documentation
            </h1>
            <p class="text-gray-400 ">
                Trouvez la réponse à vos questions ici !
            </p>
        </hgroup>

        <div class="grid grid-cols-12 gap-6 mb-7">
            <div class="col-span-12 shadow-md border rounded-lg p-3 border-gray-200 dark:border-gray-700 bg-base-100 dark:bg-base-300">
                <ul class="list-disc ps-10">
                    <li>
                        <a class="link link-primary text-3xl" href="#permission_roles">
                            <x-icon name="fas-shield-alt" class="h-6 w-6 inline"></x-icon> Permissions & Rôles
                        </a>
                        <ol class="list-decimal ps-10">
                            <li>
                                <a class="link link-primary" href="#assign_permissions_to_role">Assigner une Permission à un Rôle</a>
                            </li>
                            <li>
                                <a class="link link-primary" href="#assign_direct_permission">Assigner une permission directe</a>
                            </li>
                            <li>
                                <a class="link link-primary" href="#les_niveaux">Les niveaux</a>
                            </li>
                        </ol>
                    </li>
                    <li>
                        <a class="link link-primary text-3xl" href="#">
                            <x-icon name="fas-map-marker-alt" class="h-6 w-6 inline"></x-icon> Sites
                        </a>
                        <ol class="list-decimal ps-10">
                            <li>
                                <a class="link link-primary" href="#">Assigner des managers à un Site</a>
                            </li>
                        </ol>
                    </li>

                </ul>

                <ul class="ps-10">
                    <li>
                        <h2 class="mt-10 text-primary text-3xl" id="permission_roles">
                            <x-icon name="fas-shield-alt" class="h-6 w-6 inline"></x-icon> Permissions & Rôles
                        </h2>
                        <p>
                            La gestion des rôles et permissions sont, comme l'intégralité des fonctionnalités du site, soumis à authorisations. Les permissions sont multi-sites, cela veut dire que lorsqu'une permission est créée,
                            elle peut être assignée sur l'ensemble des sites. Un Rôle peut lui, être assigné à un site, et donc être assigné à un utilisateur uniquement sur le site en question.
                        </p>
                        <p>
                            Voici un diagramme explicatif des rôles et permissions :
                            <img src="{{ asset('images/documentation/permissions_roles.png') }}" alt="Diagramme des rôles et permissions" class="block mb-5">
                        </p>

                        <ul class="ps-10">
                            <li>
                                <h3 class="mr-5 text-primary text-2xl" id="assign_permissions_to_role">
                                    Assigner une Permission à un Rôle
                                </h3>
                                <p>
                                    Pour assigner des permissions à un rôle, vous devez sélectionner la/les permission(s) voulues dans la liste des permissions disponibles. Une description de la permission est visible lorsque
                                    vous passez votre souris sur la permission.
                                    <img src="{{ asset('images/documentation/assigner_permissions_a_role.png') }}" alt="Assignation des permissions à un rôle" class="block mb-5">
                                </p>
                            </li>
                            <li>
                                <h3 class="mr-5 text-primary text-2xl" id="assign_direct_permission">
                                    Assigner une permission directe
                                </h3>
                                <p>
                                    Une permission directe est une permission qui est directement assignée à un utilisateur sans passer par un rôle et sur un site spécifique. Cela permet de faire des "exceptions"
                                    en donnant une permission supplémentaire à un utilisateur par rapport à un autre ayant le même rôle. Cette fonctionnalité, bien que très utile, est à éviter dans la mesure du
                                    possible en privilégiant les rôles, car elle a tendance à créer un désordre dans la gestion des permissions à long terme. Pour assigner une permission directe à un utilisateur,
                                    vous devez sélectionner la ou les permissions dans la liste des permissions en créant ou en éditant un utilisateur, <b>et en étant sur le site sur lequel vous souhaitez lui donner la permission.</b>
                                    <img src="{{ asset('images/documentation/assigner_direct_permission.png') }}" alt="Assignation des permissions à un rôle" class="block mb-5">
                                </p>
                            </li>
                            <li>
                                <h3 class="mr-5 text-primary text-2xl" id="les_niveaux">
                                    Les niveaux
                                </h3>
                                <p>
                                    Chaque rôle à un niveau qui lui est défini. Ce niveau, représenté par un chiffre allant de 0 à 100, permet de définir si le rôle de l'utilisateur est supérieur ou inférieur au rôle qu'on
                                    souhaite le comparer. Ceci permet d'éviter qu'un utilisateur qui a un niveau de 50, puisse editer, modifier, supprimer un rôle/utilisateur qui à un niveau supérieur. C'est donc une
                                    notion très importante dans la gestion des permissions.
                                </p>
                            </li>
                        </ul>
                    </li>

                </ul>

            </div>
        </div>
    </section>
@endsection

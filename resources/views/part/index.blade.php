@extends('layouts.app')
{!! config(['app.title' => 'Gérer les Pièces Détachées']) !!}

@push('meta')
    <x-meta title="Gérer les Pièces Détachées" />
@endpush

@section('content')
    <x-breadcrumbs :breadcrumbs="$breadcrumbs" />

    <section class="m-3 lg:m-10">
        <div class="mb-12">
            <div class="grid grid-cols-12 gap-4 text-center h-full">
                <div class="col-span-12 xl:col-span-2 h-full">
                    <div class="flex flex-col justify-between shadow-md border rounded-lg p-6 h-full border-gray-200 dark:border-gray-700 bg-base-100 dark:bg-base-300">
                        <i class="fa-solid fa-cubes-stacked text-green-500 text-8xl"></i>
                        <div>
                            <div class="font-bold text-2xl">
                                {{ $priceTotalAllPartInStock }} €
                            </div>
                            <p class="text-muted font-selvah uppercase">
                                Prix total des pièces détachées en stock
                            </p>
                        </div>
                    </div>
                </div>

                <div class="col-span-12 xl:col-span-2 h-full">
                    <div class="flex flex-col justify-between shadow-md border rounded-lg p-6 h-full border-gray-200 dark:border-gray-700 bg-base-100 dark:bg-base-300">
                        <i class="fa-solid fa-arrow-right-to-bracket text-yellow-500 text-8xl"></i>
                        <div>
                            <div class="font-bold text-2xl">
                                {{ $priceTotalAllPartEntries }} €
                            </div>
                            <p class="text-muted font-selvah uppercase">
                                Prix total des pièces détachées entrées en stock
                            </p>
                        </div>
                    </div>
                </div>

                <div class="col-span-12 xl:col-span-2 h-full">
                    <div class="flex flex-col justify-between shadow-md border rounded-lg p-6 h-full border-gray-200 dark:border-gray-700 bg-base-100 dark:bg-base-300">
                        <i class="fa-solid fa-right-from-bracket text-red-500 text-8xl"></i>
                        <div>
                            <div class="font-bold text-2xl">
                                {{ $priceTotalAllPartExits }} €
                            </div>
                            <p class="text-muted font-selvah uppercase">
                                Prix total des pièces détachées sorties du stock
                            </p>
                        </div>
                    </div>
                </div>

                <div class="col-span-12 xl:col-span-2 h-full">
                    <div class="flex flex-col justify-between shadow-md border rounded-lg p-6 h-full border-gray-200 dark:border-gray-700 bg-base-100 dark:bg-base-300">
                        <i class="fa-solid fa-cubes-stacked text-blue-500 text-8xl"></i>
                        <div>
                            <div class="font-bold text-2xl">
                                {{ $totalPartInStock }}
                            </div>
                            <p class="text-muted font-selvah uppercase">
                                Nombre de pièces détachées en stock actuellement
                            </p>
                        </div>
                    </div>
                </div>

                <div class="col-span-12 xl:col-span-2 h-full">
                    <div class="flex flex-col justify-between shadow-md border rounded-lg p-6 h-full border-gray-200 dark:border-gray-700 bg-base-100 dark:bg-base-300">
                        <i class="fa-solid fa-arrow-right-to-bracket text-pink-600 text-8xl"></i>
                        <div>
                            <div class="font-bold text-2xl">
                                {{ $totalPartGetInStock }}
                            </div>
                            <p class="text-muted font-selvah uppercase">
                                Nombre de pièces détachées entrées en stock
                            </p>
                        </div>
                    </div>
                </div>

                <div class="col-span-12 xl:col-span-2 h-full">
                    <div class="flex flex-col justify-between shadow-md border rounded-lg p-6 h-full border-gray-200 dark:border-gray-700 bg-base-100 dark:bg-base-300">
                        <i class="fa-solid fa-right-from-bracket text-cyan-600 text-8xl"></i>
                        <div>
                            <div class="font-bold text-2xl">
                                {{ $totalPartOutOfStock }}
                            </div>
                            <p class="text-muted font-selvah uppercase">
                                Nombre de pièces détachées sorties du stock
                            </p>
                        </div>
                    </div>
                </div>

            </div>
        </div>

        <hgroup class="text-center px-5 pb-5">
            <h1 class="text-4xl font-selvah">
                <i class="fa-solid fa-gear"></i> Gestion des Pièces Détachées
            </h1>
            <p class="text-gray-400 ">
                Gérer les pièces détachées de l'usine.
            </p>
        </hgroup>

        <div class="grid grid-cols-12 gap-6 mb-7">
            <div class="col-span-12 shadow-md border rounded-lg p-3 border-gray-200 dark:border-gray-700 bg-base-100 dark:bg-base-300">
                <livewire:parts />
            </div>
        </div>
    </section>
@endsection

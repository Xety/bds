@extends('layouts.guest')
{!! config(['app.title' => 'Créez votre nouveau mot de passe']) !!}

@push('meta')
    <x-meta title="Créez votre nouveau mot de passe" />
@endpush

@section('content')
<section class="relative flex items-center min-h-screen p-0 overflow-hidden">
    <div class="container">
        <div class="flex flex-wrap">
            <div class="flex flex-col w-full max-w-full px-3 mx-auto lg:mx-0 shrink-0 md:flex-0 md:w-7/12 lg:w-5/12 xl:w-4/12">
                <div class="flex flex-col items-center">
                    <img src="{{ asset('images/logos/cbds_32x383.png') }}" alt="{{ config('bds.info.full_name') }} Logo" class="inline-block mb-5" width="200px">
                    <h1 class="text-xl">
                        Créer le mot de passe
                    </h1>
                    <p class="text-gray-500">
                        Votre compte vient d'être créé, vous devez créer un mot de passe avant de pouvoir vous connecter avec votre compte.
                    </p>

                    <x-form.form method="post" action="{{ route('auth.password.create', ['hash' => $hash, 'id' => $id]) }}" class="w-full">

                        <x-form.password name="password" label="Mot de Passe" placeholder="Mot de passe..." required autocomplete="new-password"/>

                        <x-form.password name="password_confirmation" label="Mot de Passe confirmation" placeholder="Mot de passe confirmation..." required  autocomplete="new-password"/>

                        <div class="text-center my-3">
                            <button type="submit" class="btn btn-primary gap-2">
                                <i class="fa-solid fa-right-to-bracket"></i>
                                Créer le mot de passe
                            </button>
                        </div>
                    </x-form.form>

                    <div class="text-center">
                        <a class="link link-hover link-primary mr-2" href="{{ route('auth.login') }}">
                            Connexion
                        </a>
                    </div>

                </div>
            </div>

            <x-auth.aside />
        </div>
    </div>
</section>

<footer class="footer footer-center text-base-content py-12">
    <div class="w-full">
        &copy; {{ date('Y', time()) }} {{ config('bds.info.full_name') }}. Tous droits réservés.
    </div>
</footer>
@endsection

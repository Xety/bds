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
                        Réinitialiser le mot de passe
                    </h1>

                    <x-form.form method="post" action="{{ route('auth.password.update') }}" class="w-full">
                        <input type="hidden" name="token" value="{{ $token }}">
                        <x-form.email name="email" label="Email" placeholder="Votre Email..." value="{{ old('email') }}" required />

                        <x-form.password name="password" label="Mot de Passe" placeholder="Mot de passe..." required autocomplete="new-password"/>

                        <x-form.password name="password_confirmation" label="Mot de Passe confirmation" placeholder="Mot de passe confirmation..." required  autocomplete="new-password"/>

                        <div class="text-center my-3">
                            <button type="submit" class="btn btn-primary gap-2">
                                <i class="fa-solid fa-right-to-bracket"></i>
                                Réinitialiser le mot de passe
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

            <div class="absolute top-0 right-0 flex-col justify-center hidden w-6/12 h-full max-w-full px-3 pr-0 my-auto text-center flex-0 lg:flex">
                <div class="relative flex flex-col justify-center h-full px-24 m-4 bg-cover bg-center rounded-xl bg-[url('/images/login/moissonneuse.jpg')]">
                    <span class="absolute top-0 left-0 w-full h-full bg-cover rounded-xl opacity-60 bg-gradient-to-tl from-blue-500 to-cyan-700"></span>
                    <div class="relative z-30">
                        <h2 class="text-4xl mt-12 font-bold text-white font-bds">"Société pour l’Extrusion de Légumineuses Valorisées en Alimentation Humaine"</h2>
                        <p class="text-xl text-white ">Acteur majeur dans le développement de protéines végétales.</p>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>

<footer class="footer footer-center text-base-content py-12">
    <div class="w-full">
        &copy; {{ date('Y', time()) }} {{ config('bds.info.full_name') }}. Tous droits réservés.
    </div>
</footer>
@endsection

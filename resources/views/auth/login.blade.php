@extends('layouts.guest')
{!! config(['app.title' => 'Connectez-vous à votre compte']) !!}

@push('meta')
    <x-meta title="Connectez-vous à votre compte" />
@endpush

@section('content')
<section class="relative flex items-center min-h-screen p-0 overflow-hidden">
    <div class="container">
        <div class="flex flex-wrap">
            <div class="flex flex-col w-full max-w-full px-3 mx-auto lg:mx-0 shrink-0 md:flex-0 md:w-7/12 lg:w-5/12 xl:w-4/12">
                <div class="flex flex-col items-center">
                    @if (config('settings.user.login.enabled'))
                        <img src="{{ asset('images/logos/cbds_32x383.png') }}" alt="{{ config('bds.info.full_name') }} Logo" class="inline-block mb-5" width="200px">
                        <h1 class="text-xl">
                            Connexion
                        </h1>

                        <x-form.form method="post" action="{{ route('auth.login') }}" class="w-full">
                            <x-form.email name="email" label="Email" placeholder="Votre Email..." value="{{ old('email') }}" required />

                            <x-form.password name="password" label="Mot de Passe" placeholder="Votre mot de passe..." required/>

                            <x-form.checkbox name="remember" label="{{ false }}" checked="{{ (bool)old('remember') }}">
                                Se souvenir de moi
                            </x-form.checkbox>

                            <div class="text-center mb-3">
                                <button type="submit" class="btn btn-primary gap-2">
                                    <i class="fa-solid fa-right-to-bracket"></i>
                                    Connexion
                                </button>
                            </div>
                        </x-form.form>

                        <div class="flex flex-col items-center">
                            <a class="link link-hover link-primary mr-2" href="{{ route('auth.password.request') }}">
                                Mot de passe oublié ?
                            </a>
                            <a class="link link-hover link-primary mr-2" href="{{ route('auth.password.resend.request') }}">
                                Mot de passe pas encore configurer ?
                            </a>
                        </div>
                    @else
                        <div>
                            <h1 class="text-3xl font-bds text-center mb-4">
                                Whoops
                            </h1>
                            <x-alert type="error" class="max-w-lg mb-4">
                                Le système de connexion est actuellement désactivé, veuillez réessayer plus tard.
                            </x-alert>
                        </div>
                    @endif
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

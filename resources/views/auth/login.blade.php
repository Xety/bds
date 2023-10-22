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
                    <img src="{{ asset('images/logos/cbds_32x383.png') }}" alt="{{ config('bds.info.full_name') }} Logo" class="inline-block mb-5" width="200px">
                    <h1 class="text-3xl font-bds">
                        Connexion
                    </h1>

                    @if(!settings('app_login_enabled'))
                        <div>
                            <x-alert type="error" title="Information" class="max-w-lg mb-4">
                                Le système de connexion est actuellement désactivé, si vous n'avez pas l'autorisation de vous connecter, veuillez ressayer plus tard.
                            </x-alert>
                        </div>
                    @endif

                    <x-form method="post" action="{{ route('auth.login') }}" class="w-full">
                        <x-input label="Email" name="email" placeholder="Votre Email..." type="email" value="{{ old('email') }}" required />
                        <x-input label="Mot de Passe" name="password" placeholder="Votre mot de passe..." type="password" required />

                        <x-checkbox text="Se souvenir de moi" name="remember" />

                        <div class="text-center mb-3">
                            <x-button label="Connexion" class="btn btn-primary gap-2" type="submit" icon="fas-right-to-bracket" />
                        </div>
                    </x-form>

                    <div class="flex flex-col items-center">
                        <a class="link link-hover link-primary mr-2" href="{{ route('auth.password.request') }}">
                            Mot de passe oublié ?
                        </a>
                        <a class="link link-hover link-primary mr-2" href="{{ route('auth.password.resend.request') }}">
                            Mot de passe pas encore configurer ?
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

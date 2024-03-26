@extends('layouts.guest')
{!! config(['app.title' => 'Réinitialisez votre mot de passe']) !!}

@push('meta')
    <x-meta title="Réinitialisez votre mot de passe" />
@endpush

@push('scriptsTop')
    {!! NoCaptcha::renderJs() !!}
@endpush

@section('content')
<section class="relative flex items-center min-h-screen p-0 overflow-hidden">
    <div class="container">
        <div class="flex flex-wrap">
            <div class="flex flex-col w-full max-w-full px-3 mx-auto lg:mx-0 shrink-0 md:flex-0 md:w-7/12 lg:w-5/12 xl:w-4/12">
                <div class="flex flex-col items-center">
                    <img src="{{ asset('images/logos/cbds_324x383.png') }}" alt="{{ config('bds.info.full_name') }} Logo" class="inline-block mb-5" width="200px">

                    <h1 class="text-xl">
                        Réinitialiser votre mot de passe
                    </h1>

                    <x-form method="post" action="{{ route('auth.password.email') }}" class="w-full">
                        <x-input label="Email" name="email" placeholder="Votre Email..." type="email" value="{{ old('email') }}" required />

                        <div class="form-control items-center my-2">
                            {!! NoCaptcha::display() !!}
                            @if ($errors->has('g-recaptcha-response'))
                                <label class="label">
                                    <span class="label-text-alt text-error">{{ $errors->first('g-recaptcha-response') }}</span>
                                </label>
                            @endif
                        </div>

                        <div class="text-center mb-3">
                            <x-button label="Envoyer le lien" class="btn btn-primary gap-2" type="submit" icon="fas-paper-plane" />
                        </div>
                    </x-form>

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

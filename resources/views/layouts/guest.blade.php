<!--
Conçu et développé par Emeric Fèvre.

@2023 Coopérative Bourgogne du Sud, Tous droits réservés.
-->
<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}" data-theme="light">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">

        <!-- CSRF Token -->
        <meta name="csrf-token" content="{{ csrf_token() }}">

        <!-- Title -->
        <title>{{ config('app.title') . ' - ' . config('bds.info.full_name') }}</title>

        <!-- Meta -->
        @stack('meta')

        <script type="text/javascript">
            /**
             * Dark Mode
             * On page load or when changing themes, best to add inline in `head` to avoid FOUC
             */
            if (localStorage.theme === 'dark' || (!('theme' in localStorage) && window.matchMedia('(prefers-color-scheme: dark)').matches)) {
                document.documentElement.classList.add('dark')
                document.documentElement.dataset.theme = "dark";
                localStorage.setItem('theme', 'dark');
            } else {
                localStorage.theme = 'light';
                document.documentElement.classList.remove('dark');
                document.documentElement.dataset.theme = 'light';
            }
        </script>

        <!-- Embed Styles -->
        @stack('style')

        <!-- Styles -->
        @vite('resources/css/bds.css')

        <!-- Favicon -->
        <link rel="icon" type="image/x-icon" href="{{ asset('favicon.ico') }}" />

        <!-- Embed Scripts -->
        @stack('scriptsTop')
    </head>
    <body>
        <div class="drawer h-full z-10">

            <div class="drawer-content flex flex-col overflow-hidden">

                <main>
                    <!-- Content -->
                    @yield('content')
                </main>

            </div>
        </div>

        <!-- CSRF JS Token -->
        <script type="text/javascript">
            window.BDS = {!! json_encode(['csrfToken' => csrf_token()]) !!}
        </script>

        @vite('resources/js/bds.js')
        @livewireScripts

        <!-- Embed Scripts -->
        @stack('scripts')

        <x-toaster-hub />
    </body>
</html>

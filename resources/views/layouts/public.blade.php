<!--
Conçu et développé par Emeric Fèvre.

@2024 Coopérative Bourgogne du Sud, Tous droits réservés.
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
                // Change the flatpickr theme to dark.
                document.getElementById('flatpickrCssFile').href = '{{ asset('/assets/flatpickr_dark.css') }}';
            } else {
                localStorage.theme = 'light';
                document.documentElement.classList.remove('dark');
                document.documentElement.dataset.theme = 'light';
            }
        </script>
        <script>document.documentElement.classList.add('js')</script>

        <!-- Embed Styles -->
        @stack('style')

        @vite('resources/css/bds.css')

        <!-- Favicon -->
        <link rel="icon" type="image/x-icon" href="{{ asset('favicon.ico') }}" />

        <!-- Embed Scripts -->
        @stack('scriptsTop')
    </head>
    <body class="overflow-x-hidden">
        <div class="drawer">
            <input id="my-drawer-3" type="checkbox" class="drawer-toggle" />
            <div class="drawer-content flex flex-col">
                <!-- Navbar -->
                @include('elements.public.header')

                <main>
                    <!-- Content -->
                    @yield('content')
                </main>

                <!-- Footer -->
                @include('elements.public.footer')
            </div>

            @include('elements.public.sidebar')
        </div>

        <!-- Scroll to Top button -->
        <x-scrolltotop />

        <!-- CSRF JS Token -->
        <script type="text/javascript">
            window.BDS = {!! json_encode(['csrfToken' => csrf_token()]) !!}
        </script>

        @vite('resources/js/bds.js')

        <!-- Embed Scripts -->
        @stack('scripts')


        <script src="https://unpkg.com/taos@1.0.5/dist/taos.js"></script>
    </body>
</html>

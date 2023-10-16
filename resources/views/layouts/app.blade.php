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

        <!-- Flatpickr -->
        <link rel="stylesheet" type="text/css" href="{{ asset('/assets/flatpickr_default.css') }}" id="flatpickrCssFile" />

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

        <div id="bds-vue">

            <div class="drawer lg:drawer-open">
                <!-- Toggle Responsive-->
                <input id="bds-drawer" type="checkbox" class="drawer-toggle" />

                <div class="drawer-content flex flex-col">
                    <!-- Header -->
                    @include('elements.header')

                    <main class="shadow-inner bg-slate-100 dark:bg-base-100">
                        <!-- Content -->
                        @yield('content')
                    </main>

                    <!-- Footer -->
                    @include('elements.footer')

                </div>

                <!-- Sidebar -->
                @include('elements.sidebar')
            </div>
        </div>

        <!-- Scroll to Top button -->
        <x-scrolltotop />

        <!-- CSRF JS Token -->
        <script type="text/javascript">
            window.BDS = {!! json_encode(['csrfToken' => csrf_token()]) !!}
        </script>

        @vite('resources/js/bds.js')

        <!-- Change Livewire expiration message -->
        <script type="text/javascript">
            document.addEventListener('livewire:init', () => {
                Livewire.hook('request', ({fail}) => {
                    fail(({status, preventDefault}) => {
                        if (status === 419) {
                            preventDefault()

                            confirm('Cette page a expirée.') && window.location.reload()

                            return false
                        }
                    })
                });
            });
        </script>

        <!-- Embed Scripts -->
        @stack('scripts')

        <x-toaster-hub />
    </body>
</html>

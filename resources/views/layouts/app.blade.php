<!--
Conçu et développé par Emeric Fèvre.

@2023 Selvah, Tous droits réservés.
-->
<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}" data-theme="light">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">

        <!-- CSRF Token -->
        <meta name="csrf-token" content="{{ csrf_token() }}">
        <!-- <meta http-equiv="refresh" content="{{ config('session.lifetime') * 60 }}"> -->

        <!-- Title -->
        <title>{{ config('app.title') . ' - ' . config('bds.info.full_name') }}</title>

        <!-- Meta -->
        @stack('meta')

        <script type="text/javascript">
            /**
             * Dark Mode
             * On page load or when changing themes, best to add inline in `head` to avoid FOUC
             */
            if (localStorage.getItem('nightMode') === 'true' ||
                (!('nightMode' in localStorage) && window.matchMedia('(prefers-color-scheme: dark)').matches)
            ) {
                document.documentElement.dataset.theme = "dark";
                localStorage.setItem("nightMode", 'true');
            }
        </script>

        <!-- Flatpickr -->
        <link rel="stylesheet" type="text/css" href="{{ asset('/assets/flatpickr_default.css') }}" />

        <!-- Embed Styles -->
        @stack('style')
        @livewireStyles

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

                    <!-- Flash Messages -->
                    @include('elements.flash')

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
        @livewireScripts
        <!-- Change Livewire expiration message -->
        <script type="text/javascript">
            Livewire.hook('request', ({ fail }) => {
                fail(({ status, preventDefault }) => {
                    if (status === 419) {
                        preventDefault()

                        confirm('Cette page a expirée.') && window.location.reload()

                        return false
                    }
                })
            })

            Livewire.on('alert', () => {
                document.querySelectorAll('[data-dismiss-target]').forEach(triggerEl => {
                    const targetEl = document.querySelector(triggerEl.getAttribute('data-dismiss-target'))

                    new Dismiss(targetEl, {
                        triggerEl
                    })
                })
            })
        </script>

        <!-- Embed Scripts -->
        @stack('scripts')
    </body>
</html>

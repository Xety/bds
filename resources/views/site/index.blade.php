@extends('layouts.app')
{!! config(['app.title' => 'Gérer les Sites']) !!}

@push('meta')
    <x-meta title="Gérer les Sites"/>
@endpush

@push('scripts')
    <script  type="module">
        window.Echo.connector.pusher.connection.bind("connected", () => {
            console.log("connected");

            // Subscribe to the "new-message" public channel
            window.Echo.channel("new-message")
                .listen(".PushNewMessage", (e) => {
                    console.log(e);
                    Toaster.success(e.msg);
                })
                .error((e) => {
                    console.log(e);
                    Toaster.error(e.msg);
                });
        });




    </script>
@endpush

@section('content')
    <x-breadcrumbs :breadcrumbs="$breadcrumbs"/>

    <section class="m-3 lg:m-10">
        <hgroup class="text-center px-5 pb-5">
            <h1 class="text-4xl font-bds">
                <x-icon name="fas-map-marked-alt" class="h-10 w-10 inline"></x-icon> Gestion des Sites
            </h1>
            <p class="text-gray-400 ">
                Gérer les sites de la {{ config('bds.info.full_name') }}.
            </p>
        </hgroup>

        <div class="grid grid-cols-12 gap-6 mb-7">
            <div
                class="col-span-12 shadow-md border rounded-lg p-3 border-gray-200 dark:border-gray-700 bg-base-100 dark:bg-base-300">
                <livewire:sites/>
            </div>
        </div>
    </section>
@endsection

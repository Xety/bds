<hgroup class="text-center px-5 pb-5">
    <h2 class="divider text-2xl font-bds">
        <i class="fa-solid fa-briefcase"></i> Paramètres Généraux
    </h2>
    <p class="text-gray-400 ">
        Paramètres applicables sur l'ensemble des sites
    </p>
</hgroup>

<x-form method="put" action="{{ route('settings.update') }}" class="w-full">
    <x-input type="hidden" name="type" value="generals" />
    <!-- Need for tailwind to compile class that are in settings label/text/label info. -->
    <span class="hidden bg-neutral"></span>
    @forelse($settingsGenerals as $setting)
        @include('setting.partials.setting-template')

    @empty
        <x-alert type="info" class="mt-4" title="Information">
            Aucun paramètre général n'a été trouvé pour le site <span class="font-bold">{{ $site->name }}</span>.
        </x-alert>
    @endforelse

    @if($settingsGenerals->isNotEmpty())
        <div class="text-center mb-3">
            <x-button label="Sauvegarder" class="btn btn-primary gap-2" type="submit" icon="fas-floppy-disk" />
        </div>
    @endif
</x-form>

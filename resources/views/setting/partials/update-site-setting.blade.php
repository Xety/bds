<hgroup class="text-center px-5 pb-5">
    <h2 class="divider text-2xl font-bds">
        <i class="fa-solid fa-briefcase"></i> Paramètres de Site
    </h2>
    <p class="text-gray-400 ">
        Paramètres applicables uniquement sur le site {{ $site->name }}
    </p>
</hgroup>

<x-form method="put" action="{{ route('settings.update') }}" class="w-full">
    <x-input type="hidden" name="type" value="sites" />
    @forelse($settingsSites as $setting)
        @include('setting.partials.setting-template')

    @empty
        <x-alert type="info" class="mt-4" title="Information">
            Aucun paramètre n'a été trouvé pour le site <span class="font-bold">{{ $site->name }}</span>.
        </x-alert>
    @endforelse

    @if($settingsSites->isNotEmpty())
        <div class="text-center mb-3">
            <x-button label="Sauvegarder" class="btn btn-primary gap-2" type="submit" icon="fas-floppy-disk" />
        </div>
    @endif
</x-form>

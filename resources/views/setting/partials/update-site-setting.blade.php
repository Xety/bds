<hgroup class="text-center px-5 pb-5">
    <h2 class="divider text-2xl font-bds">
        <i class="fa-solid fa-briefcase"></i> Paramètres de Site
    </h2>
    <p class="text-gray-400 ">
        Paramètres généraux applicables uniquement sur le site {{ $site->name }}
    </p>
</hgroup>

<x-form method="put" action="{{ route('settings.update') }}" class="w-full">
    @php $message = "Cocher pour activer la création de Zones sur le site $site->name.";@endphp
    <x-checkbox
        name="zone_create_enabled"
        label="Activation de la création des Zones"
        text="Activer la création des Zones"
        :checked="settings()->setTeamId(session('current_site_id'))->get('zone.create.enabled')"
        :label-info="$message"
    />



    <div class="text-center mb-3">
        <x-button label="Sauvegarder" class="btn btn-primary gap-2" type="submit" icon="fas-floppy-disk" />
    </div>
</x-form>

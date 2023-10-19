<hgroup class="text-center px-5 pb-5">
    <h2 class="divider text-2xl font-bds">
        <i class="fa-solid fa-briefcase"></i> Paramètres Généraux
    </h2>
    <p class="text-gray-400 ">
        Paramètres applicables sur l'ensemble des sites
    </p>
</hgroup>

<x-form method="put" action="{{ route('settings.update') }}" class="w-full">

    <x-checkbox name="user.login.enabled" label="Activer la connexion" text="Activer la connexion sur le site" :checked="settings()->setTeamId(null)->get('user.login.enabled')" />

    <div class="text-center mb-3">
        <x-button label="Sauvegarder" class="btn btn-primary gap-2" type="submit" icon="fas-floppy-disk" />
    </div>
</x-form>

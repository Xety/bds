<hgroup class="text-center px-5 pb-5">
    <h2 class="divider text-2xl font-bds">
        <i class="fa-solid fa-briefcase"></i> Paramètres Généraux
    </h2>
    <p class="text-gray-400 ">
        Paramètres applicables sur l'ensemble des sites
    </p>
</hgroup>

<x-form method="put" action="{{ route('settings.update') }}" class="w-full">
    @php $message = "Cocher pour activer le système de connexion au site. <br><b>Quand le système de connexion est désactivé, uniquement les personnes disposant de la permission direct <code class=\"text-neutral-content bg-[color:#1f2937] rounded-sm py-0.5 px-2\">bypass login</code> pourront ce connecter.</b>";@endphp
    <x-checkbox
        name="user_login_enabled"
        label="Activation du système de connexion"
        text="Activer le système de connexion sur le site"
        :checked="settings()->setTeamId(null)->get('user.login.enabled')"
        :label-info="$message"
    />

    <x-checkbox
        name="site_create_enabled"
        label="Activation de la création des Sites"
        text="Activer la création des Sites"
        :checked="settings()->setTeamId(session('current_site_id'))->get('site.create.enabled')"
        :label-info="$message"
    />

    <div class="text-center mb-3">
        <x-button label="Sauvegarder" class="btn btn-primary gap-2" type="submit" icon="fas-floppy-disk" />
    </div>
</x-form>

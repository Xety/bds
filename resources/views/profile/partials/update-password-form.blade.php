<x-form.form method="put" action="{{ route('password.update') }}" class="w-full">
    <div class="grid grid-cols-12 gap-4 mb-7">
        <div class="col-span-12 lg:col-span-4">
            <x-form.password name="current_password" label="Mot de Passe Actuel" placeholder="Mot de passe actuel..." required/>
        </div>
        <div class="col-span-12 lg:col-span-4">
            <x-form.password name="password" label="Nouveau Mot de Passe" placeholder="Nouveau mot de passe..." required/>
        </div>
        <div class="col-span-12 lg:col-span-4">
            <x-form.password name="password_confirmation" label="Mot de Passe Confirmation" placeholder="Nouveau mot de passe..." required/>
        </div>
    </div>

    <div class="text-center mb-3">
        <button type="submit" class="btn btn-primary gap-2">
            <i class="fa-regular fa-floppy-disk"></i>
            Sauvegarder
        </button>
    </div>
</x-form.form>
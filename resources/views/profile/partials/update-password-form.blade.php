<x-form method="put" action="{{ route('password.update') }}" class="w-full">
    <div class="grid grid-cols-12 gap-4 mb-7">
        <div class="col-span-12 lg:col-span-4">
            <x-input label="Mot de Passe Actuel" name="current_password" placeholder="Mot de passe actuel..." type="password" required />
        </div>
        <div class="col-span-12 lg:col-span-4">
            <x-input label="Nouveau Mot de Passe" name="password" placeholder="Nouveau mot de passe..." type="password" required />
        </div>
        <div class="col-span-12 lg:col-span-4">
            <x-input label="Mot de Passe Confirmation" name="password_confirmation" placeholder="Nouveau mot de passe..." type="password" required />
        </div>
    </div>

    <div class="text-center mb-3">
        <x-button label="Sauvegarder" class="btn btn-primary gap-2" type="submit" icon="fas-floppy-disk" />
    </div>
</x-form>

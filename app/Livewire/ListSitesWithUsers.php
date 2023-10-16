<?php

namespace BDS\Livewire;

use BDS\Models\Site;
use Livewire\Component;
use BDS\Models\Role;
use Spatie\Permission\PermissionRegistrar;

class ListSitesWithUsers extends Component
{
    public function placeholder()
    {
        return view('livewire.placeholders.skeleton');
    }

    public function render()
    {
        $sites = Site::with(['users'])
            ->orderBy('name')
            ->get();

        $newSites = [];

        foreach ($sites as $site) {
            $newUsers = [];

            foreach ($site->users as $user) {
                $roles = Role::with('permissions')->whereHas('users', function ($query) use ($user, $site) {
                    $query->where(config('permission.column_names.model_morph_key'), $user->getKey())
                        ->where(PermissionRegistrar::$teamsKey, $site->getKey());
                })->get();

                $user->roles = $roles;
                $newUsers[] = $user;
            }

            $site->users = $newUsers;
            $newUsers = [];

            $newSites[] = $site;
        }

        $sites = $newSites;

        return view('livewire.list-sites-with-users', [
            'sites' => $sites
        ]);
    }
}

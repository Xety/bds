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
        $sites = auth()->user()->sites()->with(['users', 'users.permissionsWithoutSite'])
            ->orderBy('name')
            ->get()->toArray();

        //dd($sites);

        /*$sites = Site::with(['users', 'users.permissionsWithoutSite'])
            ->orderBy('name')
            ->get()->toArray();*/

        $newSites = [];

        foreach ($sites as $site) {
            $newUsers = [];

            foreach ($site['users'] as $user) {
                $roles = Role::with('permissions')->whereHas('users', function ($query) use ($user, $site) {
                    $query->where(config('permission.column_names.model_morph_key'), $user['id'])
                        ->where(PermissionRegistrar::$teamsKey, $site['id']);
                })->get()->toArray();

                $user['roles'] = $roles;
                //$user['permissions'] = $user['permissions'];
                $newUsers[] = $user;
            }

            $site['users'] = $newUsers;
            $newUsers = [];

            $newSites[] = $site;
        }

        $sites = $newSites;

        //dd($sites);

        return view('livewire.list-sites-with-users', [
            'sites' => $sites
        ]);
    }
}

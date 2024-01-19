<?php

namespace BDS\Livewire;

use Livewire\Component;
use BDS\Models\Role;

class ListSitesWithUsers extends Component
{
    public function placeholder()
    {
        return view('livewire.placeholders.skeleton');
    }

    public function render()
    {
        $sites = auth()->user()->sites()->with(['users', 'users.permissionsWithoutSite', 'users.roles'])
            //->select(['sites.users.id', 'sites.users.first_name', 'sites.users.last_name'])
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
                        ->where(config('permission.column_names.team_foreign_key'), $site['id']);
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

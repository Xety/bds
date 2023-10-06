<?php

namespace BDS\Http\Controllers;

use BDS\Models\Site;
use Illuminate\View\View;
use BDS\Models\User;

class UserController extends Controller
{
    public function __construct()
    {
        parent::__construct();

        $this->breadcrumbs->addCrumb(
            '<i class="fa-solid fa-users mr-2"></i> Gérer les Utilisateurs',
            route('users.index')
        );
    }

    /**
     * Show the search page.
     *
     * @return \Illuminate\View\View
     */
    public function index(): View
    {
        $this->authorize('viewAny', User::class);

        $breadcrumbs = $this->breadcrumbs->addCrumb(
            '<i class="fa-solid fa-users mr-2"></i> Gérer les Utilisateurs',
            route('users.index')
        );

        return view('user.index', ['breadcrumbs' => $this->breadcrumbs]);
    }

    public function permissions()
    {
        /*$user = auth()->user()->load([
            'roles_all' => function ($query) {
                $query->leftJoin('sites', function ($join) {
                    $join->on(config('permission.table_names.roles').'.site_id', '=', 'sites.id');
                });
            }
        ]);*/

        $sites = Site::with('users', 'users.roles')->get();

        //dd($sites);

        return view('user.permissions', [
            'sites' => $sites,
            'breadcrumbs' => $this->breadcrumbs
        ]);
    }
}

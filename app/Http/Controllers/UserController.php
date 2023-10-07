<?php

namespace BDS\Http\Controllers;

use BDS\Models\Site;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Query\JoinClause;
use Illuminate\Support\Facades\DB;
use Illuminate\View\View;
use BDS\Models\User;
use Spatie\Permission\Models\Role;
use Spatie\Permission\PermissionRegistrar;

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

    public function show()
    {
    }

    public function permissions()
    {
        return view('user.permissions', [
            'breadcrumbs' => $this->breadcrumbs
        ]);
    }
}

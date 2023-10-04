<?php

namespace BDS\Http\Controllers\Role;

use Illuminate\View\View;
use BDS\Http\Controllers\Controller;
use Spatie\Permission\Models\Role;

class RoleController extends Controller
{
    /**
     * Show all the roles.
     *
     * @return \Illuminate\View\View
     */
    public function index(): View
    {
        $this->authorize('viewAny', Role::class);

        $breadcrumbs = $this->breadcrumbs->addCrumb(
            '<i class="fa-solid fa-user-tie mr-2"></i> Gérer les Rôles',
            route('roles.roles.index')
        );

        return view('role.role.index', compact('breadcrumbs'));
    }
}

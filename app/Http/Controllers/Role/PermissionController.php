<?php

namespace BDS\Http\Controllers\Role;

use Illuminate\View\View;
use BDS\Http\Controllers\Controller;
use Spatie\Permission\Models\Permission;

class PermissionController extends Controller
{
    /**
     * Show all the permissions.
     *
     * @return \Illuminate\View\View
     */
    public function index(): View
    {
        $this->authorize('viewAny', Permission::class);

        $breadcrumbs = $this->breadcrumbs->addCrumb(
            '<i class="fa-solid fa-user-shield mr-2"></i> Gérer les Permissions',
            route('roles.permissions.index')
        );

        return view('role.permission.index', compact('breadcrumbs'));
    }
}

<?php

namespace BDS\Http\Controllers;

use Illuminate\View\View;
use BDS\Models\User;

class UserController extends Controller
{
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

        return view('user.index', compact('breadcrumbs'));
    }
}

<?php

namespace BDS\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\View\View;

class ProfileController extends Controller
{
    public function __construct()
    {
        parent::__construct();

        $this->breadcrumbs->addCrumb(
            '<i class="fa-solid fa-user-gear mr-2"></i> Mon Profil',
            route('profile.edit')
        );
    }

    /**
     * Display the user's profile form.
     */
    public function edit(Request $request): View
    {
        return view('profile.edit', [
            'user' => $request->user(),
            'breadcrumbs' => $this->breadcrumbs
        ]);
    }
}

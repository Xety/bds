<?php

namespace BDS\Http\Controllers;

use Illuminate\View\View;
use BDS\Models\Cleaning;

class CleaningController extends Controller
{
    /**
     * Show all the cleanings.
     *
     * @return \Illuminate\View\View
     */
    public function index(): View
    {
        $this->authorize('viewAny', Cleaning::class);

        $breadcrumbs = $this->breadcrumbs->addCrumb(
            '<i class="fa-solid fa-broom mr-2"></i> Gérer les Nettoyages',
            route('cleanings.index')
        );

        return view('cleaning.index', compact('breadcrumbs'));
    }
}

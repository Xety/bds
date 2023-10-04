<?php

namespace BDS\Http\Controllers;

use Illuminate\View\View;
use BDS\Models\Setting;

class SettingController extends Controller
{
    /**
     * Show all the settings.
     *
     * @return \Illuminate\View\View
     */
    public function index(): View
    {
        $this->authorize('viewAny', Setting::class);

        $breadcrumbs = $this->breadcrumbs->addCrumb(
            '<i class="fa-solid fa-wrench mr-2"></i> Gérer les Paramètres',
            route('settings.index')
        );

        return view('setting.index', compact('breadcrumbs'));
    }
}

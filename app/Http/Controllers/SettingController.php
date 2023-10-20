<?php

namespace BDS\Http\Controllers;

use BDS\Models\Site;
use Illuminate\Http\Request;
use Illuminate\View\View;
use BDS\Models\Setting;
use Rawilk\Settings\Facades\Settings;

class SettingController extends Controller
{
    /**
     * Show all the settings.
     *
     * @return View
     */
    public function index(): View
    {
        $this->authorize('viewAny', Setting::class);

        $breadcrumbs = $this->breadcrumbs->addCrumb(
            '<i class="fa-solid fa-wrench mr-2"></i> Gérer les Paramètres',
            route('settings.index')
        );

        $site = Site::find(session('current_site_id'));

        $settings = Setting::whereNull('site_id')->first();
        dd($settings->value);

        return view('setting.index', compact('breadcrumbs', 'site'));
    }

    public function update(Request $request)
    {
        //dd($request->all());

        Settings::setTeamId(null)->set('user.login.enabled', $request->boolean('user_login_enabled'));

        return redirect()->back();
    }
}

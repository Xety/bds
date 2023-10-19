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

        // Settings without site assigned to.
        //Settings::setTeamId(null)->set('user.login.enabled', true);

        // Settings for all sites except Verdun Siège.
        /**for ($i = 2; $i < 52; $i++) {
            Settings::setTeamId($i)->set('zone.create.enabled', true);
            Settings::setTeamId($i)->set('site.create.enabled', true);
            Settings::setTeamId($i)->set('cleaning.create.enabled', true);
        }

        // Setting for Selvah
        $selvah = Site::where('name', 'Selvah')->first();
        Settings::setTeamId($selvah->id)->set('production.objective.delivered', '310270');
        Settings::setTeamId($selvah->id)->set('production.objective.todo', '715520');*/

        $generalSettings = Setting::getAll();

        $siteSettings = Setting::getAll(session('current_site_id'));

        //dd($generalSettings, $siteSettings);

        return view('setting.index', compact('breadcrumbs'));
    }

    public function update(Request $request)
    {
        //dd($request->all());

        Settings::setTeamId(null)->set('user.login.enabled', (bool)$request->input('user_login_enabled'));

        return redirect()->back();
    }
}

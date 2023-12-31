<?php

namespace BDS\Http\Controllers;

use BDS\Models\Repositories\SettingRepository;
use BDS\Models\Setting;
use BDS\Models\Site;
use BDS\Models\Validators\SettingValidator;
use BDS\Settings\Settings;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;

class SettingController extends Controller
{
    public function __construct()
    {
        parent::__construct();

        $this->breadcrumbs->addCrumb(
            '<svg class="inline-flex h-5 w-5 mr-2" fill="currentColor" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 512 512"><path d="M487.4 315.7l-42.6-24.6c4.3-23.2 4.3-47 0-70.2l42.6-24.6c4.9-2.8 7.1-8.6 5.5-14-11.1-35.6-30-67.8-54.7-94.6-3.8-4.1-10-5.1-14.8-2.3L380.8 110c-17.9-15.4-38.5-27.3-60.8-35.1V25.8c0-5.6-3.9-10.5-9.4-11.7-36.7-8.2-74.3-7.8-109.2 0-5.5 1.2-9.4 6.1-9.4 11.7V75c-22.2 7.9-42.8 19.8-60.8 35.1L88.7 85.5c-4.9-2.8-11-1.9-14.8 2.3-24.7 26.7-43.6 58.9-54.7 94.6-1.7 5.4.6 11.2 5.5 14L67.3 221c-4.3 23.2-4.3 47 0 70.2l-42.6 24.6c-4.9 2.8-7.1 8.6-5.5 14 11.1 35.6 30 67.8 54.7 94.6 3.8 4.1 10 5.1 14.8 2.3l42.6-24.6c17.9 15.4 38.5 27.3 60.8 35.1v49.2c0 5.6 3.9 10.5 9.4 11.7 36.7 8.2 74.3 7.8 109.2 0 5.5-1.2 9.4-6.1 9.4-11.7v-49.2c22.2-7.9 42.8-19.8 60.8-35.1l42.6 24.6c4.9 2.8 11 1.9 14.8-2.3 24.7-26.7 43.6-58.9 54.7-94.6 1.5-5.5-.7-11.3-5.6-14.1zM256 336c-44.1 0-80-35.9-80-80s35.9-80 80-80 80 35.9 80 80-35.9 80-80 80z"></path></svg>
                        Paramètres',
            route('settings.index')
        );
    }

    /**
     * Show all the settings.
     *
     * @return View
     */
    public function index(): View
    {
        $this->authorize('viewAny', Setting::class);

        $site = Site::find(session('current_site_id'));

       $settingsGenerals = Setting::generals()->get();
       $settingsSites = Setting::sites()->get();

        $breadcrumbs = $this->breadcrumbs->addCrumb(
            '<svg class="inline-flex h-5 w-5 mr-2" fill="currentColor" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 512 512"><path d="M487.4 315.7l-42.6-24.6c4.3-23.2 4.3-47 0-70.2l42.6-24.6c4.9-2.8 7.1-8.6 5.5-14-11.1-35.6-30-67.8-54.7-94.6-3.8-4.1-10-5.1-14.8-2.3L380.8 110c-17.9-15.4-38.5-27.3-60.8-35.1V25.8c0-5.6-3.9-10.5-9.4-11.7-36.7-8.2-74.3-7.8-109.2 0-5.5 1.2-9.4 6.1-9.4 11.7V75c-22.2 7.9-42.8 19.8-60.8 35.1L88.7 85.5c-4.9-2.8-11-1.9-14.8 2.3-24.7 26.7-43.6 58.9-54.7 94.6-1.7 5.4.6 11.2 5.5 14L67.3 221c-4.3 23.2-4.3 47 0 70.2l-42.6 24.6c-4.9 2.8-7.1 8.6-5.5 14 11.1 35.6 30 67.8 54.7 94.6 3.8 4.1 10 5.1 14.8 2.3l42.6-24.6c17.9 15.4 38.5 27.3 60.8 35.1v49.2c0 5.6 3.9 10.5 9.4 11.7 36.7 8.2 74.3 7.8 109.2 0 5.5-1.2 9.4-6.1 9.4-11.7v-49.2c22.2-7.9 42.8-19.8 60.8-35.1l42.6 24.6c4.9 2.8 11 1.9 14.8-2.3 24.7-26.7 43.6-58.9 54.7-94.6 1.5-5.5-.7-11.3-5.6-14.1zM256 336c-44.1 0-80-35.9-80-80s35.9-80 80-80 80 35.9 80 80-35.9 80-80 80z"></path></svg>
                        Gérer les Paramètres',
            route('settings.index')
        );

        return view('setting.index', compact('breadcrumbs', 'site', 'settingsGenerals', 'settingsSites'));
    }

    /**
     * Update the settings.
     *
     * @param Settings $settings
     * @param Request $request
     *
     * @return RedirectResponse
     */
    public function update(Settings $settings, Request $request)
    {
        $this->authorize('update', Setting::class);

        $type = $request->input('type');

        return match ($type) {
            'sites' => $this->updateSites($settings, $request),
            'generals' => $this->updateGenerals($settings, $request),
            default => back()
                ->withInput()
                ->with('danger', 'Type Invalide.'),
        };
    }

    /**
     * Handle a sites settings update.
     *
     * @param Settings $settings
     * @param Request $request
     *
     * @return RedirectResponse
     */
    protected function updateSites(Settings $settings, Request $request): RedirectResponse
    {
        $validated = SettingValidator::validateSites($request->all())->validate();
        $updated = SettingRepository::update($settings, $validated, $request->input('type'));

        if (!$updated) {
            return redirect()
                ->back()
                ->error('Erreur lors de la sauvegarde des paramètres de sites !');
        }

        return redirect()
            ->back()
            ->success('Les paramètres de sites ont bien été mis à jour !');
    }

    /**
     * Handle a sites settings update.
     *
     * @param Settings $settings
     * @param Request $request
     *
     * @return RedirectResponse
     */
    protected function updateGenerals(Settings $settings, Request $request): RedirectResponse
    {
        $validated = SettingValidator::validateGenerals($request->all())->validate();
        $updated = SettingRepository::update($settings, $validated, $request->input('type'));

        if (!$updated) {
            return redirect()
                ->back()
                ->error('Erreur lors de la sauvegarde des paramètres généraux !');
        }

        return redirect()
            ->back()
            ->success('Les paramètres généraux ont bien été mis à jour !');
    }
}

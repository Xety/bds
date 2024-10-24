<?php

namespace BDS\Http\Controllers;

use BDS\Models\Cleaning;
use BDS\Models\Incident;
use BDS\Models\Maintenance;
use Carbon\Carbon;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\DB;
use Illuminate\View\View;
use BDS\Models\Material;

class MaterialController extends Controller
{

    public function __construct()
    {
        parent::__construct();

        $this->breadcrumbs->addCrumb(
            '<svg class="h-4 w-4 mr-2" fill="currentColor" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 512 512"><path d="M176 24c0-13.3-10.7-24-24-24s-24 10.7-24 24V64c-35.3 0-64 28.7-64 64H24c-13.3 0-24 10.7-24 24s10.7 24 24 24H64v56H24c-13.3 0-24 10.7-24 24s10.7 24 24 24H64v56H24c-13.3 0-24 10.7-24 24s10.7 24 24 24H64c0 35.3 28.7 64 64 64v40c0 13.3 10.7 24 24 24s24-10.7 24-24V448h56v40c0 13.3 10.7 24 24 24s24-10.7 24-24V448h56v40c0 13.3 10.7 24 24 24s24-10.7 24-24V448c35.3 0 64-28.7 64-64h40c13.3 0 24-10.7 24-24s-10.7-24-24-24H448V280h40c13.3 0 24-10.7 24-24s-10.7-24-24-24H448V176h40c13.3 0 24-10.7 24-24s-10.7-24-24-24H448c0-35.3-28.7-64-64-64V24c0-13.3-10.7-24-24-24s-24 10.7-24 24V64H280V24c0-13.3-10.7-24-24-24s-24 10.7-24 24V64H176V24zM160 128H352c17.7 0 32 14.3 32 32V352c0 17.7-14.3 32-32 32H160c-17.7 0-32-14.3-32-32V160c0-17.7 14.3-32 32-32zm192 32H160V352H352V160z"></path></svg>
                        Matériels',
            route('materials.index')
        );
    }

    /**
     * Show all the materials.
     *
     * @return View
     */
    public function index(): View
    {
        $this->authorize('viewAny', Material::class);

        $this->breadcrumbs->addCrumb(
            '<svg class="h-5 w-5 mr-2" fill="currentColor" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 512 512"><path d="M176 24c0-13.3-10.7-24-24-24s-24 10.7-24 24V64c-35.3 0-64 28.7-64 64H24c-13.3 0-24 10.7-24 24s10.7 24 24 24H64v56H24c-13.3 0-24 10.7-24 24s10.7 24 24 24H64v56H24c-13.3 0-24 10.7-24 24s10.7 24 24 24H64c0 35.3 28.7 64 64 64v40c0 13.3 10.7 24 24 24s24-10.7 24-24V448h56v40c0 13.3 10.7 24 24 24s24-10.7 24-24V448h56v40c0 13.3 10.7 24 24 24s24-10.7 24-24V448c35.3 0 64-28.7 64-64h40c13.3 0 24-10.7 24-24s-10.7-24-24-24H448V280h40c13.3 0 24-10.7 24-24s-10.7-24-24-24H448V176h40c13.3 0 24-10.7 24-24s-10.7-24-24-24H448c0-35.3-28.7-64-64-64V24c0-13.3-10.7-24-24-24s-24 10.7-24 24V64H280V24c0-13.3-10.7-24-24-24s-24 10.7-24 24V64H176V24zM160 128H352c17.7 0 32 14.3 32 32V352c0 17.7-14.3 32-32 32H160c-17.7 0-32-14.3-32-32V160c0-17.7 14.3-32 32-32zm192 32H160V352H352V160z"></path></svg>
                        Gérer les Matériels',
            route('materials.index')
        );

        return view('material.index', ['breadcrumbs' => $this->breadcrumbs]);
    }

    /**
     * Show a material.
     *
     * @param Material $material The material.
     *
     * @return View|RedirectResponse
     */
    public function show(Material $material): View|RedirectResponse
    {
        $this->authorize('view', $material);

        $parts = $material->parts()->with('supplier', 'site')->paginate(25, ['*'], 'parts');
        $incidents = $material->incidents()->with('user')->orderByDesc('created_at')->paginate(25, ['*'], 'incidents');
        $maintenances = $material->maintenances()->with('user')->orderByDesc('created_at')->paginate(25, ['*'], 'maintenances');
        $cleanings = $material->cleanings()->with('user')->orderByDesc('created_at')->paginate(25, ['*'], 'cleanings');

        $breadcrumbs = $this->breadcrumbs->addCrumb($material->name, $material->show_url);

        // Chart for Incidents, Maintenances & Cleanings.
        $chart = Cache::remember(
            'Material.incidents.maintenances.cleanings.count.last_12months.' . $material->getKey(),
            config('bds.cache.materials_incidents_maintenances_cleanings_count_last_12_months'),
            function() use($material) {
                $incidentsData = [];
                $maintenancesData = [];
                $cleaningsData = [];
                $monthsData = [];
                $array = [];
                $months = 11;

                for ($i = 0; $i <= $months; $i++) {
                    $lastXMonthsText = Carbon::now()->startOfMonth()->subMonths($i)->translatedFormat('F Y');
                    $monthsData[$i] = ucfirst($lastXMonthsText);

                    $startXMonthsAgo = Carbon::now()->startOfMonth()->subMonthsNoOverflow($i)->toDateString();
                    $endXMonthsAgo = Carbon::now()->subMonthsNoOverflow($i)->endOfMonth()->toDateString();

                    $incidentsData[$i] = Incident::where('material_id', $material->getKey())
                        ->whereDate('created_at', '>=', $startXMonthsAgo)
                        ->whereDate('created_at', '<=', $endXMonthsAgo)
                        ->count();

                    $maintenancesData[$i] = Maintenance::where('material_id', $material->getKey())
                        ->whereDate('created_at', '>=', $startXMonthsAgo)
                        ->whereDate('created_at', '<=', $endXMonthsAgo)
                        ->count();

                    $cleaningsData[$i] = Cleaning::where('material_id', $material->getKey())
                        ->whereDate('created_at', '>=', $startXMonthsAgo)
                        ->whereDate('created_at', '<=', $endXMonthsAgo)
                        ->count();
                }
                $array['months'] = array_reverse($monthsData);
                $array['incidents'] = array_reverse($incidentsData);
                $array['maintenances'] = array_reverse($maintenancesData);
                $array['cleanings'] = array_reverse($cleaningsData);

                return $array;
            }
        );

        return view(
            'material.show',
            compact('breadcrumbs', 'material', 'parts', 'incidents', 'maintenances', 'cleanings', 'chart')
        );
    }
}

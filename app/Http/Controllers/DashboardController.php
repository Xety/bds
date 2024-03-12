<?php

namespace BDS\Http\Controllers;

use BDS\Models\Cleaning;
use BDS\Models\Incident;
use BDS\Models\Maintenance;
use BDS\Models\Part;
use BDS\Models\PartEntry;
use BDS\Models\PartExit;
use BDS\Models\Site;
use Carbon\Carbon;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\DB;

class DashboardController extends Controller
{
    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function index()
    {
        $viewDatas = [];

        $breadcrumbs = $this->breadcrumbs;
        array_push($viewDatas, 'breadcrumbs');

        // If the user is a Saisonnier, render directly.
        if (Auth::user()->hasRole('Saisonnier Bourgogne du Sud')) {
            $site = Site::whereId(getPermissionsTeamId())->first();
            $managers = $site->managers()->get();

            return view('dashboard.saisonnier', compact('breadcrumbs', 'site', 'managers'));
        }

        $site = getPermissionsTeamId();


        // Initialize all carbon instances.
        $startLastMonth = Carbon::now()->startOfMonth()->toDateString();
        $endLastMonth = Carbon::now()->endOfMonth()->toDateString();
        $start2MonthsAgo = Carbon::now()->startOfMonth()->subMonthsNoOverflow()->toDateString();
        $end2MonthsAgo = Carbon::now()->subMonthsNoOverflow()->endOfMonth()->toDateString();
        $lastMonthText = Carbon::now()->translatedFormat('F');
        $last2MonthsText = Carbon::now()->subMonth()->translatedFormat('F');
        array_push($viewDatas, 'lastMonthText');
        array_push($viewDatas, 'last2MonthsText');

        // Incidents
        $lastMonthIncidents = Cache::remember(
            'Dashboard.incidents.count.last_month.' . $site,
            config('bds.cache.incidents_count'),
            function () use ($startLastMonth, $endLastMonth) {
                $query = Incident::whereDate('created_at', '>=', $startLastMonth)
                    ->whereDate('created_at', '<=', $endLastMonth);

                if (getPermissionsTeamId() !== settings('site_id_verdun_siege')) {
                    $query->where('site_id', getPermissionsTeamId());
                }

                return $query->count();
            }
        );
        array_push($viewDatas, 'lastMonthIncidents');

        $last2Months = Cache::remember(
            'Dashboard.incidents.count.last_2months.' . $site,
            config('bds.cache.incidents_count'),
            function () use ($start2MonthsAgo, $end2MonthsAgo) {
                $query = Incident::whereDate('created_at', '>=', $start2MonthsAgo)
                    ->whereDate('created_at', '<=', $end2MonthsAgo);

                if (getPermissionsTeamId() !== settings('site_id_verdun_siege')) {
                    $query->where('site_id', getPermissionsTeamId());
                }

                return $query->count();
            }
        );

        $percentIncidentsCount = round($last2Months == 0 ?
            $lastMonthIncidents * 100 :
            (($lastMonthIncidents - $last2Months) / $last2Months) * 100, 2);
        array_push($viewDatas, 'percentIncidentsCount');

        // Maintenances
        $lastMonthMaintenances = Cache::remember(
            'Dashboard.maintenances.count.last_month.' . $site,
            config('bds.cache.maintenances_count'),
            function () use ($startLastMonth, $endLastMonth) {
                $query = Maintenance::whereDate('created_at', '>=', $startLastMonth)
                    ->whereDate('created_at', '<=', $endLastMonth);

                if (getPermissionsTeamId() !== settings('site_id_verdun_siege')) {
                    $query->where('site_id', getPermissionsTeamId());
                }

                return $query->count();
            }
        );
        array_push($viewDatas, 'lastMonthMaintenances');

        $last2Months = Cache::remember(
            'Dashboard.maintenances.count.last_2months.' . $site,
            config('bds.cache.maintenances_count'),
            function () use ($start2MonthsAgo, $end2MonthsAgo) {
                $query = Maintenance::whereDate('created_at', '>=', $start2MonthsAgo)
                    ->whereDate('created_at', '<=', $end2MonthsAgo);

                if (getPermissionsTeamId() !== settings('site_id_verdun_siege')) {
                    $query->where('site_id', getPermissionsTeamId());
                }

                return $query->count();
            }
        );

        $percentMaintenancesCount = round($last2Months == 0 ?
            $lastMonthMaintenances * 100 :
            (($lastMonthMaintenances - $last2Months) / $last2Months) * 100, 2);
        array_push($viewDatas, 'percentMaintenancesCount');

        // Part
        $partInStock = Cache::remember(
            'Dashboard.parts.count.last_month.' . $site,
            config('bds.cache.cleanings_count'),
            function () {
                return number_format(Part::query()->where(function($query) {
                    if (getPermissionsTeamId() !== settings('site_id_verdun_siege')) {
                        $query->where('site_id', getPermissionsTeamId());
                    }

                    return $query;
                })->sum(DB::raw('part_entry_total - part_exit_total')));
            }
        );
        array_push($viewDatas, 'partInStock');

        // Cleanings
        $lastMonthCleanings = Cache::remember(
            'Dashboard.cleanings.count.last_month.' . $site,
            config('bds.cache.maintenances_count'),
            function () use ($startLastMonth, $endLastMonth) {
                $query =  Cleaning::whereDate('created_at', '>=', $startLastMonth)
                    ->whereDate('created_at', '<=', $endLastMonth);

                if (getPermissionsTeamId() !== settings('site_id_verdun_siege')) {
                    $query->where('site_id', getPermissionsTeamId());
                }

                return $query->count();
            }
        );
        array_push($viewDatas, 'lastMonthCleanings');

        // Graph Incidents/Maintenances
        $incidentsMaintenancesGraphData = Cache::remember(
            'Dashboard.maintenances.count.last_12months.' . $site,
            config('bds.cache.graph_maintenance_incident'),
            function () {
                $maintenancesData = [];
                $incidentsData = [];
                $monthsData = [];
                $array = [];
                $months = 11;

                for ($i = 0; $i <= $months; $i++) {
                    $lastXMonthsText = Carbon::now()->startOfMonth()->subMonths($i)->translatedFormat('F Y');
                    $monthsData[$i] = ucfirst($lastXMonthsText);

                    $startXMonthsAgo = Carbon::now()->startOfMonth()->subMonthsNoOverflow($i)->toDateString();
                    $endXMonthsAgo = Carbon::now()->subMonthsNoOverflow($i)->endOfMonth()->toDateString();

                    // Maintenances
                    $query = Maintenance::whereDate('created_at', '>=', $startXMonthsAgo)
                        ->whereDate('created_at', '<=', $endXMonthsAgo);

                    if (getPermissionsTeamId() !== settings('site_id_verdun_siege')) {
                        $query->where('site_id', getPermissionsTeamId());
                    }
                    $maintenancesData[$i] = $query->count();

                    // Incidents
                    $query = Incident::whereDate('created_at', '>=', $startXMonthsAgo)
                        ->whereDate('created_at', '<=', $endXMonthsAgo);

                   if (getPermissionsTeamId() !== settings('site_id_verdun_siege')) {
                       $query->where('site_id', getPermissionsTeamId());
                   }
                   $incidentsData[$i] = $query->count();
                }
                $array['months'] = array_reverse($monthsData);
                $array['maintenances'] = array_reverse($maintenancesData);
                $array['incidents'] = array_reverse($incidentsData);

                return $array;
            }
        );
        array_push($viewDatas, 'incidentsMaintenancesGraphData');

        // Graph PartEntries and PartExits.
        $partEntriesPartExitsGraphData = Cache::remember(
            'Dashboard.part-entries.part-exits.count.last_12months.' . $site,
            config('bds.cache.graph_part_entries_part_exits'),
            function () {
                $partsEntriesData = [];
                $partsExitsData = [];
                $monthsData = [];
                $array = [];
                $months = 11;

                for ($i = 0; $i <= $months; $i++) {
                    $lastXMonthsText = Carbon::now()->startOfMonth()->subMonths($i)->translatedFormat('F Y');
                    $monthsData[$i] = ucfirst($lastXMonthsText);

                    $startXMonthsAgo = Carbon::now()->startOfMonth()->subMonthsNoOverflow($i)->toDateString();
                    $endXMonthsAgo = Carbon::now()->subMonthsNoOverflow($i)->endOfMonth()->toDateString();

                    $query = PartEntry::query()
                        ->whereDate('created_at', '>=', $startXMonthsAgo)
                        ->whereDate('created_at', '<=', $endXMonthsAgo);

                    if (getPermissionsTeamId() !== settings('site_id_verdun_siege')) {
                        $query->whereRelation('part.site', 'id', getPermissionsTeamId());
                    }
                    $partsEntriesData[$i] = $query->sum(DB::raw('number'));

                    $query = PartExit::query()
                        ->whereDate('created_at', '>=', $startXMonthsAgo)
                        ->whereDate('created_at', '<=', $endXMonthsAgo);

                    if (getPermissionsTeamId() !== settings('site_id_verdun_siege')) {
                        $query->whereRelation('part.site', 'id', getPermissionsTeamId());
                    }
                   $partsExitsData[$i] = $query->sum(DB::raw('number'));
                }
                $array['months'] = array_reverse($monthsData);
                $array['parts-entries'] = array_reverse($partsEntriesData);
                $array['parts-exits'] = array_reverse($partsExitsData);
                return $array;
            }
        );
        array_push($viewDatas, 'partEntriesPartExitsGraphData');

        // Incidents & Maintenances
        $query = Incident::where('is_finished', false);

        if (getPermissionsTeamId() !== settings('site_id_verdun_siege')) {
            $query->where('site_id', getPermissionsTeamId());
        }
        $incidents = $query->orderBy('created_at', 'desc')
            ->paginate(5, ['*'], 'incidents');

        $maintenances = Maintenance::where('is_finished', false)
            ->orderBy('created_at', 'desc')
            ->paginate(5, ['*'], 'maintenances');
        array_push($viewDatas, 'incidents', 'maintenances');


        // Price total of all part in stock
        $priceTotalAllPartInStock = Cache::remember(
            'Parts.count.price_total_all_part_in_stock'. $site,
            config('bds.cache.parts.price_total_all_part_in_stock'),
            function () {
                return number_format(Part::query()->where(function($query) {
                    if (getPermissionsTeamId() !== settings('site_id_verdun_siege')) {
                        $query->where('site_id', getPermissionsTeamId());
                    }

                    return $query;
                })->sum(DB::raw('price * (part_entry_total - part_exit_total)')));
            }
        );
        $viewDatas[] = 'priceTotalAllPartInStock';


        return view('dashboard.index', compact($viewDatas));
    }
}

<?php

namespace BDS\Http\Controllers;

use Carbon\Carbon;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\DB;
use Illuminate\View\View;
use BDS\Models\Part;
use BDS\Models\PartEntry;
use BDS\Models\PartExit;

class PartController extends Controller
{
    public function __construct()
    {
        parent::__construct();

        $this->breadcrumbs->addCrumb(
            '<svg class="h-5 w-5 mr-2" fill="currentColor" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 512 512"><path d="M495.9 166.6c3.2 8.7 .5 18.4-6.4 24.6l-43.3 39.4c1.1 8.3 1.7 16.8 1.7 25.4s-.6 17.1-1.7 25.4l43.3 39.4c6.9 6.2 9.6 15.9 6.4 24.6c-4.4 11.9-9.7 23.3-15.8 34.3l-4.7 8.1c-6.6 11-14 21.4-22.1 31.2c-5.9 7.2-15.7 9.6-24.5 6.8l-55.7-17.7c-13.4 10.3-28.2 18.9-44 25.4l-12.5 57.1c-2 9.1-9 16.3-18.2 17.8c-13.8 2.3-28 3.5-42.5 3.5s-28.7-1.2-42.5-3.5c-9.2-1.5-16.2-8.7-18.2-17.8l-12.5-57.1c-15.8-6.5-30.6-15.1-44-25.4L83.1 425.9c-8.8 2.8-18.6 .3-24.5-6.8c-8.1-9.8-15.5-20.2-22.1-31.2l-4.7-8.1c-6.1-11-11.4-22.4-15.8-34.3c-3.2-8.7-.5-18.4 6.4-24.6l43.3-39.4C64.6 273.1 64 264.6 64 256s.6-17.1 1.7-25.4L22.4 191.2c-6.9-6.2-9.6-15.9-6.4-24.6c4.4-11.9 9.7-23.3 15.8-34.3l4.7-8.1c6.6-11 14-21.4 22.1-31.2c5.9-7.2 15.7-9.6 24.5-6.8l55.7 17.7c13.4-10.3 28.2-18.9 44-25.4l12.5-57.1c2-9.1 9-16.3 18.2-17.8C227.3 1.2 241.5 0 256 0s28.7 1.2 42.5 3.5c9.2 1.5 16.2 8.7 18.2 17.8l12.5 57.1c15.8 6.5 30.6 15.1 44 25.4l55.7-17.7c8.8-2.8 18.6-.3 24.5 6.8c8.1 9.8 15.5 20.2 22.1 31.2l4.7 8.1c6.1 11 11.4 22.4 15.8 34.3zM256 336a80 80 0 1 0 0-160 80 80 0 1 0 0 160z"></path></svg>
                            Gérer les Pièces Détachées',
            route('parts.index')
        );
    }

    /**
     * Show all the materials.
     *
     * @return \Illuminate\View\View
     */
    public function index(): View
    {
        $this->authorize('viewAny', Part::class);

        $breadcrumbs = $this->breadcrumbs;

        return view('part.index', compact('breadcrumbs'));
    }

    /**
     * Show the part.
     *
     * @param Part $part The part model to show.
     *
     * @return \Illuminate\View\View|Illuminate\Http\RedirectResponse
     */
    public function show(Part $part): View|RedirectResponse
    {
        $this->authorize('view', $part);

        $materials = $part->materials()->paginate(25, ['*'], 'materials');
        $partEntries = $part->partEntries()->paginate(25, ['*'], 'part-entries');
        $partExits = $part->partExits()->paginate(25, ['*'], 'part-exits');

        $breadcrumbs = $this->breadcrumbs->addCrumb($part->name, $part->show_url);

        // Chart for PartEntries and PartExits.
        $chart = Cache::remember(
            'Part.part-entries.part-exits.count.last_12months',
            600,
            function () use($part) {
                $partsEntriesData = [];
                $partsExitsData = [];
                $monthsData = [];
                $array = [];
                $months = 11;

                for ($i = 0; $i <= $months; $i++) {
                    $lastXMonthsText = Carbon::now()->subMonth()->translatedFormat('F Y');
                    $monthsData[$i] = ucfirst($lastXMonthsText);

                    $startXMonthsAgo = Carbon::now()->startOfMonth()->subMonthsNoOverflow($i)->toDateString();
                    $endXMonthsAgo = Carbon::now()->subMonthsNoOverflow($i)->endOfMonth()->toDateString();

                    $partsEntriesData[$i] = PartEntry::where('part_id', $part->getKey())
                        ->whereDate('created_at', '>=', $startXMonthsAgo)
                        ->whereDate('created_at', '<=', $endXMonthsAgo)
                        ->sum(DB::raw('number'));

                    $partsExitsData[$i] = PartExit::where('part_id', $part->getKey())
                        ->whereDate('created_at', '>=', $startXMonthsAgo)
                        ->whereDate('created_at', '<=', $endXMonthsAgo)
                        ->sum(DB::raw('number'));
                }
                $array['months'] = array_reverse($monthsData);
                $array['parts-entries'] = array_reverse($partsEntriesData);
                $array['parts-exits'] = array_reverse($partsExitsData);

                return $array;
            }
        );

        return view('part.show', compact('breadcrumbs', 'part', 'partEntries', 'partExits', 'materials', 'chart'));
    }
}

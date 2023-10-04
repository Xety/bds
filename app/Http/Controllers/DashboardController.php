<?php

namespace BDS\Http\Controllers;

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
        if (Auth::user()->hasRole('Saisonnier')) {
            return view('dashboard.saisonnier', compact($viewDatas));
        }

        return view('dashboard.index', compact($viewDatas));
    }
}

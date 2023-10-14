<?php

namespace BDS\Http\Controllers;

use BDS\Models\User;
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

        //ini_set('max_execution_time', 600);

        //$users = User::factory()->count(250)->create();
        /*foreach ($users as $user) {
            $user->save();
        }*/

        // If the user is a Saisonnier, render directly.
        if (Auth::user()->hasRole('Saisonnier')) {
            return view('dashboard.saisonnier', compact($viewDatas));
        }

        return view('dashboard.index', compact($viewDatas));
    }
}

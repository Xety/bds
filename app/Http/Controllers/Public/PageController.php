<?php

namespace BDS\Http\Controllers\Public;

use BDS\Http\Controllers\Controller;
use BDS\Models\Cleaning;
use BDS\Models\Incident;
use BDS\Models\Maintenance;
use BDS\Models\Part;
use BDS\Models\PartEntry;
use BDS\Models\PartExit;
use BDS\Models\Site;
use Carbon\Carbon;
use Illuminate\Contracts\Support\Renderable;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\DB;

class PageController extends Controller
{
    /**
     * Show the application dashboard.
     *
     * @return Renderable
     */
    public function index()
    {
        return view('public.page.index');
    }
}

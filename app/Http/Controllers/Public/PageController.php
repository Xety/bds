<?php

namespace BDS\Http\Controllers\Public;

use BDS\Http\Controllers\Controller;
use Illuminate\Contracts\Support\Renderable;

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

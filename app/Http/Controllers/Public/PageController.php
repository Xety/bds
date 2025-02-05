<?php

namespace BDS\Http\Controllers\Public;

use BDS\Http\Controllers\Controller;
use Illuminate\Contracts\Filesystem\FileNotFoundException;
use Illuminate\Contracts\Support\Renderable;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Storage;

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

    /**
     *  Get sites from json file.
     *
     * @throws FileNotFoundException
     */
    public function sites()
    {
        $sites = File::json(resource_path('js\sites.json'));

        return response()->json($sites);
    }
}

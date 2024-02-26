<?php

namespace BDS\Http\Controllers;

use BDS\Models\Calendar;
use Illuminate\View\View;

class CalendarController extends Controller
{
    /**
     * Show all the cleanings.
     *
     * @return View
     */
    public function index(): View
    {
        $this->authorize('viewAny', Calendar::class);

        $breadcrumbs = $this->breadcrumbs->addCrumb(
            '<svg class="h-5 w-5 mr-2" fill="currentColor" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 448 512"><!--! Font Awesome Free 6.5.1 by @fontawesome - https://fontawesome.com License - https://fontawesome.com/license/free (Icons: CC BY 4.0, Fonts: SIL OFL 1.1, Code: MIT License) Copyright 2023 Fonticons, Inc. --><path d="M96 32V64H48C21.5 64 0 85.5 0 112v48H448V112c0-26.5-21.5-48-48-48H352V32c0-17.7-14.3-32-32-32s-32 14.3-32 32V64H160V32c0-17.7-14.3-32-32-32S96 14.3 96 32zM448 192H0V464c0 26.5 21.5 48 48 48H400c26.5 0 48-21.5 48-48V192z"></path></svg>
                        Gérer les Calendriers',
            route('calendars.index')
        );

        return view('cleaning.index', compact('breadcrumbs'));
    }
}

<?php

namespace BDS\Http\Controllers;

use BDS\Models\Company;
use Illuminate\Contracts\Foundation\Application;
use Illuminate\Contracts\View\Factory;
use Illuminate\View\View;

class CompanyController extends Controller
{
    /**
     * Show all the suppliers.
     *
     * @return View
     */
    public function index(): View
    {
        $this->authorize('viewAny', Company::class);

        $breadcrumbs = $this->breadcrumbs->addCrumb(
            '<svg class="h-5 w-5 mr-2" fill="currentColor" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 512 512"><path d="M184 48H328c4.4 0 8 3.6 8 8V96H176V56c0-4.4 3.6-8 8-8zm-56 8V96H64C28.7 96 0 124.7 0 160v96H192 320 512V160c0-35.3-28.7-64-64-64H384V56c0-30.9-25.1-56-56-56H184c-30.9 0-56 25.1-56 56zM512 288H320v32c0 17.7-14.3 32-32 32H224c-17.7 0-32-14.3-32-32V288H0V416c0 35.3 28.7 64 64 64H448c35.3 0 64-28.7 64-64V288z"></path></svg>
                        Gérer les Entreprises',
            route('companies.index')
        );

        return view('company.index', compact('breadcrumbs'));
    }

    /**
     * Show a company.
     *
     * @param Company $company The company model retrieved by its ID.
     *
     * @return Application|Factory|\Illuminate\Contracts\View\View|\Illuminate\Foundation\Application
     */
    public function show(Company $company): Application|Factory|\Illuminate\Contracts\View\View|\Illuminate\Foundation\Application
    {
        $this->authorize('view', $company);

        $this->breadcrumbs->addCrumb(
            '<svg class="h-5 w-5 mr-2" fill="currentColor" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 640 512"><path d="M36.8 192H603.2c20.3 0 36.8-16.5 36.8-36.8c0-7.3-2.2-14.4-6.2-20.4L558.2 21.4C549.3 8 534.4 0 518.3 0H121.7c-16 0-31 8-39.9 21.4L6.2 134.7c-4 6.1-6.2 13.2-6.2 20.4C0 175.5 16.5 192 36.8 192zM64 224V384v80c0 26.5 21.5 48 48 48H336c26.5 0 48-21.5 48-48V384 224H320V384H128V224H64zm448 0V480c0 17.7 14.3 32 32 32s32-14.3 32-32V224H512z"></path></svg>
                        Gérer les Entreprises',
            route('companies.index')
        );
        $breadcrumbs = $this->breadcrumbs->addCrumb(
            $company->name,
            $company->show_url
        );

        $maintenances = $company->maintenances()->paginate(25, ['*'], 'parts');

        return view('company.show', compact('breadcrumbs', 'company', 'maintenances'));
    }
}

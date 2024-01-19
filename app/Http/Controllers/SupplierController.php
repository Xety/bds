<?php

namespace BDS\Http\Controllers;

use BDS\Models\Supplier;
use Illuminate\Contracts\Foundation\Application;
use Illuminate\Contracts\View\Factory;
use Illuminate\View\View;

class SupplierController extends Controller
{
    public function __construct()
    {
        parent::__construct();

        $this->breadcrumbs->addCrumb(
            '<svg class="h-5 w-5 mr-2" fill="currentColor" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 640 512"><path d="M36.8 192H603.2c20.3 0 36.8-16.5 36.8-36.8c0-7.3-2.2-14.4-6.2-20.4L558.2 21.4C549.3 8 534.4 0 518.3 0H121.7c-16 0-31 8-39.9 21.4L6.2 134.7c-4 6.1-6.2 13.2-6.2 20.4C0 175.5 16.5 192 36.8 192zM64 224V384v80c0 26.5 21.5 48 48 48H336c26.5 0 48-21.5 48-48V384 224H320V384H128V224H64zm448 0V480c0 17.7 14.3 32 32 32s32-14.3 32-32V224H512z"></path></svg>
                        Gérer les Fournisseurs',
            route('suppliers.index')
        );
    }

    /**
     * Show all the suppliers.
     *
     * @return View
     */
    public function index(): View
    {
        $this->authorize('viewAny', Supplier::class);

        $breadcrumbs = $this->breadcrumbs->addCrumb(
            '<svg class="h-5 w-5 mr-2" fill="currentColor" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 640 512"><path d="M36.8 192H603.2c20.3 0 36.8-16.5 36.8-36.8c0-7.3-2.2-14.4-6.2-20.4L558.2 21.4C549.3 8 534.4 0 518.3 0H121.7c-16 0-31 8-39.9 21.4L6.2 134.7c-4 6.1-6.2 13.2-6.2 20.4C0 175.5 16.5 192 36.8 192zM64 224V384v80c0 26.5 21.5 48 48 48H336c26.5 0 48-21.5 48-48V384 224H320V384H128V224H64zm448 0V480c0 17.7 14.3 32 32 32s32-14.3 32-32V224H512z"></path></svg>
                        Gérer les Fournisseurs',
            route('suppliers.index')
        );

        return view('supplier.index', compact('breadcrumbs'));
    }

    /**
     * Show a supplier.
     *
     * @param Supplier $supplier The supplier model retrieved by its ID.
     *
     * @return Application|Factory|\Illuminate\Contracts\View\View|\Illuminate\Foundation\Application
     */
    public function show(Supplier $supplier): Application|Factory|\Illuminate\Contracts\View\View|\Illuminate\Foundation\Application
    {
        $this->authorize('view', $supplier);

        $breadcrumbs = $this->breadcrumbs->addCrumb(
            $supplier->name,
            $supplier->show_url
        );

        $parts = $supplier->parts()->paginate(25, ['*'], 'parts');

        return view('supplier.show', compact('breadcrumbs', 'supplier', 'parts'));
    }
}

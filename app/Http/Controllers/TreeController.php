<?php
namespace BDS\Http\Controllers;

use BDS\Models\Site;
use Illuminate\Http\RedirectResponse;
use Illuminate\View\View;
use BDS\Models\Material;

class TreeController extends Controller
{

    /*public function __construct()
    {
        parent::__construct();

        $this->breadcrumbs->addCrumb(
            '<i class="fa-solid fa-microchip mr-2"></i> Gérer les Matériels',
            route('materials.index')
        );
    }*/

    /**
     * Show all zones with their materials for the current site.
     *
     * @return View
     */
    public function zonesWithMaterials(): View
    {
        $this->authorize('viewAny', Material::class);

        return view('tree.zones-with-materials', ['breadcrumbs' => $this->breadcrumbs]);
    }
}

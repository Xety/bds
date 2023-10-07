<?php

namespace BDS\Http\Controllers;

use BDS\Models\Site;
use Illuminate\Http\RedirectResponse;
use Illuminate\View\View;
use BDS\Models\Material;

class MaterialController extends Controller
{

    public function __construct()
    {
        parent::__construct();

        $this->breadcrumbs->addCrumb(
            '<i class="fa-solid fa-microchip mr-2"></i> Gérer les Matériels',
            route('materials.index')
        );
    }

    /**
     * Show all the materials.
     *
     * @return View
     */
    public function index(): View
    {
        $this->authorize('viewAny', Material::class);

        return view('material.index', ['breadcrumbs' => $this->breadcrumbs]);
    }

    /**
     * Show a material.
     *
     * @param Material $material The material.
     *
     * @return View|RedirectResponse
     */
    public function show(Material $material): View|RedirectResponse
    {
        $this->authorize('view', $material);

        $cleanings = $material->cleanings()->orderByDesc('created_at')->paginate(25, ['*'], 'cleanings');

        $breadcrumbs = $this->breadcrumbs->addCrumb($material->name, $material->show_url);

        return view(
            'material.show',
            compact('breadcrumbs', 'material', 'cleanings')
        );
    }

    public function arbre()
    {
        return view('material.arbre', [
            'breadcrumbs' => $this->breadcrumbs
        ]);
    }
}

<?php

namespace BDS\Http\Controllers\Selvah;

use BDS\Http\Controllers\Controller;
use BDS\Models\Selvah\CorrespondenceSheet;
use Illuminate\Http\RedirectResponse;
use Illuminate\View\View;

class CorrespondenceSheetController extends Controller
{
    public function __construct()
    {
        parent::__construct();

        $this->breadcrumbs->addCrumb(
            '<svg class="h-5 w-5 mr-2" fill="currentColor" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 384 512"><path d="M64 0C28.7 0 0 28.7 0 64V448c0 35.3 28.7 64 64 64H320c35.3 0 64-28.7 64-64V160H256c-17.7 0-32-14.3-32-32V0H64zM256 0V128H384L256 0zM80 64h64c8.8 0 16 7.2 16 16s-7.2 16-16 16H80c-8.8 0-16-7.2-16-16s7.2-16 16-16zm0 64h64c8.8 0 16 7.2 16 16s-7.2 16-16 16H80c-8.8 0-16-7.2-16-16s7.2-16 16-16zm16 96H288c17.7 0 32 14.3 32 32v64c0 17.7-14.3 32-32 32H96c-17.7 0-32-14.3-32-32V256c0-17.7 14.3-32 32-32zm0 32v64H288V256H96zM240 416h64c8.8 0 16 7.2 16 16s-7.2 16-16 16H240c-8.8 0-16-7.2-16-16s7.2-16 16-16z"></path></svg>
                        Gérer les Fiches de Correspondances',
            route('correspondence-sheets.index')
        );
    }

    /**
     * Show all activities.
     *
     * @return View
     */
    public function index(): View
    {
        $this->authorize('viewAny', CorrespondenceSheet::class);

        //$sheets = CorrespondenceSheet::with('user')->orderByDesc('created_at')->paginate(15);

        return view('selvah.correspondence-sheet.index', ['breadcrumbs' => $this->breadcrumbs]);
    }

    /**
     * Show a Sheet.
     *
     * @param CorrespondenceSheet $sheet The sheet model retrieved by its ID.
     *
     * @return View
     */
    public function show(CorrespondenceSheet $sheet): View
    {
        $this->authorize('view', $sheet);

        $breadcrumbs = $this->breadcrumbs->addCrumb(
            'Fiche de correspondance N° ' . $sheet->getKey(),
            $sheet->show_url
        );

        return view('selvah.correspondence-sheet.show', compact('breadcrumbs', 'sheet'));
    }

    /**
     * Created a new correspondence sheet.
     *
     * @return View
     */
    public function create(): View
    {
        $this->authorize('create', CorrespondenceSheet::class);

        $breadcrumbs = $this->breadcrumbs->addCrumb(
            'Créer une fiche de correspondance',
            route('correspondence-sheets.create')
        );

        return view('selvah.correspondence-sheet.create', compact('breadcrumbs'));
    }
}

<?php

namespace BDS\Http\Controllers;

use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Routing\Controller as BaseController;
use Xety\Breadcrumbs\Breadcrumbs;

class Controller extends BaseController
{
    use AuthorizesRequests;
    use ValidatesRequests;

    protected Breadcrumbs $breadcrumbs;

    /**
     * Constructor.
     */
    public function __construct()
    {
        $this->breadcrumbs = new Breadcrumbs([], [
            // Whether to enable or not the `data-position` attribute.
            'position' => false,
            // The divider symbol between the crumbs or `null` to disable it.
            'divider' => '<i class="fa-solid fa-chevron-right mx-2"></i>',
            // The DOM-Element used to generate the divider element.
            'dividerElement' => 'li',
            // Classes applied to the item `dividerElement` element.
            'dividerElementClasses' => [
                'inline-flex items-center'
            ],
            // The DOM-Element used to generate the container element.
            'listRootElement' => 'nav',
            // Classes applied to the main `listElement` container element.
            'listRootElementClasses' => [
                'flex shadow-md border p-3 px-5 rounded-lg truncate bg-base-100 dark:bg-base-300 border-gray-200 dark:border-gray-700'
            ],
            // The DOM-Element used to generate the container element.
            'listElement' => 'ol',
            // Classes applied to the main `listElement` container element.
            'listElementClasses' => [
                'inline-flex items-center space-x-1 md:space-x-3 overflow-x-auto'
            ],
            // The DOM-Element used to generate the list item.
            'listItemElement' => 'li',
            // Classes applied to the list item `listItemElement` element.
            'listItemElementClasses' => [
                'inline-flex items-center'
            ],
            // The DOM-Element used to generate the list item.
            'listItemLinkElement' => 'a',
            // Classes applied to the list item `listItemElement` element.
            'listItemLinkElementClasses' => [
                'text-sm inline-flex items-center link-hover'
            ],
            // The DOM-Element used to generate the active list item.
            'listActiveElement' => 'li',
            // Classes applied to the active item `listActiveElement` element.
            'listActiveElementClasses' => [
                'text-sm inline-flex items-center ml-1 font-medium text-gray-400 dark:text-gray-500'
            ]
        ]);
        $this->breadcrumbs->addCrumb(
            '<i class="fa-solid fa-gauge mr-2"></i> Tableau de bord',
            route('dashboard.index')
        );
    }
}

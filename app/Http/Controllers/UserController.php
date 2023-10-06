<?php

namespace BDS\Http\Controllers;

use BDS\Models\Site;
use Illuminate\Database\Query\JoinClause;
use Illuminate\Support\Facades\DB;
use Illuminate\View\View;
use BDS\Models\User;

class UserController extends Controller
{
    public function __construct()
    {
        parent::__construct();

        $this->breadcrumbs->addCrumb(
            '<i class="fa-solid fa-users mr-2"></i> Gérer les Utilisateurs',
            route('users.index')
        );
    }

    /**
     * Show the search page.
     *
     * @return \Illuminate\View\View
     */
    public function index(): View
    {
        $this->authorize('viewAny', User::class);

        $breadcrumbs = $this->breadcrumbs->addCrumb(
            '<i class="fa-solid fa-users mr-2"></i> Gérer les Utilisateurs',
            route('users.index')
        );

        return view('user.index', ['breadcrumbs' => $this->breadcrumbs]);
    }

    public function show()
    {

    }

    public function permissions()
    {
        /*$user = auth()->user()->load([
            'roles_all' => function ($query) {
                $query->leftJoin('sites', function ($join) {
                    $join->on(config('permission.table_names.roles').'.site_id', '=', 'sites.id');
                });
            }
        ]);*/

        /*$sites = DB::table('sites')->join(['users' => function($query) {
                $query->leftJoin('roles', function ($join) {
                    $join->on('model_has_roles.site_id', '=', 'sites.id');
                });
            }])
            /*->with('users.rolesAll', function($query) {
                $query->where('model_has_roles.site_id', '=', 'sites.id');
                //->with('users.rolesAll.permissions');
            })*/
            //->with('users.roles.permissions')
            //->get();

        /**
         * $this->belongsToMany(EloquentRoleModelStub::class, 'role_user', 'user_id', 'role_id');
         * }
         *
         * User::query()->joinRelation('roles as users_roles,roles');
         * // SQL: select * from "users"
         * inner join "role_user" as "users_roles" on "users_roles"."user_id" = "users"."id"
         * inner join "roles" on "roles"."id" = "users_roles"."role_id"
         */

        $sites = DB::table('sites')
            ->join('site_user as sitesUsers', 'latest_posts', function (JoinClause $join) {
                $join->on('users.id', '=', 'site_user.user_id')
            ->join('site_user as user', function($join){
                $join->on('users.id', '=', 'contacts.user_id')
            })

            ->get();

        /*$users = DB::table('users')
            ->join('roles', function ($join) {
                $join->on('model_has_roles.model_id', '=', 'users.id');
            })
            ->get();*/
       dd($users);

        dd($sites);

        return view('user.permissions', [
            'sites' => $sites,
            'breadcrumbs' => $this->breadcrumbs
        ]);
    }
}

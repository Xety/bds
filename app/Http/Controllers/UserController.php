<?php

namespace BDS\Http\Controllers;

use BDS\Models\Site;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Query\JoinClause;
use Illuminate\Support\Facades\DB;
use Illuminate\View\View;
use BDS\Models\User;
use Spatie\Permission\Models\Role;
use Spatie\Permission\PermissionRegistrar;

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
        /*$users = Site::with('users')->get();
        $sites = $users->load(['users.rolesAll', function ($query) {
                $query->wherePivot('site_id', 'sites.id');
                    /*->where(function ($q) {
                        $q->whereNull('roles.site_id')
                            ->orWhere('roles.site_id', 'sites.id');
                    });*/
            //}]);
        //DB::enableQueryLog();
        //$users = User::with('rolesSites', 'rolesSites.rolesAll')->get();
        //dd(DB::getQueryLog());
        //dd($users);

        /*$sites = Site::query()
            ->with(['users', 'users.rolesAll'])
        ->get();*/

        /*$sites = DB::table("roles")
            ->leftJoin("model_has_roles", function($join){
                $join->on("roles.id", "=", "model_has_roles.role_id");
            })
            ->select("roles.*", "model_has_roles.model_id as pivot_model_id", "model_has_roles.role_id as pivot_role_id", "model_has_roles.model_type as pivot_model_type")
            ->where("model_has_roles.model_id", "=", 1)
            ->where("model_has_roles.model_type", "=", User::class)
            ->where("model_has_roles.site_id", "=", 3)
            ->where(DB::raw("(roles.site_id is null or roles.site_id = 3)"))
            ->get();

        dd($sites);*/


        $sites = Site::with(['users'])->get();

        $newSites = [];

        foreach ($sites as $site) {
            $newUsers = [];
            foreach ($site->users as $user) {
                $roles = Role::with('permissions')->whereHas('users', function ($query) use ($user, $site) {
                    $query->where(config('permission.column_names.model_morph_key'), $user->getKey())
                        ->where(PermissionRegistrar::$teamsKey, $site->getKey());
                })->get();

                $user->roles = $roles;
                $newUsers[] = $user;
            }

            $site->users = $newUsers;
            $newUsers = [];

            $newSites[] = $site;
        }

        $sites = $newSites;

        //dd($sites);




        //dd($sites);

        /*$sites = Site::with('users');

        $sites = DB::table('sites')
            ->join(['users' => function($query) {
                $query->leftJoin('roles', function ($join) {
                    $join->on('model_has_roles.site_id', '=', 'sites.id');
                });
            }])
            ->with('users.rolesAll', function($query) {
                $query->where('model_has_roles.site_id', '=', 'sites.id');
                //->with('users.rolesAll.permissions');
            })
            //->with('users.roles.permissions')
            ->get();*/

        /**
         * $this->belongsToMany(EloquentRoleModelStub::class, 'role_user', 'user_id', 'role_id');
         * }
         *
         * User::query()->joinRelation('roles as users_roles,roles');
         * // SQL: select * from "users"
         * inner join "role_user" as "users_roles" on "users_roles"."user_id" = "users"."id"
         * inner join "roles" on "roles"."id" = "users_roles"."role_id"
         */

        /*$sites = DB::table('sites')
            ->join('site_user', 'site_user.site_id', '=', 'sites.id')
            ->join('users', 'users.id', '=', 'site_user.user_id')

            ->get();*/

        /*$users = DB::table('users')
            ->join('roles', function ($join) {
                $join->on('model_has_roles.model_id', '=', 'users.id');
            })
            ->get();*/
       //dd($sites);

       // dd($sites);

        return view('user.permissions', [
            'sites' => $sites,
            'breadcrumbs' => $this->breadcrumbs
        ]);
    }
}

<?php


namespace BDS\Http\Middleware;

use Closure;
use Illuminate\Http\Request;

class SetCurrentSitePermission
{
    /**
     * Handle an incoming request.
     *
     * @param Request $request
     * @param Closure $next
     * @return mixed
     */
    public function handle(Request $request, Closure $next): mixed
    {
        if (!empty(auth()->user())) {
            app(\Spatie\Permission\PermissionRegistrar::class)->setPermissionsTeamId((int) session('current_site_id'));

            // unset cached model relations so new team relations will get reloaded
            auth()->user()->unsetRelation('roles');
            auth()->user()->unsetRelation('permissions');
        }

        return $next($request);
    }
}

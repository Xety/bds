<?php

namespace BDS\Http\Middleware;

use Closure;
use Illuminate\Http\Request;

class SetCurrentSite
{
    /**
     * Handle an incoming request.
     *
     * @param  Request  $request
     * @param  Closure  $next
     * @return mixed
     */
    public function handle(Request $request, Closure $next): mixed
    {
        if (!empty(auth()->user())) {
            session()->put([
                'current_site_id' => auth()->user()->current_site_id == null ? 4 : auth()->user()->current_site_id
            ]);
        }

        return $next($request);
    }
}

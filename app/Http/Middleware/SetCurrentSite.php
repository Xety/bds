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
     *
     * @return mixed
     */
    public function handle(Request $request, Closure $next): mixed
    {
        if (!empty(auth()->user())) {
            $siteId = auth()->user()->current_site_id;

            if (is_null(auth()->user()->current_site_id)) {
                $siteId = auth()->user()->getFirstSiteId();
            }

            session()->put([
                'current_site_id' => (int) $siteId
            ]);
            // Set the site id for the settings too.
            //settings()->setSiteId($siteId);
        }

        return $next($request);
    }
}

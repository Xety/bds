<?php

namespace BDS\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\App;
use BDS\Models\Session;
use BDS\Models\Repositories\SessionRepository;

class SessionLogs
{
    /**
     * Handle an incoming request.
     *
     * @param Request $request
     * @param Closure $next
     *
     * @return mixed
     */
    public function handle(Request $request, Closure $next): mixed
    {
        if (!$request->user() || App::environment() == 'testing' || $request->path() === 'api/notifications') {
            return $next($request);
        }

        $session = Session::where('id', $request->session()->getId())->first();

        if (is_null($session)) {
            return $next($request);
        }

        $data = [
            'url' => $request->path(),
            'method' => $request->method()
        ];

        if (is_null($session->created_at)) {
            $data += [
                'created_at' => date('Y-m-d G:i:s'),
            ];
        }

        SessionRepository::update($data, $session);

        return $next($request);
    }
}

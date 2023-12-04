<?php

namespace BDS\Exceptions;

use Illuminate\Auth\Access\AuthorizationException;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Foundation\Exceptions\Handler as ExceptionHandler;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Response;
use Illuminate\Session\TokenMismatchException;
use Throwable;

class Handler extends ExceptionHandler
{
    /**
     * The list of the inputs that are never flashed to the session on validation exceptions.
     *
     * @var array<int, string>
     */
    protected $dontFlash = [
        'current_password',
        'password',
        'password_confirmation',
    ];

    /**
     * Render an exception into an HTTP response.
     *
     * @param $request
     * @param Throwable $e
     * @return JsonResponse|RedirectResponse|Response|\Symfony\Component\HttpFoundation\Response
     * @throws Throwable
     */
    public function render($request, Throwable $e)
    {
        if ($e instanceof ModelNotFoundException) {
            return redirect(route('dashboard.index'))->with('toasts', [[
                'type' => 'error',
                'duration' => 4000,
                'message' =>"Cette donnée n'existe pas ou a été supprimée !"
            ]]);
        }

        return parent::render($request, $e);
    }

    /**
     * Register the exception handling callbacks for the application.
     */
    public function register(): void
    {
        $this->renderable(function (\Exception $e) {
            // Error 419 csrf token expiration error
            if ($e->getPrevious() instanceof TokenMismatchException) {
                return back()->error("Vous avez mis trop de temps à valider le formulaire ! C'est l'heure de prendre un café !");
            };

            // Error 403 Access unauthorized
            if ($e->getPrevious() instanceof AuthorizationException) {
                return redirect(route('dashboard.index'))->error("Vous n'avez pas l'autorisation d'accéder à cette page !");
            }
        });
    }
}

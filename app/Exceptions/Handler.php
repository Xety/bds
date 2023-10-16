<?php

namespace BDS\Exceptions;

use Illuminate\Auth\Access\AuthorizationException;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Foundation\Exceptions\Handler as ExceptionHandler;
use Illuminate\Session\TokenMismatchException;

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
                return back()->error("Vous n'avez pas l'autorisation d'accéder à cette page !");
            }

        /*if ($e instanceof ModelNotFoundException) {
                return redirect()->back()->with('danger', "Cet enregistrement n'existe pas ou a été supprimé !");
            }*/
        });
    }
}

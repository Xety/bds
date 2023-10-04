<?php

namespace BDS\Http\Controllers\Auth;

use Illuminate\Foundation\Auth\AuthenticatesUsers;
use Illuminate\Http\Request;
use Illuminate\View\View;
use BDS\Http\Controllers\Controller;
use BDS\Models\User;
use BDS\Providers\RouteServiceProvider;

class LoginController extends Controller
{
    public $layout = 'layouts.default';

    /*
    |--------------------------------------------------------------------------
    | Login Controller
    |--------------------------------------------------------------------------
    |
    | This controller handles authenticating users for the application and
    | redirecting them to your home screen. The controller uses a trait
    | to conveniently provide its functionality to your applications.
    |
    */
    use AuthenticatesUsers;

    /**
     * Where to redirect users after login.
     *
     * @var string
     */
    protected string $redirectTo = RouteServiceProvider::HOME;

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct();

        $this->middleware('guest')->except('logout');
    }

    /**
     * Show the application's login form.
     *
     * @return View
     */
    public function showLoginForm(): View
    {
        return view('auth.login');
    }

    /**
     * The user has been authenticated.
     *
     * @param Request $request The request object.
     * @param User $user The user that has been logged in.
     *
     * @return void
     */
    protected function authenticated(Request $request, User $user)
    {

        $request->session()->flash(
            'success',
            'Bon retour <strong>' . e($user->full_name) . '</strong> ! Vous êtes connecté avec succès !'
        );
    }

    /**
     * The user has logged out of the application.
     *
     * @param Request $request
     *
     * @return mixed
     */
    protected function loggedOut(Request $request)
    {
        return redirect(route('auth.login'))
            ->with('success', 'Vous êtes déconnecté, à bientôt !');
    }
}

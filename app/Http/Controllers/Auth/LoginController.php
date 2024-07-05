<?php

namespace BDS\Http\Controllers\Auth;

use BDS\Http\Controllers\Controller;
use BDS\Models\User;
use Illuminate\Foundation\Auth\AuthenticatesUsers;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Validation\ValidationException;
use Illuminate\View\View;
use Masmerise\Toaster\Toaster;
use Symfony\Component\HttpFoundation\Response;

class LoginController extends Controller
{
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
    protected string $redirectTo = '/';

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
     * Handle a login request to the application.
     *
     * @param Request $request
     *
     * @return RedirectResponse|Response|JsonResponse
     *
     * @throws ValidationException
     */
    public function login(Request $request)
    {
        $this->validateLogin($request);

        // Check if the login is not disabled, if yes check if the user is allowed to bypass it.
        $user = User::where($this->username(), $request->{$this->username()})->first();
        // Set the Team id to 0 since bypass login is assigned to the team 0 (trick)
        // The team id will be changed after login anyway with the middleware to $user->getFirstSiteId()
        setPermissionsTeamId(0);
        if (!settings('app_login_enabled') && !$user->hasPermissionTo('bypass login')) {
            return redirect()
                ->route('auth.login')
                ->error('Le système de connexion est actuellement désactivé, veuillez ressayer plus tard.');
        }

        // Check if the user has setup his password
        if (!$user?->hasSetupPassword()) {
            return redirect()
                ->route('auth.password.resend.request')
                ->error('Vous n\'avez pas encore configuré votre mot de passe !');
        }

        // If the class is using the ThrottlesLogins trait, we can automatically throttle
        // the login attempts for this application. We'll key this by the username and
        // the IP address of the client making these requests into this application.
        if (method_exists($this, 'hasTooManyLoginAttempts') &&
            $this->hasTooManyLoginAttempts($request)) {
            $this->fireLockoutEvent($request);

            return $this->sendLockoutResponse($request);
        }

        if ($this->attemptLogin($request)) {
            if ($request->hasSession()) {
                $request->session()->put('auth.password_confirmed_at', time());
            }

            return $this->sendLoginResponse($request);
        }

        // If the login attempt was unsuccessful we will increment the number of attempts
        // to login and redirect the user back to the login form. Of course, when this
        // user surpasses their maximum number of attempts they will get locked out.
        $this->incrementLoginAttempts($request);

        return $this->sendFailedLoginResponse($request);
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
        Toaster::success("Bon retour <b>{$user->full_name}</b> ! Vous êtes connecté avec succès !");
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
            ->success('Vous êtes déconnecté, à bientôt !');
    }
}

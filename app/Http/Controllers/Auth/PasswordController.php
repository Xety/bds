<?php

namespace BDS\Http\Controllers\Auth;

use Illuminate\Auth\Access\AuthorizationException;
use Illuminate\Foundation\Auth\RedirectsUsers;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Validation\Rules;
use Illuminate\View\View;
use BDS\Http\Controllers\Controller;
use BDS\Models\User;
use BDS\Models\Validators\PasswordResetValidator;
use BDS\Providers\RouteServiceProvider;

class PasswordController extends Controller
{
    use RedirectsUsers;

    /**
     * Where to redirect users after login.
     *
     * @var string
     */
    protected string $redirectTo = RouteServiceProvider::HOME;

    /**
     * Create a new controller instance.
     */
    public function __construct()
    {
        parent::__construct();

        $this->middleware('guest');
        $this->middleware('signed')->only('showSetupForm');
        $this->middleware('throttle:6,1')->only('showSetupForm');
    }

    /**
     * Display the password setup view for the given token.
     *
     * @param Request $request
     *
     * @return View|RedirectResponse
     */
    public function showSetupForm(Request $request)
    {
        $user = User::findOrFail($request->route('id'));

        if ($user->hasSetupPassword()) {
            return redirect()
                ->route('auth.login')
                ->error('Vous avez déjà configuré votre compte');
        }

        return $request->user() && $request->user()->hasSetupPassword()
            ? redirect($this->redirectPath())
            : view('auth.passwords.setup')->with(
                ['hash' => $request->hash, 'id' => $request->id]
            );
    }

    /**
     * Set up the user password.
     *
     * @param Request $request
     *
     * @return RedirectResponse
     *
     * @throws AuthorizationException
     */
    public function setup(Request $request)
    {
        $user = User::findOrFail($request->route('id'));

        if ($user->hasSetupPassword()) {
            return redirect($this->redirectPath());
        }

        $request->validate($this->rules());

        if (!$user->markPasswordAsSetup($request)) {
            return back()->error('Une erreur est survenue lors de la sauvegarde de votre mot de passe.');
        }

        // Login the user
        Auth::login($user);

        return redirect(route('dashboard.index'))
                ->success('Votre mot de passe a bien été créé et vous êtes maintenant connecté à votre compte !');
    }

    /**
     * Get the password setup validation rules.
     *
     * @return array
     */
    protected function rules()
    {
        return [
            'password' => ['required', 'confirmed', Rules\Password::defaults()],
        ];
    }

    /**
     * Display the form to request a password reset link.
     *
     * @return View
     */
    public function showResendRequestForm(): View
    {
        return view('auth.passwords.resend');
    }

    /**
     * Resend the email password set up notification.
     *
     * @param Request $request
     * @return RedirectResponse
     */
    public function resend(Request $request)
    {
        PasswordResetValidator::validateEmail($request->all())->validate();

        $user = User::where('email', $request->input('email'))->first();

        if ($user->hasSetupPassword()) {
            return redirect()
                ->route('auth.login')
                ->error('Ce compte est déjà configuré !');
        }

        $user->sendEmailRegisteredNotification();

        return redirect()
            ->route('auth.login')
            ->success('Nous vous avons renvoyé votre lien de configuration de votre mot de passe par e-mail !');
    }
}

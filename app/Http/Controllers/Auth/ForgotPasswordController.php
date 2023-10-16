<?php
namespace BDS\Http\Controllers\Auth;

use Illuminate\Foundation\Auth\SendsPasswordResetEmails;
use Illuminate\Http\Request;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\Password;
use Illuminate\View\View;
use BDS\Http\Controllers\Controller;
use BDS\Models\Validators\PasswordResetValidator;

class ForgotPasswordController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | Password Reset Controller
    |--------------------------------------------------------------------------
    |
    | This controller is responsible for handling password reset emails and
    | includes a trait which assists in sending these notifications from
    | your application to your users. Feel free to explore this trait.
    |
    */
    use SendsPasswordResetEmails;

    /**
     * Create a new controller instance.
     */
    public function __construct()
    {
        parent::__construct();

        $this->middleware('guest');
    }

    /**
     * Display the form to request a password reset link.
     *
     * @return View
     */
    public function showLinkRequestForm(): View
    {
        return view('auth.passwords.email');
    }

    /**
     * Send a reset link to the given user.
     *
     * @param Request $request
     *
     * @return RedirectResponse
     */
    public function sendResetLinkEmail(Request $request): RedirectResponse
    {
        PasswordResetValidator::validateEmail($request->all())->validate();

        // We will send the password reset link to this user. Once we have attempted
        // to send the link, we will examine the response then see the message we
        // need to show to the user. Finally, we'll send out a proper response.
        $response = $this->broker()->sendResetLink(
            $this->credentials($request)
        );

        return $response == Password::RESET_LINK_SENT
            ? $this->sendResetLinkResponse($response)
            : $this->sendResetLinkFailedResponse($request, $response);
    }

    /**
     * Get the response for a successful password reset link.
     *
     * @param string $response
     *
     * @return RedirectResponse
     */
    protected function sendResetLinkResponse(string $response): RedirectResponse
    {
        return redirect()
            ->route('auth.login')
            ->success('Nous vous avons envoyé votre lien de réinitialisation de mot de passe par e-mail !');
    }
}

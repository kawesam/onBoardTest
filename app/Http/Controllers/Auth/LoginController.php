<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Foundation\Auth\AuthenticatesUsers;
use Illuminate\Http\Request;
use Ntavelis\AuthEmail\EmailService;

class LoginController extends Controller {

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
     * @var string
     */
    protected $redirectTo = '/home';

    /**
     * Property that holds instance of Email class
     * @var EmailService
     */
    protected $EmailService;

    /**
     * @param EmailService $EmailService
     */
    public function __construct(EmailService $EmailService)
    {
        $this->middleware('guest', ['except' => 'logout']);
        $this->EmailService = $EmailService;
    }

    /**
     * In every login attempt this function is triggered from the
     * AuthenticatesUsers Trait, if he is not Authenticated properly
     * the flash message is displayed on the screen.
     *
     * @param Request $request
     * @param $user
     * @return \Illuminate\Http\RedirectResponse
     */
    public function authenticated(Request $request, $user)
    {
        if (!$user->activated) {
            $this->EmailService->sendActivationMail($user);
            auth()->logout();

            return back()->with('warning', trans('authEmail.confirm'));
        }

        return redirect()->intended($this->redirectPath());
    }
}

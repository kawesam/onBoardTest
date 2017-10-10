<?php

namespace App\Http\Controllers\Auth;

use App\User;
use App\Onboarding_User;
use App\Http\Controllers\Controller;
use Illuminate\Foundation\Auth\RegistersUsers;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Ntavelis\AuthEmail\EmailService;

/**
 * Class RegisterController
 * @package App\Http\Controllers\Auth
 */
class RegisterController extends Controller {

    /*
    |--------------------------------------------------------------------------
    | Register Controller
    |--------------------------------------------------------------------------
    |
    | This controller handles the registration of new users as well as their
    | validation and creation. By default this controller uses a trait to
    | provide this functionality without requiring any additional code.
    |
    */

    use RegistersUsers;

    /**
     * Where to redirect users after registration.
     *
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
        $this->EmailService = $EmailService;
    }

    /**
     * Register the user when they filled the form.
     *
     * @param Request $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function register(Request $request)
    {
        $validator = $this->validator($request->all());

        if ($validator->fails()) {
            $this->throwValidationException(
                $request, $validator
            );
        }

        $user = $this->create($request->all());

        $user_onboard = Onboarding_User::create([
            'user_id' => $user->id,
            'onboarding_percentage' =>0,
            'count_applications'  =>0,
            'count_accepted_applications' => 0
        ]);

        $this->EmailService->sendActivationMail($user);

        return redirect('/login')->with('status', trans('authEmail.mailSend'));
    }

    /**
     * Get a validator for an incoming registration request.
     *
     * @param  array $data
     * @return \Illuminate\Contracts\Validation\Validator
     */
    protected function validator(array $data)
    {
        return Validator::make($data, [
            'name'     => 'required|alpha_spaces|max:100',
            'email'    => 'required|email|max:100|unique:users',
            'password' => 'required|min:6|confirmed',
        ]);
    }

    /**
     * Create a new user instance after a valid registration.
     *
     * @param  array $data
     * @return User
     */
    protected function create(array $data)
    {
        return User::create([
            'name'     => $data['name'],
            'email'    => $data['email'],
            'password' => bcrypt($data['password']),
        ]);
    }

    /**
     * Activate User from link with token.
     *
     * @param $token
     * @return \Illuminate\Http\RedirectResponse|\Illuminate\Routing\Redirector
     */
    public function activateUser($token)
    {
        if ($user = $this->EmailService->activateUser($token)) {
            auth()->login($user);

            return redirect($this->redirectPath());
        }
        abort(404);
    }
}
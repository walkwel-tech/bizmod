<?php

namespace App\Http\Controllers\Auth;

use App\User;
use App\Http\Controllers\Controller;
use App\Providers\RouteServiceProvider;
use Illuminate\Http\Request;
use Illuminate\Foundation\Auth\AuthenticatesUsers;
use Illuminate\Validation\ValidationException;
use WalkwelTech\Otp\OtpFacade as Otp;


class OtpController extends Controller
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
    protected $redirectTo = RouteServiceProvider::HOME;

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('guest')->except('logout');
    }


    /**
     * Show the application's login form.
     *
     * @return \Illuminate\View\View
     */
    public function showLoginForm()
    {
        return view('auth.login', [
            'loginRoute' => route('login.otp.request'),
            'message' => __('Or Login with OTP'),
            'actionText' => __('Request OTP'),
            'noPass' => true,
        ]);
    }


    /**
     * Show the application's login form.
     *
     * @return \Illuminate\View\View
     */
    public function showLoginWithOTPForm(Request $request)
    {
        return view('auth.login', [
            'loginRoute' => route('login.otp'),
            'message' => __('Login'),
            'actionText' => __('Login with OTP'),
            'email' => $request->input($this->username()),
            'noPass' => false
        ]);
    }

    public function requestOTP (Request $request)
    {
        $request->validate([
            $this->username() => 'required|exists:users,email'
        ]);

        $user = User::where('email', $request->input($this->username()))->first();
        throw_unless($user, ValidationException::withMessages([
            'email' => 'Invalid Credentials'
        ]));

        if (! method_exists($user, 'notify')) {
            throw new \UnexpectedValueException(
                'The otp owner should be an instance of notifiable or implement the notify method.'
            );
        }

        $token = Otp::create($user, config('otp.length', 4));

        $user->notify($token->toNotification());

        return view('auth.login', [
            'loginRoute' => route('login.otp'),
            'message' => __('Login'),
            'actionText' => __('Login with OTP'),
            'email' => $request->input($this->username()),
            'noPass' => false
        ]);
    }


    /**
     * Attempt to log the user into the application.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return bool
     */
    protected function attemptLogin(Request $request)
    {
        $user = User::where('email', $request->input($this->username()))->first();
        throw_unless($user, ValidationException::withMessages([
            'email' => 'Invalid Credentials'
        ]));

        $token = Otp::retrieveByPlainText($user->id, $request->input('password'));
        throw_unless($token, ValidationException::withMessages([
            'email' => 'Invalid Credentials'
        ]));

        $res   = Otp::check($user, $token);

        if ($res) {
            $this->guard()->login($user);

            $token->invalidate();

            return true;
        } else {
            return false;
        }
    }
}

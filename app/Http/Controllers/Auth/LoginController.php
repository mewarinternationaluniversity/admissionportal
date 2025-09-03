<?php

namespace App\Http\Controllers\Auth;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Providers\RouteServiceProvider;
use Illuminate\Foundation\Auth\AuthenticatesUsers;
use Illuminate\Support\Facades\Auth;
use App\Models\User;

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
     * Validate the user login request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return void
     *
     * @throws \Illuminate\Validation\ValidationException
     */
    protected function validateLogin(Request $request)
    {
        if (request('loginby') == 'student') {
            $request->validate([
                $this->username() => 'required|string',
                'password' => 'required|date_format:d/m/Y', // Expecting DOB as password
            ]);
        } else {
            $request->validate([
                $this->username() => 'required|string',
                'password' => 'required|string',
            ]);
        }
    }

    /**
     * Get the login username to be used by the controller.
     *
     * @return string
     */
    public function username()
    {
        if (request('loginby') == 'student') {
            return 'matriculation_no';
        }
        return 'email';
    }

    /**
     * Attempt to log the user into the application.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return bool
     */
    protected function attemptLogin(Request $request)
    {
        if (request('loginby') == 'student') {
            // The password is the dob in the format dd/mm/yyyy, no need to reformat
            $dob = $request->password;

            // Log the credentials being used for login
            \Log::info('Attempting login with:', [
                'matriculation_no' => $request->matriculation_no,
                'dob' => $dob
            ]);

            // Find the user by matriculation_no and dob (stored as dd/mm/yyyy)
            $user = User::where('matriculation_no', $request->matriculation_no)
                        ->where('dob', $dob)
                        ->first();

            if ($user) {
                \Log::info('User found:', ['user_id' => $user->id, 'name' => $user->name]);
                
                // Log the user in manually
                Auth::login($user);
                return true;
            } else {
                \Log::error('Login failed. These credentials do not match any records.');
                return false;
            }
        }

        // For non-student login, use the default Auth attempt
        return \Auth::attempt($this->credentials($request));
    }

    /**
     * Get the login credentials and format them for the request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array
     */
    protected function credentials(Request $request)
    {
        if (request('loginby') == 'student') {
            // The dob is passed as-is since it's already in dd/mm/yyyy format in the DB
            return [
                'matriculation_no' => $request->matriculation_no,
                'dob' => $request->password, // Date of birth
            ];
        }
        return $request->only($this->username(), 'password');
    }
}


<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Providers\RouteServiceProvider;
use App\Models\User;
use Illuminate\Foundation\Auth\RegistersUsers;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use Spatie\Permission\Models\Role;

class RegisterController extends Controller
{
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
    protected $redirectTo = RouteServiceProvider::HOME;

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('guest');
    }

    /**
     * Get a validator for an incoming registration request.
     *
     * @param  array  $data
     * @return \Illuminate\Contracts\Validation\Validator
     */
    protected function validator(array $data)
    {
        return Validator::make($data, [
            'name'              => ['required', 'string', 'max:255'],
            'email'             => ['required', 'string', 'email', 'max:255', 'unique:users,email'],            
            'matriculation_no'  => ['required', 'string', 'unique:users,matriculation_no'],
            'dob'               => ['required', 'date_format:d/m/Y'],
            'nd_institute'      => ['required', 'numeric'],
            'nd_course'         => ['required', 'numeric'],
            'phone'             => ['required', 'numeric']
        ]);
    }

    /**
     * Create a new user instance after a valid registration.
     *
     * @param  array  $data
     * @return \App\Models\User
     */
    protected function create(array $data)
    {
        $user = User::create([
            'name'                  => $data['name'],
            'email'                 => $data['email'],
            'matriculation_no'      => $data['matriculation_no'],
            'dob'                   => $data['dob'],
            'nd_institute'          => $data['nd_institute'],
            'nd_course'             => $data['nd_course'],
            'phone'                 => $data['phone'],
            'password'              => Hash::make($data['dob']),
        ]);

        $assingrole = Role::findOrCreate('student');
        $user->assignRole($assingrole);

        return $user;
    }
}

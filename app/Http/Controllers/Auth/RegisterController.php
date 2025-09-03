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
        'matriculation_no'  => ['required', 'string'],
        'dob'               => ['required', 'date_format:d/m/Y', function ($attribute, $value, $fail) use ($data) {
            // Check if the matriculation number and date of birth already exist together
            $exists = \DB::table('users')
                ->where('matriculation_no', $data['matriculation_no'])
                ->where('dob', $value)
                ->exists();

            if ($exists) {
                $fail('The matriculation number and date of birth combination already exists.');
            }
        }],
        'nd_institute'      => ['required', 'numeric'],
        'nd_course'         => ['required', 'numeric'],
        'phone'             => ['required', 'numeric'],
        'gender'            => ['required', 'string'],
        'yearofgraduation'  => ['required', 'numeric', 'digits:4'],
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
            'gender'                => $data['gender'],
            'yearofgraduation'      => $data['yearofgraduation'],
            'password'              => Hash::make($data['dob']),
        ]);

        $assingrole = Role::findOrCreate('student');
        $user->assignRole($assingrole);

        return $user;
    }
}

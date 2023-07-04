<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class HomeController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function index()
    {
        //Roles
        $user = Auth::user();

        if ($user->hasRole('admin')) {
            return view('pages.dashboard.admin', compact('user'));
        }

        if ($user->hasRole('manager')) {
            return view('pages.dashboard.manager', compact('user'));
        }

        if ($user->hasRole('student')) {
            return view('pages.dashboard.student', compact('user'));
        }        
    }
}

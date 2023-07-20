<?php

namespace App\Http\Controllers;

use App\Models\Application;
use App\Models\Institute;
use App\Models\Course;
use App\Models\Payment;
use App\Models\User;
use Illuminate\Http\Request;
use App\Enums\InstituteTypeEnum;
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
    public function index(Request $request)
    {
        //Roles
        $user = Auth::user();

        // if ($request->query('session')) {
        //     $applications = Application::query()
        //         ->where('session_id', $request->query('session'))
        //         ->with('course', 'student', 'institute', 'payment');
        // } else {
        //     $applications = Application::query()->with('course', 'student', 'institute', 'payment');
        // }

        if ($user->hasRole('admin')) {

            if ($request->query('session')) {
                $data = [
                    'all_applications'      => Application::where('session_id', $request->query('session'))->count(),
                    'no_students'           => User::role('student')->count(),
                    'institutes'            => Institute::count(),
                    'clearedpayments'       => Payment::where('session_id', $request->query('session'))->count(),
                    'totalpayments'         => Payment::where('session_id', $request->query('session'))->sum('amount'),
                    'pendingpayments'       => Application::where('session_id', $request->query('session'))->whereNotIn('status', [
                        'APPROVED',
                        'ACCEPTED',
                        'REJECTED',
                    ])->count()
                ];

            } else {
                $data = [
                    'all_applications'      => Application::count(),
                    'no_students'           => User::role('student')->count(),
                    'institutes'            => Institute::count(),
                    'clearedpayments'       => Payment::count(),
                    'totalpayments'         => Payment::sum('amount'),
                    'pendingpayments'       => Application::whereNotIn('status', [
                        'APPROVED',
                        'REJECTED',
                    ])->count()
                ];
            }

            //dd($data);

            return view('pages.dashboard.admin', compact('user', 'data'));
        }

        if ($user->hasRole('manager')) {
            //Bachelors institute
            if ($user->institute->type == InstituteTypeEnum::BACHELORS()) {                
                if ($request->query('session')) {
                    $courses = Institute::find($user->institute->id)
                                    ->courses()
                                    ->where('institutes_courses.session_id', $request->query('session'))
                                    ->get();
                }else {
                    $courses = Institute::find($user->institute->id)->courses()->get();
                }

                return view('pages.dashboard.manager-b', compact('courses'));
            }

            //Diploma institute
            if ($user->institute->type == InstituteTypeEnum::DIPLOMA()) {

                if ($request->query('session')) {
                    $data = [
                        'courses'      => Course::where('type', 'DIPLOMA')->count(),
                        'no_students'  => User::role('student')->count(),
                        'institutes'   => Institute::where('type', 'DIPLOMA')->count(),
                    ];
    
                } else {
                    $data = [
                        'courses'      => Course::where('type', 'DIPLOMA')->count(),
                        'no_students'  => User::role('student')->count(),
                        'institutes'   => Institute::where('type', 'DIPLOMA')->count(),
                    ];
                }
    
                //dd($data);


                return view('pages.dashboard.manager-d', compact('data'));
            }


            
        }

        if ($user->hasRole('student')) {
            return view('pages.dashboard.student', compact('user'));
        }        
    }
}

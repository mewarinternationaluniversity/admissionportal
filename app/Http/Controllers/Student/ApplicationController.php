<?php

namespace App\Http\Controllers\Student;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\Application;
use App\Models\Course;
use App\Models\Institute;
use Illuminate\Support\Facades\Auth;
use DataTables;
use Illuminate\Support\Facades\Validator;

class ApplicationController extends Controller
{
    public function index(Request $request)
    {
        if ($request->ajax()) {

            $student = Auth::user();

            $applications = Application::query()->with('course', 'student', 'institute')
                                ->where('student_id', $student->id);

            return DataTables::eloquent($applications)
                ->addColumn('download', function($row){
                    $btn = '<a class="btn btn-xs btn-success">Download</a>';
                    return $btn;
                })
                ->removeColumn('created_at')
                ->editColumn('application_status', function($row) {
                    return $row->status;
                })
                ->editColumn('institute_name', function($row) {
                    return $row->institute->title;
                })
                ->editColumn('course_name', function($row) {
                    return $row->course->title;
                })
                ->editColumn('payment_status', function($row) {
                    return 'Pending';
                })
                ->rawColumns(['download', 'institute_name', 'course_name', 'payment_status'])
                ->toJson();
        }

        return view('applications.student.index');

    }

    public function startApplication()
    {
        $courses = Course::with('institutes')->paginate(8);
        return view('applications.student.start', compact('courses'));
    }

    // public function startApplication()
    // {
    //     $user = Auth::user();

    //     $courses = Course::with('mappings')->where('id', $user->nd_course)->first();

    //     $courses = $courses->mappings()->get();

    //     return view('applications.student.start', compact('courses'));
    // }

    public function stepTwo($courseid)
    {
        $course = Course::with('institutes')->find($courseid);

        $institutes = $course->institutes()->paginate(8);
        
        return view('applications.student.step2', compact('institutes', 'course'));
    }

    public function stepThree($courseid, $instituteid)
    {        
        $course = Course::with('institutes')->find($courseid);
        $institute = Institute::with('courses')->find($instituteid);
        
        return view('applications.student.step3', compact('institute', 'course'));
    }

    public function finalApplication($courseid, $instituteid, $pay)
    {        
        $course = Course::with('institutes')->find($courseid);
        $institute = Institute::with('courses')->find($instituteid);

        $user = Auth::user();

        //$pivot = $course->institutes->pivot;

        $create = Application::create([
            'course_id'         => $course->id,
            'institute_id'      => $institute->id,
            'student_id'        => $user->id
        ]);

        return redirect()->route('applications.student');
    }
}

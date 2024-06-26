<?php

namespace App\Http\Controllers\Student;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\Application;
use App\Models\Course;
use App\Models\Institute;
use Illuminate\Support\Facades\Auth;
use DataTables;
use Paystack;
use App\Enums\PaymentGatewayEnum;
use Illuminate\Support\Facades\Validator;

class ApplicationController extends Controller
{
    public function index(Request $request)
    {
        if ($request->ajax()) {

            $student = Auth::user();

            $applications = Application::query()->with('course', 'student', 'institute', 'payment')
                                ->where('student_id', $student->id);

            return DataTables::eloquent($applications)
                ->addColumn('download', function($row){
                    switch ($row->status) {
                        case 'SUBMITTED':
                            $paymentgateway = config('mewar.payment_gateway') ?? 'stripe';

                            if ($paymentgateway == 'stripe') {
                                return '<a href="'.route('applications.student.stripe', $row->id).'" class="btn btn-xs btn-primary">Pay form fee</a>';
                            } elseif($paymentgateway == 'paystack') {
                                $form = '<form method="POST" action="'. route('applications.student.pay') .'" accept-charset="UTF-8" role="form">';
                                $form .= '<input type="hidden" name="id" value="'.$row->id.'">';
                                $form .= '<input type="hidden" name="_token" value="'. csrf_token() .'">';
                                $form .= '<button type="submit" class="btn btn-xs btn-primary">Pay form fee</button>';
                                $form .= '</form>';
                                return $form;
                            } else {
                                return '<button type="button" class="btn btn-xs btn-danger">No payment method set</button>';
                            }
                        case 'PROCESSING':
                            return '<span class="badge badge-outline-warning rounded-pill">Processing</span>';
                        case 'APPROVED':
                            $paymentgateway = config('mewar.payment_gateway') ?? 'stripe';

                            if (!$row->payment) {
                                if ($paymentgateway == 'stripe') {
                                    return '<a href="'.route('applications.student.stripe', $row->id).'" class="btn btn-xs btn-primary">Pay form fee</a>';
                                } elseif($paymentgateway == 'paystack') {
                                    $form = '<form method="POST" action="'. route('applications.student.pay') .'" accept-charset="UTF-8" role="form">';
                                    $form .= '<input type="hidden" name="id" value="'.$row->id.'">';
                                    $form .= '<input type="hidden" name="_token" value="'. csrf_token() .'">';
                                    $form .= '<button type="submit" class="btn btn-xs btn-primary">Pay form fee</button>';
                                    $form .= '</form>';
                                    return $form;
                                } else {
                                    return '<button type="button" class="btn btn-xs btn-danger">No payment method set</button>';
                                }
                            }
                            
                            return '<a href="'. route('applications.student.print.admission', $row->id) .'" class="btn btn-xs btn-success">Download</a>';
                        case 'REJECTED':
                            return '<span class="badge badge-outline-danger rounded-pill">Rejected</span>';
                        default:
                            return '<span class="badge badge-outline-danger rounded-pill">No letter</span>';
                    }                    
                })
                ->editColumn('application_status', function($row) {
                    switch ($row->status) {
                        case 'SUBMITTED':
                            return '<span class="badge badge-outline-warning rounded-pill fs-8 fw-bolder">'.$row->status.'</span>';
                        case 'PROCESSING':
                            return '<span class="badge badge-outline-primary rounded-pill fs-8 fw-bolder">'.$row->status.'</span>';
                        case 'APPROVED':
                            return '<span class="badge badge-outline-success rounded-pill fs-8 fw-bolder">'.$row->status.'</span>';
                        case 'REJECTED':
                            return '<span class="badge badge-outline-danger rounded-pill fs-8 fw-bolder">'.$row->status.'</span>';
                        default:
                            return '<span class="badge badge-outline-warning rounded-pill fs-8 fw-bolder">'.$row->status.'</span>';
                    }
                })
                ->editColumn('institute_name', function($row) {
                    return $row->institute->title;
                })
                ->editColumn('course_name', function($row) {
                    return $row->course->title;
                })
                ->editColumn('payment_status', function($row) {
                    if ($row->payment) {
                        return '<span class="badge badge-outline-success rounded-pill fs-8 fw-bolder">Paid</span>';
                    }
                    return '<span class="badge badge-outline-danger rounded-pill">Not paid</span>';
                })
                ->rawColumns(['download', 'institute_name', 'application_status', 'course_name', 'payment_status'])
                ->toJson();
        }

        return view('applications.student.index');

    }

    public function startApplication()
    {
        $user = Auth::user();

        $courses = Course::with('mappings')->where('id', $user->nd_course)->first();

        $courses = $courses->mappings()->paginate(8);

        return view('applications.student.start', compact('courses'));
    }

    public function stepTwo(Request $request, $courseid)
    {
        $course = Course::with('institutes')->find($courseid);

        $session = getCurrentSession()->id ?? null;

        if (!$session) {
            abort(404);
        }

        if ($request->query('institute')) {
            $institutes = $course->institutes()
                ->where('title', 'like', '%' . $request->query('institute') . '%')
                ->where('institutes_courses.session_id', $session)
                ->paginate(8);
        } else {
            $institutes = $course->institutes()->where('institutes_courses.session_id', $session)->paginate(8);
        }        
        
        return view('applications.student.step2', compact('institutes', 'course'));
    }

    public function stepThree($courseid, $instituteid)
    {
        //Diploma to bachelor mapping
        $student = Auth::user();
        if (!$student->nd_course) {
            return redirect()->route('applications.student')->with('error', 'Seems you are not assigned to nd course');
        }

        $course = Course::with('institutes')->find($student->nd_course);

        $mappedcourse = $course->bmappings()->where('courses.id', $courseid)->get();

        if ($mappedcourse->isEmpty()) {
            return redirect()->route('applications.student')->with('error', 'Course not mapped');
        }

        $course = Course::with('institutes')->find($courseid);
        $institute = Institute::with('courses')->find($instituteid);

        $courseinstitute = $course->institutes()->where('institutes.id', $institute->id)->first();

        if (!$courseinstitute) {
            return redirect()->route('applications.student')->with('error', 'The course for the institute does not exist');
        }

        return view('applications.student.step3', compact('institute', 'course', 'courseinstitute'));
    }

    public function finalApplication($courseid, $instituteid, $pay)
    {        
        $course = Course::with('institutes')->find($courseid);
        $institute = Institute::with('courses')->find($instituteid);

        $courseinstitute = $course->institutes()->where('institutes.id', $institute->id)->first();

        if (!$courseinstitute) {
            return redirect()->route('applications.student')->with('error', 'The course for the institute does not exist');
        }

        $user = Auth::user();

        //Check if user has already registered
        $isapplied = Application::where('student_id', $user->id)
                        ->where('course_id', $course->id)
                        ->where('institute_id', $institute->id)->first();

        if ($isapplied) {
            return redirect()->route('applications.student')->with('error', 'You have already applied for this course');
        }

        Application::create([
            'session_id'        => getCurrentSession()->id ?? null,
            'course_id'         => $course->id,
            'institute_id'      => $institute->id,
            'student_id'        => $user->id
        ]);

        return redirect()->route('applications.student')->with('success', 'Your Application was submitted provisionally, so please clear form fees to confirm application submission');
    }

    public function printAdmission(Application $application)
    {
        $fees = $application->institute->courses()
            ->where('institutes_courses.course_id', $application->course_id)
            ->first();
        return view('applications.student.admissionletter', compact('application', 'fees'));
    }
}

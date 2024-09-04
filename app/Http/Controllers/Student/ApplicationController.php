<?php

namespace App\Http\Controllers\Student;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\Application;
use App\Models\Course;
use App\Models\InstituteSession;
use App\Models\Institute;
use Illuminate\Support\Facades\Auth;
use DataTables;
use Paystack;
use App\Enums\PaymentGatewayEnum;
use Illuminate\Support\Facades\Validator;    
use Illuminate\Pagination\LengthAwarePaginator;

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
        
        // Fetch the course and its mappings
        $course = Course::with('mappings')->where('id', $user->nd_course)->first();
        $courses = $course->mappings()->paginate(8);
        
        foreach ($courses as $course) {
            // Define session ID variable if needed
            $session = getCurrentSession()->id ?? null;
            
            // Retrieve institutes based on conditions
            $institutesQuery1 = $course->institutes()->whereHas('session')->distinct()->get();
            // $institutesQuery2 = $course->institutes()->where('institutes_courses.session_id', $session)->get();
            
            // Merge and get unique institutes
            // $mergedInstitutes = $institutesQuery1->merge($institutesQuery2)->unique('id');
            
            // Count of merged institutes
            $course->institute_count = $institutesQuery1->count();
        }
        
        // Pass the courses with the institute count to the view
        return view('applications.student.start', compact('courses'));
    }
    
    


    public function stepTwo(Request $request, $courseid)
    {
        $course = Course::with('institutes')->find($courseid);
        $session = getCurrentSession()->id ?? null;
    
        if (!$course) {
            return response()->json(['error' => 'Course not found'], 404);
        }
    
        // First query: institutes with a related session
        $institutesQuery1 = $course->institutes()->whereHas('session')->distinct();
    
        // Second query: institutes with a specific session ID
        // $institutesQuery2 = $course->institutes()->where('institutes_courses.session_id', $session)->get();

    
        // Merge the results with priority for the first query
        // $mergedInstitutes = $institutesQuery1->merge($institutesQuery2)->unique('id');
                
    
        // Manually paginate the merged collection
        // $perPage = 8;
        // $currentPage = LengthAwarePaginator::resolveCurrentPage();
        // $currentItems = $mergedInstitutes->slice(($currentPage - 1) * $perPage, $perPage)->values();
        // $institutes = new LengthAwarePaginator($currentItems, $mergedInstitutes->count(), $perPage);
    
        // $institutes->setPath($request->url());

        $institutes = $institutesQuery1->paginate(8);
    
        return view('applications.student.step2', compact('institutes', 'course', 'session'));
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

        $createapplication = $this->finalApplicationPayNow($courseid, $instituteid);

        // Skips and go straight to payments
        $paymentgateway = config('mewar.payment_gateway') ?? 'stripe';

        $paylink = '<button type="button" class="btn btn-danger waves-effect waves-light">No payment method set</button>';

        if ($paymentgateway == 'stripe') {
            $paylink = '<a href="'.route('applications.student.stripe', $createapplication->id).'" class="btn btn-xs btn-primary">Pay form fee</a>';
        } elseif($paymentgateway == 'paystack') {
            $paylink = '<form method="POST" action="'. route('applications.student.pay') .'" accept-charset="UTF-8" role="form">';
            $paylink .= '<input type="hidden" name="id" value="'.$createapplication->id.'">';
            $paylink .= '<input type="hidden" name="_token" value="'. csrf_token() .'">';
            $paylink .= '<button type="submit" class="btn btn-success waves-effect waves-light"><span class="btn-label"><i class="mdi mdi-account-cash"></i></span> Pay form fee</button>';
            $paylink .= '</form>';
        } else {
            $paylink = '<button type="button" class="btn btn-danger waves-effect waves-light">No payment method set</button>';
        }
        
        return view('applications.student.step3', compact('institute', 'course', 'courseinstitute', 'paylink')); 
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

        //Go directly to pay

        //Go to list of applications
        return redirect()->route('applications.student')->with('success', 'Your Application was submitted provisionally, so please clear form fees to confirm application submission');
    }

    private function finalApplicationPayNow($courseid, $instituteid)
    {
        $course = Course::with('institutes')->find($courseid);
        $institute = Institute::with('courses')->find($instituteid);

        $courseinstitute = $course->institutes()->where('institutes.id', $institute->id)->first();

        if (!$courseinstitute) {
            throw new \Exception('The course for the institute does not exist');            
        }

        $user = Auth::user();

        //Check if user has already registered
        $isapplied = Application::where('student_id', $user->id)
                        ->where('course_id', $course->id)
                        ->where('institute_id', $institute->id)->first();

        if ($isapplied) {
            throw new \Exception('You have already applied for this course');
        }

        return Application::create([
            'session_id'        => getCurrentSession()->id ?? null,
            'course_id'         => $course->id,
            'institute_id'      => $institute->id,
            'student_id'        => $user->id
        ]);

    }

    public function printAdmission(Application $application)
    {
        $fees = $application->institute->courses()
            ->where('institutes_courses.course_id', $application->course_id)
            ->first();
        return view('applications.student.admissionletter', compact('application', 'fees'));
    }
}

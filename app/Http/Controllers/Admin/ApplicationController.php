<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\Application;
use App\Models\Course;
use App\Models\Institute;
use Illuminate\Support\Facades\Auth;
use DataTables;
use Paystack;
use App\Enums\ApplicationStatusEnum;
use App\Models\Fee;
use Illuminate\Support\Facades\Validator;

class ApplicationController extends Controller
{
    public function index(Request $request)
    {
        if ($request->ajax()) {

            if ($request->query('session')) {
                $applications = Application::query()
                    ->where('session_id', $request->query('session'))
                    ->with('course', 'student', 'institute', 'payment');
            } else {
                $applications = Application::query()->with('course', 'student', 'institute', 'payment');
            }

            return DataTables::eloquent($applications)
                ->addColumn('action', function($row){
                    return '<a href="'.route('applications.admin.edit', $row->id).'" class="btn btn-xs btn-primary">View</a>';                
                })
                ->addColumn('download', function($row){
                    switch ($row->status) {
                        case 'SUBMITTED':
                            return '<span class="badge badge-outline-warning rounded-pill">Waiting for payment</span>';
                        case 'PROCESSING':
                            return '<span class="badge badge-outline-warning rounded-pill">Processing</span>';
                        case 'APPROVED':
                            return '<a href="'. route('applications.admin.print.admission', $row->id) .'" class="btn btn-xs btn-success">Download</a>';
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
                ->editColumn('payment_status', function($row) {
                    if ($row->payment) {
                        return '<span class="badge badge-outline-success rounded-pill fs-8 fw-bolder">Paid</span>';
                    }
                    return '<span class="badge badge-outline-danger rounded-pill">Not paid</span>';
                })
                ->rawColumns(['download', 'application_status', 'payment_status', 'action'])
                ->toJson();
        }

        return view('applications.admin.index');
    }

    public function manager(Request $request)
    {
        $userId = Auth::user()->institute_id;

        if ($request->ajax()) {

            if ($request->query('session')) {
                $applications = Application::query()
                    ->where('session_id', $request->query('session'))
                    ->where('institute_id', $userId)
                    ->with('course', 'student', 'institute', 'payment');
            } else {
                $applications = Application::query()
                    ->where('institute_id', $userId)
                    ->with('course', 'student', 'institute', 'payment');
            }

            return DataTables::eloquent($applications)
                ->addColumn('action', function($row){
                    return '<a href="'.route('applications.admin.edit', $row->id).'" class="btn btn-xs btn-primary">View</a>';                
                })
                ->addColumn('download', function($row){
                    switch ($row->status) {
                        case 'SUBMITTED':
                            return '<span class="badge badge-outline-warning rounded-pill">Waiting for payment</span>';
                        case 'PROCESSING':
                            return '<span class="badge badge-outline-warning rounded-pill">Processing</span>';
                        case 'APPROVED':
                            return '<a href="'. route('applications.admin.print.admission', $row->id) .'" class="btn btn-xs btn-success">Download</a>';
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
                ->editColumn('payment_status', function($row) {
                    if ($row->payment) {
                        return '<span class="badge badge-outline-success rounded-pill fs-8 fw-bolder">Paid</span>';
                    }
                    return '<span class="badge badge-outline-danger rounded-pill">Not paid</span>';
                })
                ->rawColumns(['download', 'application_status', 'payment_status', 'action'])
                ->toJson();
        }

        return view('applications.manager.index');
    }


    public function approved(Request $request)
    {
        $userId = Auth::user()->institute_id;

        if ($request->ajax()) {

            if ($request->query('session')) {
                $applications = Application::query()
                    ->where('session_id', $request->query('session'))
                    ->where('institute_id', $userId)
                    ->where('status', 'APPROVED')
                    ->with('course', 'student', 'institute', 'payment');
            } else {
                $applications = Application::query()
                    ->where('institute_id', $userId)
                    ->where('status', 'APPROVED')
                    ->with('course', 'student', 'institute', 'payment');
            }

            return DataTables::eloquent($applications)
                ->addColumn('action', function($row){
                    return '<a href="'.route('applications.admin.edit', $row->id).'" class="btn btn-xs btn-primary">View</a>';                
                })
                ->addColumn('download', function($row){
                    switch ($row->status) {
                        case 'SUBMITTED':
                            return '<span class="badge badge-outline-warning rounded-pill">Waiting for payment</span>';
                        case 'PROCESSING':
                            return '<span class="badge badge-outline-warning rounded-pill">Processing</span>';
                        case 'APPROVED':
                            return '<a href="'. route('applications.admin.print.admission', $row->id) .'" class="btn btn-xs btn-success">Download</a>';
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
                ->editColumn('payment_status', function($row) {
                    if ($row->payment) {
                        return '<span class="badge badge-outline-success rounded-pill fs-8 fw-bolder">Paid</span>';
                    }
                    return '<span class="badge badge-outline-danger rounded-pill">Not paid</span>';
                })
                ->rawColumns(['download', 'application_status', 'payment_status', 'action'])
                ->toJson();
        }

        return view('applications.manager.approved');
    }

    public function edit(Application $application)
    {
        return view('applications.admin.student', compact('application'));
    }

    public function changestatus(Application $application, $status)
    {
        enforceReadOnly();

        //check available seats
        $getallapplications = Application::where('session_id', $application->session_id)
                ->where('course_id', $application->course_id)
                ->where('status', ApplicationStatusEnum::APPROVED())
                ->where('institute_id', $application->institute_id)->count();        

        $institutecourses = \DB::table('institutes_courses')
            ->where('session_id', $application->session_id)
            ->where('course_id', $application->course_id)
            ->where('institute_id', $application->institute_id)->first();            

        $seatsavailable = 0;

        if ($institutecourses && isset($institutecourses->seats)) {
            $seatsavailable = $institutecourses->seats;
        }

        if ($application->status == ApplicationStatusEnum::APPROVED()) {

            return redirect()->route('applications.admin.edit', $application->id)
                        ->with('error', 'The application has already been approved. No more action is required');
        }

        if ($application->status == ApplicationStatusEnum::REJECTED()) {
            return redirect()->route('applications.admin.edit', $application->id)
                        ->with('error', 'The application has already been rejected. No more action is required');
        }        

        switch ($status) {
            case 'approve':

                if ($getallapplications >= $seatsavailable) {
                    return redirect()->route('applications.admin.edit', $application->id)
                                ->with('error', 'There are no more available seats');
                }
                
                $savestatus = ApplicationStatusEnum::APPROVED();
                break;

            case 'reject':
                $savestatus = ApplicationStatusEnum::REJECTED();
                break;               
            
            default:
                $savestatus = ApplicationStatusEnum::REJECTED();
                break;
        }

        $application->status = $savestatus;
        $application->save();

        //When an application has been approved, create fee collect
        if ($status == 'approve') {
            //check if it exist if not create
            $savefee = Fee::firstOrCreate(
                [
                    'application_id'  => $application->id
                ],
                [
                    'course_id'  => $application->course_id,
                    'session_id'  => $application->session_id,
                    'institute_id'  => $application->institute_id,
                    'student_id'  => $application->student_id,
                ]
            );
        }

        return redirect()->route('applications.admin.edit', $application->id)
                        ->with('success', 'Application status changed successfully');

    }

    public function printAdmission(Application $application)
    {
        $fees = $application->institute->courses()
            ->where('institutes_courses.course_id', $application->course_id)
            //->where('institutes_courses.session_id', getCurrentSession()->id)
            ->first();        
        return view('applications.student.admissionletter', compact('application', 'fees'));
    }
}

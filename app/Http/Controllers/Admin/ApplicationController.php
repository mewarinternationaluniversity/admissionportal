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
use Barryvdh\DomPDF\Facade\Pdf;
use App\Enums\ApplicationStatusEnum;
use Illuminate\Support\Facades\Validator;

class ApplicationController extends Controller
{
    public function index(Request $request)
    {
        if ($request->ajax()) {

            $applications = Application::query()->with('course', 'student', 'institute', 'payment');

            return DataTables::eloquent($applications)
                ->addColumn('action', function($row){
                    return '<a href="'.route('applications.admin.edit', $row->id).'" class="btn btn-xs btn-primary">View</a>';                
                })
                ->addColumn('download', function($row){
                    switch ($row->status) {
                        case 'SUBMITTED':
                            return '<span class="badge badge-outline-warning rounded-pill">Wait to process</span>';
                        case 'PROCESSING':
                            return '<span class="badge badge-outline-warning rounded-pill">Processing</span>';
                        case 'APPROVED':
                            return '<a class="btn btn-xs btn-primary">Pay form fee</a>';
                        case 'ACCEPTED':
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
                        case 'PENDING':
                            return '<span class="badge badge-outline-secondary rounded-pill fs-8 fw-bolder">'.$row->status.'</span>';
                        case 'PROCESSING':
                            return '<span class="badge badge-outline-primary rounded-pill fs-8 fw-bolder">'.$row->status.'</span>';
                        case 'ACCEPTED':
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
                ->rawColumns(['download', 'institute_name', 'application_status', 'course_name', 'payment_status', 'action'])
                ->toJson();
        }

        return view('applications.admin.index');
    }

    public function approved(Request $request)
    {
        if ($request->ajax()) {

            $applications = Application::query()->with('course', 'student', 'institute', 'payment')->where('status', 'APPROVED');

            return DataTables::eloquent($applications)
                ->addColumn('action', function($row){
                    return '<a href="'.route('applications.admin.edit', $row->id).'" class="btn btn-xs btn-primary">View</a>';                
                })
                ->addColumn('download', function($row){
                    switch ($row->status) {
                        case 'SUBMITTED':
                            return '<span class="badge badge-outline-warning rounded-pill">Wait to process</span>';
                        case 'PROCESSING':
                            return '<span class="badge badge-outline-warning rounded-pill">Processing</span>';
                        case 'APPROVED':
                            return '<a class="btn btn-xs btn-primary">Pay form fee</a>';
                        case 'ACCEPTED':
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
                        case 'PENDING':
                            return '<span class="badge badge-outline-secondary rounded-pill fs-8 fw-bolder">'.$row->status.'</span>';
                        case 'PROCESSING':
                            return '<span class="badge badge-outline-primary rounded-pill fs-8 fw-bolder">'.$row->status.'</span>';
                        case 'ACCEPTED':
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
                ->rawColumns(['download', 'institute_name', 'application_status', 'course_name', 'payment_status', 'action'])
                ->toJson();
        }

        return view('applications.admin.index');
    }

    public function edit(Application $application)
    {
        return view('applications.admin.student', compact('application'));
    }

    public function changestatus(Application $application, $status)
    {
        if ($application->status == ApplicationStatusEnum::ACCEPTED()) {
            return redirect()->route('applications.admin.edit', $application->id)
                        ->with('error', 'The application has already been accepted. No more action is required');
        }

        switch ($status) {
            case 'approve':
                $savestatus = ApplicationStatusEnum::APPROVED();
                break;

            case 'reject':
                $savestatus = ApplicationStatusEnum::REJECTED();
                break;               
            
            default:
                $savestatus = ApplicationStatusEnum::PROCESSING();
                break;
        }

        $application->status = $savestatus;
        $application->save();

        return redirect()->route('applications.admin.edit', $application->id)
                        ->with('success', 'Application status changed successfully');

    }

    public function printAdmission(Application $application)
    {
        //return view('applications.student.admissionletter', compact('application'));

        $pdf = Pdf::loadView('applications.student.admissionletter', [
            'application'=>$application
        ]);
        return $pdf->download('admission.pdf');
    }
}

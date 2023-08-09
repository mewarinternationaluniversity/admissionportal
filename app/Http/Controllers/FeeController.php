<?php

namespace App\Http\Controllers;

use App\Models\Fee;
use Illuminate\Http\Request;
use App\Models\Application;
use App\Models\Course;
use App\Models\Institute;
use Illuminate\Support\Facades\Auth;
use DataTables;
use Paystack;
use App\Enums\ApplicationStatusEnum;
use Illuminate\Support\Facades\Validator;

class FeeController extends Controller
{
    public function index(Request $request)
    {
        if ($request->ajax()) {

            if ($request->query('session')) {
                $fees = Fee::query()
                    ->where('session_id', $request->query('session'))
                    ->with('course', 'student', 'institute', 'payments', 'application');
            } else {
                $fees = Fee::query()->with('course', 'student', 'institute', 'payments', 'application');
            }

            return DataTables::eloquent($fees)
                ->addColumn('action', function($row){
                    return '<a href="'.route('fees.admin.edit', $row->id).'" class="btn btn-xs btn-primary">View</a>';                
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
                            return '<span class="badge badge-outline-danger rounded-pill">Not Available</span>';
                    }
                })
                ->addColumn('feepayments', function($row){
                    if (count($row->payments) != 0) {
                        $pay = '<ul>';
                        $pay .= '<li> - <a href="#">gfdgfdgfdgdffdsfdsfdsfdsfdsf</a>';
                        $pay .= '</li>';
                        $pay .= '<li> - <a href="#">gfdgfdgfdgdffdsfdsfdsfdsfdsf</a>';
                        $pay .= '</li>';
                        $pay .= '<li> - <a href="#">gfdgfdgfdgdffdsfdsfdsfdsfdsf</a>';
                        $pay .= '</li>';
                        $pay .= '<li> - <a href="#">gfdgfdgfdgdffdsfdsfdsfdsfdsf</a>';
                        $pay .= '</li>';
                        $pay .= '</ul>';
                        return $pay;
                    }
                    return '<span class="badge badge-outline-danger rounded-pill">No payment yet</span>';
                })

                ->rawColumns(['download', 'feepayments', 'action'])
                ->toJson();
        }

        return view('fees.admin.index');
    }

    public function student(Request $request)
    {
        if ($request->ajax()) {

            if ($request->query('session')) {
                $fees = Fee::query()
                    ->where('session_id', $request->query('session'))
                    ->with('course', 'student', 'institute', 'payments', 'application');
            } else {
                $fees = Fee::query()->with('course', 'student', 'institute', 'payments', 'application');
            }

            return DataTables::eloquent($fees)
                ->addColumn('action', function($row){
                    return '<a href="'.route('fees.admin.edit', $row->id).'" class="btn btn-xs btn-primary">View</a>';                
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
                            return '<span class="badge badge-outline-danger rounded-pill">Not Available</span>';
                    }
                })
                ->addColumn('feepayments', function($row){
                    if (count($row->payments) != 0) {
                        $pay = '<ul>';
                        $pay .= '<li> - <a href="#">gfdgfdgfdgdffdsfdsfdsfdsfdsf</a>';
                        $pay .= '</li>';
                        $pay .= '</ul>';
                        return $pay;
                    }
                    return '<span class="badge badge-outline-danger rounded-pill">No payment yet</span>';
                })

                ->rawColumns(['download', 'feepayments', 'action'])
                ->toJson();
        }

        return view('fees.student.index');
    }
}

<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\Application;
use App\Models\Payment;
use Illuminate\Support\Facades\Auth;
use DataTables;
use Paystack;

class PaymentController extends Controller
{
    public function index(Request $request)
    {
        if ($request->ajax()) {
            
            if ($request->query('session')) {
                $payments = Payment::query()
                    ->where('session_id', $request->query('session'))
                    ->with('application', 'student');
            } else {
                $payments = Payment::query()->with('application', 'student');
            }

            return DataTables::eloquent($payments)
                ->orderColumn('studentname', function ($query, $row) {
                    $query->orderBy('id', $row->id);
                })                
                ->orderColumn('amount', function ($query, $row) {
                    $query->orderBy('amount', $row);
                })
                ->editColumn('amount', function($row) {
                    return $row->currency . ' ' . $row->amount;
                })
                ->addColumn('download', function($row){
                    return '<a href="'. route('download.receipt', $row->id) .'" class="btn btn-xs btn-success">Download receipt</a>';
                })
                ->rawColumns(['download'])
                ->toJson();
        }

        return view('payments.admin.index');
    }
    
    public function manager(Request $request)
    {

        $userId = Auth::user()->institute_id;

        if ($request->ajax()) {            
            
            if ($request->query('session')) {
                $payments = Payment::query()
                    ->where('session_id', $request->query('session'))
                    ->with('application', 'student');
            } else {
                $payments = Payment::query()->with('application', 'student')->whereHas('application', function($q) use($userId) {
                    $q->where('institute_id', $userId);
                });
            }

            return DataTables::eloquent($payments)
                ->orderColumn('studentname', function ($query, $row) {
                    $query->orderBy('id', $row->id);
                })
                ->editColumn('studentname', function($row) {
                    return $row->student->name;
                })
                ->orderColumn('amount', function ($query, $row) {
                    $query->orderBy('amount', $row);
                })
                ->editColumn('amount', function($row) {
                    return $row->currency . ' ' . $row->amount;
                })
                ->addColumn('download', function($row){
                    return '<a href="'. route('download.receipt', $row->id) .'" class="btn btn-xs btn-success">Download receipt</a>';
                })
                ->rawColumns(['studentname', 'download'])
                ->toJson();
        }

        return view('payments.manager.index');
    }
}

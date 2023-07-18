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
                ->editColumn('studentname', function($row) {
                    return $row->student->name;
                })
                ->orderColumn('amount', function ($query, $row) {
                    $query->orderBy('amount', $row);
                })
                ->editColumn('amount', function($row) {
                    return $row->currency . ' ' . $row->amount;
                })
                ->rawColumns(['studentname'])
                ->toJson();
        }

        return view('payments.admin.index');

    }    
}

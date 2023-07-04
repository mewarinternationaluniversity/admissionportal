<?php

namespace App\Http\Controllers\Student;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\Application;
use App\Models\Payment;
use Illuminate\Support\Facades\Auth;
use DataTables;

class PaymentController extends Controller
{
    public function index(Request $request)
    {
        if ($request->ajax()) {

            $student = Auth::user();            

            $payments = Payment::query()->with('application', 'student')
                                ->where('student_id', $student->id);

            return DataTables::eloquent($payments)->toJson();
        }

        return view('payments.student.index');

    }
}

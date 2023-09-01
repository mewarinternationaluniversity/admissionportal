<?php

namespace App\Http\Controllers;

use App\Models\Fee;
use Illuminate\Http\Request;
use DataTables;
use Illuminate\Support\Facades\Validator;
use App\Http\Controllers\Controller;
use App\Enums\PaymentGatewayEnum;
use App\Models\Feepayment;
use Illuminate\Support\Facades\Auth;
use Stripe\Stripe;
use Stripe\Charge;

class FeeController extends Controller
{
    public function index(Request $request)
    {
        if ($request->ajax()) {

            $user = Auth::user();

            if ($user->hasRole('manager')) {

                if ($request->query('session')) {
                    $fees = Fee::query()
                        ->where('institute_id', $user->institute_id)
                        ->where('session_id', $request->query('session'))
                        ->with('course', 'student', 'institute', 'payments', 'application');
                } else {
                    $fees = Fee::query()
                        ->where('institute_id', $user->institute_id)
                        ->with('course', 'student', 'institute', 'payments', 'application');
                }

            }else{
                if ($request->query('session')) {
                    $fees = Fee::query()
                        ->where('session_id', $request->query('session'))
                        ->with('course', 'student', 'institute', 'payments', 'application');
                } else {
                    $fees = Fee::query()->with('course', 'student', 'institute', 'payments', 'application');
                }
            }

            return DataTables::eloquent($fees)
                ->addColumn('action', function($row){
                    return '<a href="'.route('fees.admin.edit', $row->id).'" class="btn btn-xs btn-primary">View</a>';
                })
                ->addColumn('download', function($row){
                    if ($row->payments()->count() != 0) {
                        return '<a href="'. route('admin.fees.print', $row->id) .'" class="btn btn-xs btn-success">Download</a>';
                    }else{
                        return '<a href="javascript:void(0)" class="btn btn-xs btn-warning">No Payment</a>';
                    }
                })
                ->addColumn('feeamount', function($row){
                    $coursefees = $row->institute->courses()->where('course_id', $row->course->id)->first()->pivot->fees ?? 0;
                    $totalpaid = $row->payments()->sum('amount');
                    $balance = $coursefees - $totalpaid;
                    $fee = "$coursefees (Bal $balance)";
                    return $fee;
                })
                ->addColumn('feepayments', function($row){
                    if (count($row->payments) != 0) {
                        $pay = '<ul>';
                        foreach ($row->payments as $key => $payment) {
                            $pay .= '<li>('. $payment->amount .') <a href="'.route('fees.admin.payments').'">'.$payment->reference.'</a></li>';
                        }
                        $pay .= '</ul>';
                        return $pay;
                    }
                    return '<span class="badge badge-outline-danger rounded-pill">No payment yet</span>';
                })
                ->rawColumns(['download', 'feepayments', 'feeamount', 'action'])
                ->toJson();
        }

        return view('fees.admin.index');
    }

    public function studentIndex(Request $request)
    {
        $student = Auth::user();

        if ($request->ajax()) {

            if ($request->query('session')) {
                $fees = Fee::query()
                    ->where('student_id', $student->id)
                    ->where('session_id', $request->query('session'))
                    ->with('course', 'student', 'institute', 'payments', 'application');
            } else {
                $fees = Fee::query()
                ->where('student_id', $student->id)
                ->with('course', 'student', 'institute', 'payments', 'application');
            }

            return DataTables::eloquent($fees)
                ->addColumn('action', function($row){
                    return '<a href="'.route('fees.admin.edit', $row->id).'" class="btn btn-xs btn-primary">View</a>';                
                })
                ->addColumn('download', function($row){

                    $coursefees = $row->institute->courses()->where('course_id', $row->course->id)->first()->pivot->fees ?? 0;
                    $totalpaid = $row->payments()->sum('amount');

                    $bal = $coursefees - $totalpaid;

                    if ($bal <= 0) {
                        return '<a href="'. route('fees.print', $row->id) .'" class="btn btn-xs btn-success">Download</a>';
                    }else{
                        return '<a href="javascript:void(0)" data-id="'.$row->id.'" id="payFeesModal" class="btn btn-xs btn-primary">Pay</a>';
                    }
                })
                ->addColumn('feeamount', function($row){
                    $coursefees = $row->institute->courses()->where('course_id', $row->course->id)->first()->pivot->fees ?? 0;
                    $totalpaid = $row->payments()->sum('amount');

                    $balance = $coursefees - $totalpaid;
                    $fee = "$coursefees (Bal $balance)";
                    return $fee;
                })
                ->addColumn('feepayments', function($row){
                    if (count($row->payments) != 0) {
                        $pay = '<ul>';
                        foreach ($row->payments as $key => $payment) {
                            $pay .= '<li>('. $payment->amount .') <a href="'.route('fees.student.payments').'">'.$payment->reference.'</a></li>';
                        }
                        $pay .= '</ul>';
                        return $pay;
                    }
                    return '<span class="badge badge-outline-danger rounded-pill">No payment yet</span>';
                })

                ->rawColumns(['download', 'feepayments', 'feeamount', 'action'])
                ->toJson();
        }

        return view('fees.student.index');
    }

    public function feeDetails(Fee $fee){
        $fee = Fee::with('payments')->where('id', $fee->id)->first();
        return $fee;
    }

    public function payFees(Request $request){

        $validator = Validator::make($request->all(), [
            'id'          => ['required', 'numeric'],
            'amount'      => ['required', 'numeric']
        ]);

        if ($validator->fails()) {
            $errors = $validator->errors();
            return response()->json([
                    'success' => false,
                    'message' => $errors->first()
            ], 401);
        }
        //Check if fee exists
        $fee = Fee::with('payments', 'course')->where('id', $request->id)->first();

        if (!$fee) {
            return response()->json([
                'success' => false,
                'message' => 'Fee does not exist'
            ], 401);
        }

        $feepayable = $fee->course->fees;

        $totalpaid = $fee->payments()->sum('amount');

        //Fee remaining
        $feeremaining = $feepayable - $totalpaid;

        if ($feeremaining <= 0) {
            return response()->json([
                'success' => false,
                'message' => 'Seems you have completed paying the fee'
            ], 401);
        }

        return response()->json([
            'success' => true,
            'url' => route('fees.send', [$fee->id, $request->amount])
        ], 200);
    }
    public function sendPayment(Fee $fee, $amount){
        $fee = Fee::with('payments')->where('id', $fee->id)->first();
        return view('fees.student.stripe', compact('fee', 'amount'));
    }

    public function redirectToGateway(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'id'            => ['required', 'numeric'],
            'amount'        => ['required', 'numeric'],
            'stripeToken'   => ['required', 'string']
        ]);

        if ($validator->fails()) {
            $errors = $validator->errors();
            return redirect()->route('fees.student')
                        ->with('error', $errors);
        }

        $fee = Fee::where('id', $request->id)->first();
        //Status has to be approved
        if (!$fee) {
            return redirect()->route('fees.student')
                        ->with('error', 'Fee does not exist');
        }

        $stripefee = $request->amount;        

        //Choose Paystack or Stripe
        $data = array(
            "amount"        => $stripefee * 100,
            "currency"      => "USD",
            "source"        => $request->stripeToken,
            "description"   => "Fee Payment for application #" . $fee->application_id
        );

        Stripe::setApiKey(env('STRIPE_SECRET'));
    
        $stripecharge = Charge::create ($data);

        if (isset($stripecharge->status) && $stripecharge->status) {
            if (isset($stripecharge->status) && $stripecharge->status) {
                if (isset($stripecharge->id) && $stripecharge->id) {
                    //Save payment
                    Feepayment::create([
                        'fee_id'            => $fee->id,
                        'session_id'        => getCurrentSession()->id ?? null,
                        'reference'         => $stripecharge->id,
                        'student_id'        => $fee->student->id,
                        'paymentgateway'    => PaymentGatewayEnum::STRIPE(),
                        'amount'            => $stripecharge->amount / 100,
                        'email'             => $fee->student->email,
                        'orderID'           => null,
                        'currency'          => $stripecharge->currency
                    ]);
                    return redirect()->route('fees.student')
                        ->with('success', 'Fee payment successful.');
                }
            }
        }

    }

    public function printFee(Fee $fee)
    {
        return view('fees.student.receipt', compact('fee'));
    }

    public function studentPayments(Request $request)
    {
        if ($request->ajax()) {

            $student = Auth::user();            

            $payments = FeePayment::query()->with('fee.application', 'student')
                                ->where('student_id', $student->id);

            return DataTables::eloquent($payments)
                ->orderColumn('amount', function ($query, $row) {
                    $query->orderBy('amount', $row);
                })
                ->editColumn('amount', function($row) {
                    return $row->currency . ' ' . $row->amount;
                })
                ->addColumn('download', function($row){
                    return '<a href="'. route('fees.print', $row->fee->id) .'" class="btn btn-xs btn-success">Download receipt</a>';
                })
                ->rawColumns(['download'])
                ->toJson();
        }

        return view('fees.student.payments');

    }

    public function studentAdminPayments(Request $request)
    {
        if ($request->ajax()) {

            $user = Auth::user();

            if ($user->hasRole('manager')) {
                $payments = FeePayment::query()->with('fee.application', 'student')
                        ->whereHas('fee', function($query) use($user) {
                            $query->where('institute_id', $user->institute_id);
                        });
            }else{
                $payments = FeePayment::query()->with('fee.application', 'student');
            }

            return DataTables::eloquent($payments)
                ->orderColumn('amount', function ($query, $row) {
                    $query->orderBy('amount', $row);
                })
                ->editColumn('amount', function($row) {
                    return $row->currency . ' ' . $row->amount;
                })
                ->addColumn('download', function($row){
                    return '<a href="'. route('admin.fees.print', $row->fee->id) .'" class="btn btn-xs btn-success">Download receipt</a>';
                })
                ->rawColumns(['download'])
                ->toJson();
        }

        return view('fees.admin.payments');

    }
}

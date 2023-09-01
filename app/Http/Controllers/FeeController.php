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
use App\Models\Application;
use App\Models\Payment;
use Paystack;

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
                    }else {
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

        $feepayable = $fee->institute->courses()->where('course_id', $fee->course->id)->first()->pivot->fees ?? 0;

        //$feepayable = $fee->course->fees;

        $totalpaid = $fee->payments()->sum('amount');

        //Fee remaining
        $feeremaining = $feepayable - $totalpaid;

        if ($feeremaining <= 0) {
            return response()->json([
                'success' => false,
                'message' => 'Seems you have completed paying the fee'
            ], 401);
        }

        $paystackfee = $request->amount;

        //Use Fee collection 
        config([
            'paystack.publicKey' => getenv('PAYSTACK_FEE_PUBLIC_KEY', ''),
            'paystack.secretKey' => getenv('PAYSTACK_FEE_SECRET_KEY', ''),
            'paystack.paymentUrl' => getenv('PAYSTACK_FEE_PAYMENT_URL', 'https://api.paystack.co'),
        ]);

        $data = array(
            "amount"        => $paystackfee * 100,
            "reference"     => Paystack::genTranxRef(),
            "email"         => $fee->application->student->email,
            "currency"      => "NGN",
            "order_id"       => "FEEID-". $fee->id,
        );        
        //Update refcode
        $fee->payref = $data['reference'];
        $fee->save();

        try {
            $url = Paystack::getAuthorizationUrl($data)->url;
            //throw new \Exception("Error Processing Request", 1);
            return response()->json([
                'success' => true,
                'url' => $url
            ], 200);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'The paystack token has expired. Please refresh the page and try again : error ' . $e->getMessage()
            ], 401);
        }
    }
    public function sendPayment(Fee $fee, $amount){
        $fee = Fee::with('payments')->where('id', $fee->id)->first();
        return view('fees.student.stripe', compact('fee', 'amount'));
    }

    public function handleGatewayCallback(Request $request)
    {
        $paymentDetails = Paystack::getPaymentData();

        if (isset($paymentDetails['status']) && $paymentDetails['status']) {
            if (isset($paymentDetails['data']['status']) && $paymentDetails['data']['status']) {
                if (isset($paymentDetails['data']['reference']) && $paymentDetails['data']['reference']) {

                    $fee = Fee::where('payref', $paymentDetails['data']['reference'])->first();
                    if ($fee) {
                        //Save payment
                        Feepayment::create([
                            'fee_id'            => $fee->id,
                            'session_id'        => getCurrentSession()->id ?? null,
                            'reference'         => $paymentDetails['data']['reference'],
                            'student_id'        => $fee->student->id,
                            'paymentgateway'    => PaymentGatewayEnum::PAYSTACK(),
                            'amount'            => $paymentDetails['data']['amount'] / 100,
                            'email'             => $fee->student->email,
                            'orderID'           => null,
                            'currency'          => $paymentDetails['data']['currency']
                        ]);
                        return redirect()->route('fees.student')->with('success', 'Fee payment successful.');
                    }

                    return redirect()->route('fees.student')->with('error', 'Fee does not exist');
                }
            }
        }

        return redirect()->route('fees.student')
                ->with('error', 'Error happened making payment. Contact admin');

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

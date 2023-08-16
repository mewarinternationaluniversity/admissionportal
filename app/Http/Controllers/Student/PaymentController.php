<?php

namespace App\Http\Controllers\Student;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\Application;
use App\Models\Payment;
use Illuminate\Support\Facades\Auth;
use DataTables;
use Paystack;
use App\Enums\PaymentGatewayEnum;
use App\Enums\ApplicationStatusEnum;
use Illuminate\Support\Facades\Validator;
use Stripe\Stripe;
use Stripe\Charge;

class PaymentController extends Controller
{
    public function index(Request $request)
    {
        if ($request->ajax()) {

            $student = Auth::user();            

            $payments = Payment::query()->with('application', 'student')
                                ->where('student_id', $student->id);

            return DataTables::eloquent($payments)
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

        return view('payments.student.index');

    }

    public function stripeView(Application $application)
    {
        // if ($application->status !=  ApplicationStatusEnum::SUBMITTED()) {
        //     return redirect()->route('applications.student')
        //                 ->with('error', 'Application is not approved, or not in SUBMITTED status');
        // }

        return view('payments.student.stripe', compact('application'));
    }

    public function download(Payment $payment)
    {
        return view('payments.receipt', compact('payment'));
    }

    public function redirectToGateway(Request $request)
    {
        $paymentgateway = config('mewar.payment_gateway') ?? 'stripe';

        if ($paymentgateway == 'stripe') {
            $validator = Validator::make($request->all(), [
                'id'            => ['required', 'numeric'],
                'stripeToken'   => ['required', 'string']
            ]);
        } else {
            $validator = Validator::make($request->all(), [
                'id'            => ['required', 'numeric']
            ]);
        }

        if ($validator->fails()) {
            $errors = $validator->errors();
            return redirect()->route('applications.student')
                        ->with('error', $errors);
        }
        $application = Application::where('id', $request->id)->first();
        //Status has to be approved
        if (!$application) {
            return redirect()->route('applications.student')
                        ->with('error', 'Application does not exist');
        }

        // if ($application->status !=  ApplicationStatusEnum::SUBMITTED()) {
        //     return redirect()->route('applications.student')
        //                 ->with('error', 'Application is not approved, or not in SUBMITTED status');
        // }

        $stripefee = config('mewar.usd_fee') ?? 100;        

        if ($paymentgateway == 'stripe') {
            
            //Choose Paystack or Stripe
            $data = array(
                "amount"        => $stripefee * 100,
                "currency"      => "USD",
                "source"        => $request->stripeToken,
                "description"   => "Application #" . $application->id
            );

            Stripe::setApiKey(env('STRIPE_SECRET'));
        
            $stripecharge = Charge::create ($data);

            if (isset($stripecharge->status) && $stripecharge->status) {
                if (isset($stripecharge->status) && $stripecharge->status) {
                    if (isset($stripecharge->id) && $stripecharge->id) {
                        if ($application) {

                            if ($application->status != ApplicationStatusEnum::APPROVED()) {
                                $application->status = ApplicationStatusEnum::PROCESSING();
                                $application->save();
                            }

                            //Save payment
                            Payment::create([
                                'application_id'    => $application->id,
                                'session_id'        => getCurrentSession()->id ?? null,
                                'reference'         => $stripecharge->id,
                                'student_id'        => $application->student->id,
                                'paymentgateway'    => PaymentGatewayEnum::STRIPE(),
                                'amount'            => $stripecharge->amount / 100,
                                'email'             => $application->student->email,
                                'currency'          => $stripecharge->currency
                            ]);
                            return redirect()->route('applications.student')
                                ->with('success', 'Payment successful.');
                        }
                    }
                }
            }
        } else {

            $paystackfee = config('mewar.ngn_fee') ?? 780;

            $data = array(
                "amount"        => $paystackfee * 100,
                "reference"     => Paystack::genTranxRef(),
                "email"         => $application->student->email,
                "currency"      => "NGN",
                "order_id"       => $application->id,
            );
            
            //Update refcode
            $application->payref = $data['reference'];
            $application->save();
    
            try {
                $url = Paystack::getAuthorizationUrl($data)->url;
                return redirect()->away($url);
            } catch (\Exception $e) {
                return redirect()->route('applications.student')
                            ->with('error', 'The paystack token has expired. Please refresh the page and try again : error ' . $e->getMessage());
    
            } 
        }
    }

    public function handleGatewayCallback(Request $request)
    {
        $paymentDetails = Paystack::getPaymentData();

        if (isset($paymentDetails['status']) && $paymentDetails['status']) {
            if (isset($paymentDetails['data']['status']) && $paymentDetails['data']['status']) {
                if (isset($paymentDetails['data']['reference']) && $paymentDetails['data']['reference']) {
                    $application = Application::where('payref', $paymentDetails['data']['reference'])->first();
                    if ($application) {
                        if ($application->status != ApplicationStatusEnum::APPROVED()) {
                            $application->status = ApplicationStatusEnum::PROCESSING();
                            $application->save();
                        }
                        //Save payment
                        Payment::create([
                            'application_id'    => $application->id,
                            'session_id'        => getCurrentSession()->id ?? null,
                            'reference'         => $paymentDetails['data']['reference'],
                            'student_id'        => $application->student->id,
                            'paymentgateway'    => PaymentGatewayEnum::PAYSTACK(),
                            'amount'            => $paymentDetails['data']['amount'] / 100,
                            'email'             => $application->student->email,
                            'currency'          => $paymentDetails['data']['currency']
                        ]);
                        return redirect()->route('applications.student')
                            ->with('success', 'Payment successful.');
                    }
                }
            }
        }

        return redirect()->route('applications.student')
                ->with('error', 'Error happened making payment. Contact admin');

    }
}

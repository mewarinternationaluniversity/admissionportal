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
                ->toJson();
        }

        return view('payments.student.index');

    }

    public function redirectToGateway(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'id' => ['required', 'numeric']
        ]);

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
        if ($application->status !=  ApplicationStatusEnum::APPROVED()) {
            return redirect()->route('applications.student')
                        ->with('error', 'Application is not approved, or not in APPROVED status');
        }

        $data = array(
            "amount"        => 200 * 100,
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

    public function handleGatewayCallback(Request $request)
    {
        $paymentDetails = Paystack::getPaymentData();

        if (isset($paymentDetails['status']) && $paymentDetails['status']) {
            if (isset($paymentDetails['data']['status']) && $paymentDetails['data']['status']) {
                if (isset($paymentDetails['data']['reference']) && $paymentDetails['data']['reference']) {
                    $application = Application::where('payref', $paymentDetails['data']['reference'])->first();
                    if ($application) {
                        $application->status = ApplicationStatusEnum::ACCEPTED();
                        $application->save();
                        //Save payment
                        Payment::create([
                            'application_id'    => $application->id,
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

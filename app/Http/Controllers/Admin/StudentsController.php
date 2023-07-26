<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\Application;
use App\Models\Payment;
use Illuminate\Support\Facades\Auth;
use DataTables;
use App\Imports\UsersImport;
use Maatwebsite\Excel\Facades\Excel;
use Illuminate\Support\Facades\Validator;

class StudentsController extends Controller
{
    public function uploadView()
    {
        return view('upload.students');
    }

    public function upload(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'csvfile'   => ['required', 'mimes:xlsx,csv,xls,txt']
        ]);

        if ($validator->fails()) {
            $errors = $validator->errors();
            return redirect()->route('applications.students.upload.view')
                                ->with('error', $errors->first());
        }

        if($request->file('csvfile')) {
            $fileName = $request->file('csvfile');

            try {
                Excel::import(new UsersImport, $fileName);
            } catch (\Maatwebsite\Excel\Validators\ValidationException $e) {                

                 $failures = $e->failures();

                 $error = [];
                 
                 foreach ($failures as $failure) {
                     $error[] = [
                        'row' => $failure->row(),
                        'errors' => $failure->errors(),
                        'values' => $failure->values(),
                        'attribute' => $failure->attribute()
                     ];
                 }

                 $error = $error[0];

                 if (isset($error['row']) && isset($error['attribute']) && isset($error['errors'][0])) {
                    $message = 'Error in row: '.$error['row'].' message: ' . $error['errors'][0];
                 } else {
                    $message = 'Unknown error';
                 }

                 return redirect()->back()->with('error', $message);
            }

            return redirect()->route('manager.students.list')->with('success', 'Students uploaded successully');
        }
    }

    public function download()
    {
        $headers = [
            'Content-Type' => 'text/csv'
        ];
        return response()->download(public_path('/storage/download/users-manager.csv'), 'users-manager.csv', $headers);
    }

}

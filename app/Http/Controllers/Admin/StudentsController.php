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

                 dd($failures);
                 
                 foreach ($failures as $failure) {
                     $failure->row(); // row that went wrong
                     $failure->attribute(); // either heading key (if using heading row concern) or column index
                     $failure->errors(); // Actual error messages from Laravel validator
                     $failure->values(); // The values of the row that has failed.
                 }
            }

            return redirect()->route('users.students')->with('success', 'All good!');            

        }

        dd($request);
    }

    public function download()
    {
        $headers = [
            'Content-Type' => 'text/csv'
        ];
        return response()->download(public_path('/storage/download/users-admin.csv'), 'users-admin.csv', $headers);
    }

}

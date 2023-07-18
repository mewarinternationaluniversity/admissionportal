<?php

namespace App\Http\Controllers;

use App\Models\Session;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;


class SessionController extends Controller
{
    public function store(Request $request)
    {
        if ($request->id) {
            $validator = Validator::make($request->all(), [
                'name'      => ['required', 'string', 'unique:sessions,name,'.$request->id],
                'id'        => ['required'],
                'status'    => ['required']
            ]);
        } else {
            $validator = Validator::make($request->all(), [
                'name'      => ['required', 'string', 'unique:sessions,name'],
                'status'    => ['required']
            ]);
        }

        if ($validator->fails()) {
            $errors = $validator->errors();
            return redirect()->back()->with('error', $errors->first());
        }

        if ($request->status == 1) {
            //Disable all sessions
            $sessions = Session::get();
            foreach ($sessions as $session) {
                $session->status = false;
                $session->save();
            }
        }

        Session::updateOrCreate(['id' => $request->id], [
            'name'      => $request->name,
            'status'    => $request->status
        ]);

        return redirect()->back()->with('success', 'Session saved successfully.');
    }

    public function destroy($id)
    {
        Session::find($id)->delete();

        return redirect()->back()->with('success', 'Session deleted successfully.');
    }
}

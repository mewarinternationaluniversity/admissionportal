<?php

namespace App\Http\Controllers\Institute;

use App\Models\Institute;
use DataTables;
use Illuminate\Http\Request;
use App\Enums\InstituteTypeEnum;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Spatie\Permission\Models\Role;
use Yajra\DataTables\Html\Column;
use Yajra\DataTables\Html\Builder;
use Illuminate\Support\Facades\Hash;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Validator;

class IndexController extends Controller
{
    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        if ($request->id) {
            $validator = Validator::make($request->all(), [
                'name'              => ['required', 'string', 'max:255'],
                'email'             => ['required', 'string', 'email', 'max:255', 'unique:users,email,'.$request->id],
                'dob'               => ['required', 'date_format:d/m/Y'],
                'phone'             => ['nullable', 'numeric'],
                'role'              => ['required'],
                'matriculation_no'  => ['required', 'string', 'unique:users,matriculation_no,'.$request->id],
                'nd_institute'      => ['required', 'numeric'],
                'nd_course'         => ['required', 'numeric']
            ]);
        } else {
            $validator = Validator::make($request->all(), [
                'name'              => ['required', 'string', 'max:255'],
                'email'             => ['required', 'string', 'email', 'max:255', 'unique:users'],                
                'dob'               => ['required', 'date_format:d/m/Y'],
                'phone'             => ['nullable', 'numeric'],
                'role'              => ['required'],
                'matriculation_no'  => ['required', 'string', 'unique:users,matriculation_no'],
                'nd_institute'      => ['required', 'numeric'],
                'nd_course'         => ['required', 'numeric']
            ]);
        }
        
        if ($validator->fails()) {
            $errors = $validator->errors();
            return response()->json([
                    'success' => false,
                    'message' => $errors->first()
            ], 401);
        }

        $assingrole = Role::findOrCreate('student');

        $user = User::updateOrCreate(['id' => $request->id],
        [
            'name'              => $request->name,
            'email'             => $request->email,
            'phone'             => $request->phone,
            'dob'               => $request->dob,
            'institute_id'      => $request->institute_id,
            'matriculation_no'  => $request->matriculation_no,
            'nd_institute'      => $request->nd_institute,
            'nd_course'         => $request->nd_course,
            'password'          => Hash::make($request->dob),
        ]);
        $user->assignRole($assingrole);

        return response()->json(['success'=>'Student saved successfully.']);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Institute
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $user = User::find($id);
        return response()->json($user);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Institute
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        User::find($id)->delete();
     
        return response()->json(['success'=>'User deleted successfully.']);
    }


    public function showStudents(Request $request)
    {
        if ($request->ajax()) {

            $manageruser = Auth::user();            

            $students = User::query()->role('student')->where('nd_institute', $manageruser->institute_id);

            return DataTables::eloquent($students)
                ->addColumn('avatar', function($row) {
                    if ($row->avatar) {
                        return  '<img src="'. $row->avatar .'" alt="table-user" class="me-3 rounded-circle avatar-sm">';
                    }
                    $avatar = '<div class="avatar-sm me-3">';
                    $avatar = $avatar.'<div class="avatar-title rounded-circle bg-soft-primary fw-medium text-primary">M';
                    $avatar = $avatar.'</div>';
                    $avatar = $avatar.'</div>';
                    return $avatar;                    
                })
                ->addColumn('action', function($row){
                    $btn = '<ul class="list-inline mb-0">';
                    $btn = $btn.'<li class="list-inline-item">';
                    $btn = $btn.'<a href="'. route('student.profile', $row->id) .'" class="btn btn-xs btn-primary"> View</a>';
                    $btn = $btn.'</li>';
                    $btn = $btn.'</ul>';
                    return $btn;
                })
                ->addColumn('program', function($row) {
                    return $row->ndcourse->title;
                })
                ->removeColumn('created_at')
                ->removeColumn('updated_at')
                ->removeColumn('email_verified_at')
                ->rawColumns(['avatar', 'action'])
                ->toJson();
        }

        return view('institute.students.list');
    }

    public function profile() 
    {
        $institute = Auth::user()->institute;
        return view('institute.profile', compact('institute'));
    }


    public function save(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'phone'         => ['nullable', 'string', 'min:8'],
            'logo'          => ['nullable', 'image'],
            'letterhead'    => ['nullable', 'image'],
            'banner'        => ['nullable', 'image'],
            'sliderone'     => ['nullable', 'image'],
            'slidertwo'     => ['nullable', 'image'],
            'sliderthree'   => ['nullable', 'image'],
            'seal'          => ['nullable', 'image'],
            'signature'     => ['nullable', 'image'],
            'description'   => ['nullable', 'string']
        ]);        

        if ($validator->fails()) {
            $errors = $validator->errors();

            return redirect()->route('manager.institute.profile')->with('error', $errors->first());
        }
        
        $institutesave = Institute::updateOrCreate(['id' => $request->id], [
            'phone'         => $request->phone,
            'officername'   => $request->officername,
            'officeremail'  => $request->officeremail,
            'description'   => $request->description,
        ]);

        if($request->file('logo')) {
            $fileName = $request->file('logo')->getClientOriginalName();
            $filePath = $request->file('logo')->storeAs('institutes/' . $institutesave->id, $fileName, 'public');
            $institutesave->logo = '/storage/' . $filePath;
            $institutesave->save();
        }

        if($request->file('letterhead')) {
            $fileName = $request->file('letterhead')->getClientOriginalName();
            $filePath = $request->file('letterhead')->storeAs('institutes/' . $institutesave->id, $fileName, 'public');
            $institutesave->letterhead = '/storage/' . $filePath;
            $institutesave->save();
        }

        if($request->file('banner')) {
            $fileName = $request->file('banner')->getClientOriginalName();
            $filePath = $request->file('banner')->storeAs('institutes/' . $institutesave->id, $fileName, 'public');
            $institutesave->banner = '/storage/' . $filePath;
            $institutesave->save();
        }

        if($request->file('sliderone')) {
            $fileName = $request->file('sliderone')->getClientOriginalName();
            $filePath = $request->file('sliderone')->storeAs('institutes/' . $institutesave->id, $fileName, 'public');
            $institutesave->sliderone = '/storage/' . $filePath;
            $institutesave->save();
        }

        if($request->file('slidertwo')) {
            $fileName = $request->file('slidertwo')->getClientOriginalName();
            $filePath = $request->file('slidertwo')->storeAs('institutes/' . $institutesave->id, $fileName, 'public');
            $institutesave->slidertwo = '/storage/' . $filePath;
            $institutesave->save();
        }

        if($request->file('sliderthree')) {
            $fileName = $request->file('sliderthree')->getClientOriginalName();
            $filePath = $request->file('sliderthree')->storeAs('institutes/' . $institutesave->id, $fileName, 'public');
            $institutesave->sliderthree = '/storage/' . $filePath;
            $institutesave->save();
        }

        if($request->file('seal')) {
            $fileName = $request->file('seal')->getClientOriginalName();
            $filePath = $request->file('seal')->storeAs('institutes/' . $institutesave->id, $fileName, 'public');
            $institutesave->seal = '/storage/' . $filePath;
            $institutesave->save();
        }

        if($request->file('signature')) {
            $fileName = $request->file('signature')->getClientOriginalName();
            $filePath = $request->file('signature')->storeAs('institutes/' . $institutesave->id, $fileName, 'public');
            $institutesave->signature = '/storage/' . $filePath;
            $institutesave->save();
        }

        return redirect()->route('manager.institute.profile')->with('success', 'Institute saved successfully.');
    }
}

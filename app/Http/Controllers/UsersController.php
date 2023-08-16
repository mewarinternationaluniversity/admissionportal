<?php

namespace App\Http\Controllers;

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
use Illuminate\Support\Facades\Validator;

class UsersController extends Controller
{
    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        enforceReadOnly();
        if ($request->id) {
            if ($request->role == 'student') {
                $validator = Validator::make($request->all(), [
                    'name'              => ['required', 'string', 'max:255'],
                    'email'             => ['required', 'string', 'email', 'max:255', 'unique:users,email,'.$request->id],
                    'dob'               => ['required', 'date_format:d/m/Y'],
                    'phone'             => ['nullable', 'numeric'],
                    'role'              => ['required'],
                    'matriculation_no'  => ['required', 'string', 'unique:users,matriculation_no,'.$request->id],
                    'nd_institute'      => ['required', 'numeric'],
                    'nd_course'         => ['required', 'numeric'],
                    'gender'            => ['required', 'string'],
                    'yearofgraduation'  => ['required', 'numeric'],
                ]);
            } elseif($request->role == 'manager') {
                $validator = Validator::make($request->all(), [
                    'name'          => ['required', 'string', 'max:255'],
                    'email'         => ['required', 'string', 'email', 'max:255', 'unique:users,email,'.$request->id],
                    'phone'         => ['nullable', 'numeric'],
                    'institute_id'  => ['required', 'numeric'],                    
                    'role'          => ['required'],
                ]);
            } elseif($request->role == 'admin') {
                $validator = Validator::make($request->all(), [
                    'name'      => ['required', 'string', 'max:255'],
                    'type'      => ['required', 'string'],
                    'email'     => ['required', 'string', 'email', 'max:255', 'unique:users,email,'.$request->id],
                    'phone'     => ['nullable', 'numeric'],
                    'role'      => ['required'],
                ]);
            }else {
                return response()->json([
                        'success' => false,
                        'message' => 'Role seems not set'
                ], 401);
            }

        } else {

            if ($request->role == 'student') {
                $validator = Validator::make($request->all(), [
                    'name'              => ['required', 'string', 'max:255'],
                    'email'             => ['required', 'string', 'email', 'max:255', 'unique:users'],
                    'dob'               => ['required', 'date_format:d/m/Y'],
                    'phone'             => ['nullable', 'numeric'],
                    'role'              => ['required'],
                    'matriculation_no'  => ['required', 'string', 'unique:users,matriculation_no'],
                    'nd_institute'      => ['required', 'numeric'],
                    'nd_course'         => ['required', 'numeric'],
                    'gender'            => ['required', 'string'],
                    'yearofgraduation'  => ['required', 'numeric'],
                ]);

            } elseif($request->role == 'manager') {
                $validator = Validator::make($request->all(), [
                    'name'          => ['required', 'string', 'max:255'],
                    'email'         => ['required', 'string', 'email', 'max:255', 'unique:users'],
                    'password'      => ['required', 'string', 'min:8'],
                    'phone'         => ['nullable', 'numeric'],
                    'institute_id'  => ['required', 'numeric'],                    
                    'role'          => ['required'],
                ]);
            } elseif($request->role == 'admin') {
                $validator = Validator::make($request->all(), [
                    'name'      => ['required', 'string', 'max:255'],
                    'email'     => ['required', 'string', 'email', 'max:255', 'unique:users'],
                    'password'  => ['required', 'string', 'min:8'],
                    'type'      => ['required', 'string'],
                    'phone'     => ['nullable', 'numeric'],
                    'role'      => ['required'],
                ]);
            }else {
                return response()->json([
                        'success' => false,
                        'message' => 'Role seems not set'
                ], 401);
            }
        }
        
        if ($validator->fails()) {
            $errors = $validator->errors();
            return response()->json([
                    'success' => false,
                    'message' => $errors->first()
            ], 401);
        }

        if ($request->role == 'admin') {
            $assingrole = Role::findOrCreate('admin');
        }
        if ($request->role == 'student') {
            $assingrole = Role::findOrCreate('student');
        }
        if ($request->role == 'manager') {
            $assingrole = Role::findOrCreate('manager');
        }

        if ($request->password) {
            $user = User::updateOrCreate(['id' => $request->id],
            [
                'name'              => $request->name,
                'type'              => $request->type,
                'email'             => $request->email,
                'phone'             => $request->phone,
                'dob'               => $request->dob,
                'institute_id'      => $request->institute_id,
                'matriculation_no'  => $request->matriculation_no,
                'nd_institute'      => $request->nd_institute,
                'nd_course'         => $request->nd_course,
                'gender'            => $request->gender,
                'yearofgraduation'  => $request->yearofgraduation,
                'password'          => Hash::make($request->password),
            ]);
            
            $user->assignRole($assingrole);
            
        } else {
            $user = User::updateOrCreate(['id' => $request->id],
            [
                'name'              => $request->name,
                'type'              => $request->type,
                'email'             => $request->email,
                'phone'             => $request->phone,
                'dob'               => $request->dob,
                'institute_id'      => $request->institute_id,
                'matriculation_no'  => $request->matriculation_no,
                'nd_institute'      => $request->nd_institute,
                'nd_course'         => $request->nd_course,
                'gender'            => $request->gender,
                'yearofgraduation'  => $request->yearofgraduation,
                'password'          => Hash::make($request->dob),
            ]);

            $user->assignRole($assingrole);
        }     
   
        return response()->json(['success'=>'User saved successfully.']);
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
        enforceReadOnly();
        //Can't delete own account
        if (Auth::user()->id == $id) {
            return response()->json(['error'=>'You can not delete own account']);
        }

        User::find($id)->delete();
     
        return response()->json(['success'=>'User deleted successfully.']);
    }

    public function showAdmins(Request $request)
    {
        if ($request->ajax()) {

            $admins = User::query()->role('admin');

            return DataTables::eloquent($admins)
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
                    $btn = $btn.'<a href="javascript:void(0)" data-toggle="tooltip" data-id="'.$row->id.'" data-original-title="Edit" class="action-icon editAdmin"> <i class="mdi mdi-square-edit-outline"></i></a>';
                    $btn = $btn.'</li>';
                    $btn = $btn.'<li class="list-inline-item">';
                    $btn = $btn.'<a href="javascript:void(0)" data-toggle="tooltip" data-id="'.$row->id.'" data-original-title="Delete" class="action-icon deleteAdmin"> <i class="mdi mdi-delete"></i></a>';
                    $btn = $btn.'</li>';
                    $btn = $btn.'</ul>';
                    return $btn;
                })
                ->removeColumn('created_at')
                ->removeColumn('updated_at')
                ->removeColumn('email_verified_at')
                ->removeColumn('dob')
                ->removeColumn('matriculation_no')
                ->removeColumn('address')
                ->removeColumn('nd_institute')
                ->removeColumn('nd_course')
                ->rawColumns(['action', 'avatar'])
                ->toJson();
        }

        return view('users.admins.index');
    }

    public function showManagers(Request $request)
    {
        if ($request->ajax()) {

            $admins = User::query()->role('manager');

            return DataTables::eloquent($admins)
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
                    $btn = $btn.'<a href="javascript:void(0)" data-toggle="tooltip" data-id="'.$row->id.'" data-original-title="Edit" class="action-icon editAdmin"> <i class="mdi mdi-square-edit-outline"></i></a>';
                    $btn = $btn.'</li>';
                    $btn = $btn.'<li class="list-inline-item">';
                    $btn = $btn.'<a href="javascript:void(0)" data-toggle="tooltip" data-id="'.$row->id.'" data-original-title="Delete" class="action-icon deleteAdmin"> <i class="mdi mdi-delete"></i></a>';
                    $btn = $btn.'</li>';
                    $btn = $btn.'</ul>';
                    return $btn;
                })
                ->addColumn('institute_name', function($row) {
                    if (isset($row->institute->title) && $row->institute->title) {
                        return $row->institute->title;
                    }
                    return null;                    
                })                
                ->removeColumn('created_at')
                ->removeColumn('updated_at')
                ->removeColumn('email_verified_at')
                ->removeColumn('dob')
                ->removeColumn('matriculation_no')
                ->removeColumn('address')
                ->removeColumn('nd_institute')
                ->removeColumn('nd_course')
                ->rawColumns(['action', 'avatar'])
                ->toJson();
        }

        return view('users.managers.index');
    }

    public function showStudents(Request $request)
    {
        if ($request->ajax()) {

            $admins = User::query()->role('student');

            return DataTables::eloquent($admins)
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
                    $btn = $btn.'<a href="javascript:void(0)" data-toggle="tooltip" data-id="'.$row->id.'" data-original-title="Edit" class="action-icon editAdmin"> <i class="mdi mdi-square-edit-outline"></i></a>';
                    $btn = $btn.'</li>';
                    $btn = $btn.'<li class="list-inline-item">';
                    $btn = $btn.'<a href="javascript:void(0)" data-toggle="tooltip" data-id="'.$row->id.'" data-original-title="Delete" class="action-icon deleteAdmin"> <i class="mdi mdi-delete"></i></a>';
                    $btn = $btn.'</li>';
                    $btn = $btn.'</ul>';
                    return $btn;
                })
                ->addColumn('applications', function($row) {
                    return $row->applications()->count();                    
                })
                ->removeColumn('created_at')
                ->removeColumn('updated_at')
                ->removeColumn('email_verified_at')
                ->rawColumns(['action', 'avatar'])
                ->toJson();
        }

        return view('users.students.index');
    }

    public function myAccount()
    {
        $user = Auth::user();
        return view('users.profile.index', compact('user'));
    }

    public function viewStudentProfile($id)
    {
        $user = User::role('student')->where('id', $id)->first();

        if (!$user) {
            abort(404);
        }
        
        return view('users.profile.student-profile', compact('user'));
    }

    public function updatePassword(Request $request)
    {   
        enforceReadOnly();
        $request->validate([
          'old_password' => 'required',
          'new_password' => 'min:6|required_with:password_confirmation|same:password_confirmation',
          'password_confirmation' => 'min:6'
        ]);

        if(Hash::check($request->old_password , auth()->user()->password)) {

            if(!Hash::check($request->new_password , auth()->user()->password)) {

               $user = User::find(auth()->id());

               $user->update([
                   'password' => bcrypt($request->new_password)
               ]);

               return redirect()->back()->with('success', 'Password updated successfully!');
            }
            
            return redirect()->back()->with('error', 'New password can not be the old password!');
        }

        return redirect()->back()->with('error', 'Old password does not matched!');
    }

    public function updateProfile(Request $request)
    {    
        enforceReadOnly();    
        $validator = Validator::make($request->all(), [
            'name'              => ['required', 'string', 'max:255'],
            'email'             => ['required', 'string', 'email', 'max:255', 'unique:users,email,'.$request->id],
            'matriculation_no'  => ['required', 'string', 'unique:users,matriculation_no,'.$request->id],
            'dob'               => ['required', 'date_format:d/m/Y'],
            'nd_institute'      => ['required', 'numeric'],
            'nd_course'         => ['required', 'numeric'],
            'phone'             => ['required', 'numeric'],
            'avatar'            => ['nullable', 'image'],
            'idproof'           => ['nullable', 'mimes:jpg,png,pdf'],
            'ndtranscript'      => ['nullable', 'mimes:jpg,png,pdf'],
            'ndgraduationcert'  => ['nullable', 'mimes:jpg,png,pdf'],
            'otheruploads'      => ['nullable', 'mimes:jpg,png,pdf']
        ]);

        if (Auth::user()->hasRole('admin')) {
            $validator = Validator::make($request->all(), [
                'name'              => ['required', 'string', 'max:255'],
                'email'             => ['required', 'string', 'email', 'max:255', 'unique:users,email,'.$request->id],
                'phone'             => ['required', 'numeric']
            ]);    
        }

        if (Auth::user()->hasRole('manager')) {
            $validator = Validator::make($request->all(), [
                'name'              => ['required', 'string', 'max:255'],
                'email'             => ['required', 'string', 'email', 'max:255', 'unique:users,email,'.$request->id],
                'phone'             => ['required', 'numeric']
            ]);    
        }

        if (Auth::user()->hasRole('student')) {
            $validator = Validator::make($request->all(), [
                'name'              => ['required', 'string', 'max:255'],
                'email'             => ['required', 'string', 'email', 'max:255', 'unique:users,email,'.$request->id],
                'matriculation_no'  => ['required', 'string', 'unique:users,matriculation_no,'.$request->id],
                'dob'               => ['required', 'date_format:d/m/Y'],
                'nd_institute'      => ['required', 'numeric'],
                'nd_course'         => ['required', 'numeric'],
                'phone'             => ['required', 'numeric']
            ]);    
        }

        if ($validator->fails()) {
            $errors = $validator->errors();
            return redirect()->route('my.account')->with('error', $errors->first());
        }

        $user = User::updateOrCreate(['id' => $request->id], [
            'name'      => $request->name,
            'email'     => $request->email,
            'phone'     => $request->phone,
            'dob'      => $request->dob,
            'institute_id'     => $request->institute_id,
            'matriculation_no'     => $request->matriculation_no,
            'nd_institute'      => $request->nd_institute,
            'nd_course'     => $request->nd_course
        ]);        

        if($request->file('avatar')) {
            $fileName = $request->file('avatar')->getClientOriginalName();
            $filePath = $request->file('avatar')->storeAs('profiles/' . $user->id . '/logo', $fileName, 'public');
            $user->avatar = '/storage/' . $filePath;
            $user->save();
        }

        if($request->file('idproof')) {
            $fileName = $request->file('idproof')->getClientOriginalName();
            $filePath = $request->file('idproof')->storeAs('profiles/' . $user->id, $fileName, 'public');
            $user->idproof = '/storage/' . $filePath;
            $user->save();
        }

        if($request->file('ndtranscript')) {
            $fileName = $request->file('ndtranscript')->getClientOriginalName();
            $filePath = $request->file('ndtranscript')->storeAs('profiles/' . $user->id, $fileName, 'public');
            $user->ndtranscript = '/storage/' . $filePath;
            $user->save();
        }

        if($request->file('ndgraduationcert')) {
            $fileName = $request->file('ndgraduationcert')->getClientOriginalName();
            $filePath = $request->file('ndgraduationcert')->storeAs('profiles/' . $user->id, $fileName, 'public');
            $user->ndgraduationcert = '/storage/' . $filePath;
            $user->save();
        }

        if($request->file('otheruploads')) {
            $fileName = $request->file('otheruploads')->getClientOriginalName();
            $filePath = $request->file('otheruploads')->storeAs('profiles/' . $user->id, $fileName, 'public');
            $user->otheruploads = '/storage/' . $filePath;
            $user->save();
        }

        return redirect()->route('my.account')->with('success', 'User details saved successfully.');
    }

}

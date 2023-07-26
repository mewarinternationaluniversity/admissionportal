<?php

namespace App\Http\Controllers;

use App\Enums\CourseTypeEnum;
use App\Models\Institute;
use DataTables;
use Illuminate\Http\Request;
use App\Enums\InstituteTypeEnum;
use App\Models\Course;
use Illuminate\Support\Facades\Auth;
use Yajra\DataTables\Html\Column;
use Yajra\DataTables\Html\Builder;
use Illuminate\Support\Facades\Validator;

class InstituteController extends Controller
{
    public function index()
    {
        
    }
    
    public function store(Request $request)
    {
        if ($request->id) {
            $validator = Validator::make($request->all(), [
                'type'          => ['required', 'string', 'max:255'],
                'title'         => ['required', 'string', 'max:255', 'unique:institutes,title,'.$request->id],
                'phone'         => ['nullable', 'string', 'min:8'],
                'logo'          => ['nullable', 'image'],
                'letterhead'    => ['nullable', 'image'],
                'banner'        => ['nullable', 'image'],
                'sliderone'     => ['nullable', 'image'],
                'slidertwo'     => ['nullable', 'image'],
                'sliderthree'   => ['nullable', 'image'],
                'description'   => ['nullable', 'string', 'max:255']
            ]);
        } else {
            $validator = Validator::make($request->all(), [
                'type' => ['required', 'string', 'max:255'],
                'title' => ['required', 'string', 'max:100', 'unique:institutes,title'],
                'phone' => ['nullable', 'string', 'min:8'],
                'logo'          => ['nullable', 'image'],
                'letterhead'    => ['nullable', 'image'],
                'banner'        => ['nullable', 'image'],
                'sliderone'     => ['nullable', 'image'],
                'slidertwo'     => ['nullable', 'image'],
                'sliderthree'   => ['nullable', 'image'],
                'description'   => ['nullable', 'string', 'max:255']
            ]);
        }

        if ($validator->fails()) {
            $errors = $validator->errors();
            return response()->json([
                    'success' => false,
                    'message' => $errors->first()
            ], 401);
        }
        
        $institutesave = Institute::updateOrCreate(['id' => $request->id], [
            'title'         => $request->title,
            'type'          => $request->type,
            'phone'         => $request->phone,
            'description'   => $request->description
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
   
        return response()->json(['success'=>'Institute saved successfully.']);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Institute
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $post = Institute::find($id);
        return response()->json($post);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Institute
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        Institute::find($id)->delete();
     
        return response()->json(['success'=>'Institute deleted successfully.']);
    }

    public function showBachelors(Request $request)
    {
        if ($request->ajax()) {

            $bachelors = Institute::query()->where('type', InstituteTypeEnum::BACHELORS());

            return DataTables::eloquent($bachelors)
                ->addColumn('institute', function($row){
                    if ($row->logo) {
                        $inst = '<div class="d-flex">';
                        $inst = $inst.'<img src="'. $row->logo .'" alt="table-user" class="me-3 rounded-circle avatar-sm">';
                        $inst = $inst.'<div class="flex-1">';
                        $inst = $inst.'<h5 class="mt-0 mb-1"><a href="javascript:void(0);" class="text-dark">'. $row->title .'</a></h5>';
                        $inst = $inst.'<p class="mb-0 font-13">ID : #'. $row->id .'</p>';
                        $inst = $inst.'</div>';
                        $inst = $inst.'</div>';
                        return  $inst;
                    }

                    $inst = '<div class="d-flex">';
                    $inst = $inst.'<div class="avatar-sm me-3">';
                    $inst = $inst.'<div class="avatar-title rounded-circle bg-soft-primary fw-medium text-primary">M';
                    $inst = $inst.'</div>';
                    $inst = $inst.'</div>';
                    $inst = $inst.'<div class="flex-1">';
                    $inst = $inst.'<h5 class="mt-0 mb-1"><a href="javascript:void(0);" class="text-dark">'. $row->title .'</a></h5>';
                    $inst = $inst.'<p class="mb-0 font-13">ID : #'. $row->id .'</p>';
                    $inst = $inst.'</div>';
                    $inst = $inst.'</div>';
                    return  $inst;

                })
                ->addColumn('action', function($row){
                    $btn = '<ul class="list-inline mb-0">';
                    $btn = $btn.'<li class="list-inline-item">';
                    $btn = $btn.'<a href="javascript:void(0)" data-toggle="tooltip" data-id="'.$row->id.'" data-original-title="Edit" class="action-icon editPost"> <i class="mdi mdi-square-edit-outline"></i></a>';
                    $btn = $btn.'</li>';
                    $btn = $btn.'<li class="list-inline-item">';
                    $btn = $btn.'<a href="javascript:void(0)" data-toggle="tooltip" data-id="'.$row->id.'" data-original-title="Add User" class="action-icon addUser"> <i class="mdi mdi-add-filled"></i></a>';
                    $btn = $btn.'</li>';
                    $btn = $btn.'<li class="list-inline-item">';
                    $btn = $btn.'<a href="javascript:void(0)" data-toggle="tooltip" data-id="'.$row->id.'" data-original-title="Delete" class="action-icon deletePost"> <i class="mdi mdi-delete"></i></a>';
                    $btn = $btn.'</li>';
                    $btn = $btn.'</ul>';
                    return $btn;
                })
                ->removeColumn('created_at')
                ->removeColumn('updated_at')
                ->removeColumn('banner')
                ->removeColumn('sliders')
                ->editColumn('type', function($row) {
                    return $row->type;
                })
                ->addColumn('users', function($row) {
                    return 2;
                })
                ->rawColumns(['action', 'institute'])
                ->toJson();
        }

        return view('pages.institutes.bachelors');
    }

    public function showDiploma(Request $request)
    {
        if ($request->ajax()) {

            $bachelors = Institute::query()->where('type', InstituteTypeEnum::DIPLOMA());

            return DataTables::eloquent($bachelors)
                ->addColumn('institute', function($row){
                    if ($row->logo) {
                        $inst = '<div class="d-flex">';
                        $inst = $inst.'<img src="'. $row->logo .'" alt="table-user" class="me-3 rounded-circle avatar-sm">';
                        $inst = $inst.'<div class="flex-1">';
                        $inst = $inst.'<h5 class="mt-0 mb-1"><a href="javascript:void(0);" class="text-dark">'. $row->title .'</a></h5>';
                        $inst = $inst.'<p class="mb-0 font-13">ID : #'. $row->id .'</p>';
                        $inst = $inst.'</div>';
                        $inst = $inst.'</div>';
                        return  $inst;
                    }

                    $inst = '<div class="d-flex">';
                    $inst = $inst.'<div class="avatar-sm me-3">';
                    $inst = $inst.'<div class="avatar-title rounded-circle bg-soft-primary fw-medium text-primary">M';
                    $inst = $inst.'</div>';
                    $inst = $inst.'</div>';
                    $inst = $inst.'<div class="flex-1">';
                    $inst = $inst.'<h5 class="mt-0 mb-1"><a href="javascript:void(0);" class="text-dark">'. $row->title .'</a></h5>';
                    $inst = $inst.'<p class="mb-0 font-13">ID : #'. $row->id .'</p>';
                    $inst = $inst.'</div>';
                    $inst = $inst.'</div>';
                    return  $inst;

                })
                ->addColumn('action', function($row){
                    $btn = '<ul class="list-inline mb-0">';
                    $btn = $btn.'<li class="list-inline-item">';
                    $btn = $btn.'<a href="javascript:void(0)" data-toggle="tooltip" data-id="'.$row->id.'" data-original-title="Edit" class="action-icon editPost"> <i class="mdi mdi-square-edit-outline"></i></a>';
                    $btn = $btn.'</li>';
                    $btn = $btn.'<li class="list-inline-item">';
                    $btn = $btn.'<a href="javascript:void(0)" data-toggle="tooltip" data-id="'.$row->id.'" data-original-title="Add User" class="action-icon addUser"> <i class="mdi mdi-add-filled"></i></a>';
                    $btn = $btn.'</li>';
                    $btn = $btn.'<li class="list-inline-item">';
                    $btn = $btn.'<a href="javascript:void(0)" data-toggle="tooltip" data-id="'.$row->id.'" data-original-title="Delete" class="action-icon deletePost"> <i class="mdi mdi-delete"></i></a>';
                    $btn = $btn.'</li>';
                    $btn = $btn.'</ul>';
                    return $btn;
                })
                ->removeColumn('created_at')
                ->removeColumn('updated_at')
                ->removeColumn('banner')
                ->removeColumn('sliders')
                ->editColumn('type', function($row) {
                    return $row->type;
                })
                ->addColumn('users', function($row) {
                    return 2;
                })
                ->rawColumns(['action', 'institute'])
                ->toJson();
        }

        return view('pages.institutes.diploma');
    }

    public function profile(Institute $institute)
    {
        return view('institute.public', compact('institute'));
    }


    public function showDiplomaCourses(Request $request)
    {
        $user = Auth::user();

        if ($request->ajax()) {

            //$course = Course::query()->where('type', CourseTypeEnum::DIPLOMA());

            $course = $user->institute->courses;

            return DataTables::eloquent($course)
                ->removeColumn('created_at')
                ->removeColumn('updated_at')
                ->editColumn('type', function($row) {
                    return $row->type;
                })
                ->toJson();
        }
        return view('pages.courses.diploma-i');
    }

}

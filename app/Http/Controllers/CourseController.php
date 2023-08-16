<?php

namespace App\Http\Controllers;

use App\Models\Course;
use DataTables;
use Illuminate\Http\Request;
use App\Enums\CourseTypeEnum;
use App\Models\Institute;
use Illuminate\Support\Facades\Validator;

class CourseController extends Controller
{
    public function index()
    {
        
    }

    public function getCourses(Institute $institute)
    {
        return response()->json($institute->courses()->get()
            ->pluck('title', 'id'), 200);                
    }
    
    public function store(Request $request)
    {
        enforceReadOnly();
        if ($request->id) {
            $validator = Validator::make($request->all(), [
                'type' => ['required', 'string', 'max:255'],
                'fees' => ['nullable', 'string', 'max:10'],
                'title' => ['required', 'string', 'max:255', 'unique:courses,title,'.$request->id]
            ]);
        } else {
            $validator = Validator::make($request->all(), [
                'type' => ['required', 'string', 'max:255'],
                'fees' => ['nullable', 'string', 'max:10'],
                'title' => ['required', 'string', 'max:100', 'unique:courses,title']
            ]);
        }

        if ($validator->fails()) {
            $errors = $validator->errors();
            return response()->json([
                    'success' => false,
                    'message' => $errors->first()
            ], 401);
        }

        Course::updateOrCreate(['id' => $request->id],
            [
                'title' => $request->title,
                'type' => $request->type,
                'fees' => $request->fees,
                'description' => $request->description
            ]);        
   
        return response()->json(['success'=>'Course saved successfully.']);
    }

    public function edit($id)
    {
        $post = Course::find($id);
        return response()->json($post);
    }

    public function destroy($id)
    {
        enforceReadOnly();
        Course::find($id)->delete();
     
        return response()->json(['success'=>'Course deleted successfully.']);
    }

    public function showBachelors(Request $request)
    {
        if ($request->ajax()) {

            $course = Course::query()->where('type', CourseTypeEnum::BACHELORS());

            return DataTables::eloquent($course)
                ->addColumn('action', function($row){
                    $btn = '<ul class="list-inline mb-0">';
                    $btn = $btn.'<li class="list-inline-item">';
                    $btn = $btn.'<a href="javascript:void(0)" data-toggle="tooltip"  data-id="'.$row->id.'" data-original-title="Edit" class="action-icon editPost"> <i class="mdi mdi-square-edit-outline"></i></a>';
                    $btn = $btn.'</li>';
                    $btn = $btn.'<li class="list-inline-item">';
                    $btn = $btn.'<a href="javascript:void(0)" data-toggle="tooltip"  data-id="'.$row->id.'" data-original-title="Delete" class="action-icon deletePost"> <i class="mdi mdi-delete"></i></a>';
                    $btn = $btn.'</li>';
                    $btn = $btn.'</ul>';
                    return $btn;
                })
                ->removeColumn('created_at')
                ->removeColumn('updated_at')
                ->editColumn('type', function($row) {
                    return $row->type;
                })
                ->editColumn('fees', function($row) {
                    if ($row->fees) {
                        'KES ' . $row->fees;
                    }
                    return null;
                })
                ->rawColumns(['action'])
                ->toJson();
        }

        return view('pages.courses.bachelors');

    }

    public function showDiploma(Request $request)
    {
        if ($request->ajax()) {

            $course = Course::query()->where('type', CourseTypeEnum::DIPLOMA());

            return DataTables::eloquent($course)
                ->addColumn('action', function($row){
                    $btn = '<ul class="list-inline mb-0">';
                    $btn = $btn.'<li class="list-inline-item">';
                    $btn = $btn.'<a href="javascript:void(0)" data-toggle="tooltip"  data-id="'.$row->id.'" data-original-title="Edit" class="action-icon editPost"> <i class="mdi mdi-square-edit-outline"></i></a>';
                    $btn = $btn.'</li>';
                    $btn = $btn.'<li class="list-inline-item">';
                    $btn = $btn.'<a href="javascript:void(0)" data-toggle="tooltip"  data-id="'.$row->id.'" data-original-title="Delete" class="action-icon deletePost"> <i class="mdi mdi-delete"></i></a>';
                    $btn = $btn.'</li>';
                    $btn = $btn.'</ul>';
                    return $btn;
                })
                ->removeColumn('created_at')
                ->removeColumn('updated_at')
                ->editColumn('type', function($row) {
                    return $row->type;
                })
                ->editColumn('fees', function($row) {
                    if ($row->fees) {
                        'KES ' . $row->fees;
                    }
                    return null;
                })
                ->rawColumns(['action'])
                ->toJson();
        }
        return view('pages.courses.diploma');
    }

}


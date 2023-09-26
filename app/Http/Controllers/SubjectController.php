<?php

namespace App\Http\Controllers;

use App\Models\Subject;
use DataTables;
use Illuminate\Http\Request;
use App\Enums\SubjectTypeEnum;
use Illuminate\Support\Facades\Auth;
use Yajra\DataTables\Html\Column;
use Yajra\DataTables\Html\Builder;
use Illuminate\Support\Facades\Validator;

class SubjectController extends Controller
{
    public function index()
    {
        
    }
    
    public function store(Request $request)
    {
        enforceReadOnly();
        if ($request->id) {
            $validator = Validator::make($request->all(), [
                'type'          => ['required', 'string', 'max:255'],
                'title'         => ['required', 'string', 'max:255'],
                'description'   => ['nullable', 'string']
            ]);
        } else {
            $validator = Validator::make($request->all(), [
                'type'          => ['required', 'string', 'max:255'],
                'title'         => ['required', 'string', 'max:255'],
                'description'   => ['nullable', 'string']
            ]);
        }

        if ($validator->fails()) {
            $errors = $validator->errors();
            return response()->json([
                    'success' => false,
                    'message' => $errors->first()
            ], 401);
        }
        
        Subject::updateOrCreate(['id' => $request->id], [
            'title'         => $request->title,
            'type'          => $request->type,
            'description'   => $request->description
        ]);        
   
        return response()->json(['success'=>'Subject saved successfully.']);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Subject
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $post = Subject::find($id);
        return response()->json($post);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Subject
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        enforceReadOnly();
        Subject::find($id)->delete();
     
        return response()->json(['success'=>'Subject deleted successfully.']);
    }

    public function showBachelors(Request $request)
    {
        if ($request->ajax()) {

            $subject = Subject::query()->where('type', SubjectTypeEnum::BACHELORS());

            return DataTables::eloquent($subject)
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
                ->editColumn('type', function($row) {
                    return $row->type;
                })
                ->rawColumns(['action'])
                ->toJson();
        }

        return view('pages.subjects.bachelors');

    }

    public function showDiploma(Request $request)
    {
        if ($request->ajax()) {

            $subject = Subject::query()->where('type', SubjectTypeEnum::DIPLOMA());

            return DataTables::eloquent($subject)
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
                ->editColumn('type', function($row) {
                    return $row->type;
                })
                ->rawColumns(['action'])
                ->toJson();
        }
        return view('pages.subjects.diploma');
    }

}

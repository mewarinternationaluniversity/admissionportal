<?php

namespace App\Http\Controllers;

use App\Models\Institute;
use DataTables;
use Illuminate\Http\Request;
use App\Enums\InstituteTypeEnum;
use App\Models\Course;
use App\Enums\CourseTypeEnum;
use Illuminate\Support\Facades\Validator;

class MappingController extends Controller
{
    public function mapBachelors(Request $request)
    {
        if ($request->ajax()) {

            if ($request->query('session')) {

                $session = $request->query('session');
    
                $bachelors = Institute::query()->with('courses')
                    ->where('type', InstituteTypeEnum::BACHELORS())
                    ->whereHas('courses', function($q) use ($session) {
                        $q->where('institutes_courses.session_id', $session);
                    });

            } else {
                $session = getCurrentSession()->id ?? null;
    
                if ($session == null) {
                    throw new \Exception("Mapping does not have a session");
                }
    
                $bachelors = Institute::query()->with('courses')
                    ->where('type', InstituteTypeEnum::BACHELORS())
                    ->whereHas('courses', function($q) use ($session) {
                        $q->where('institutes_courses.session_id', $session);
                    });
            }

            return DataTables::eloquent($bachelors)                
                ->addColumn('action', function($row){
                    return '<button id="selectCourseShow" data-id="'.$row->id.'" data-original-title="Edit courses" class="btn btn-xs btn-primary" href="javascript:void(0)">Edit courses</button>';
                })
                ->addColumn('delete', function($row){
                    return '<a href="' . route('mapping.delete', $row->id) . '" onClick="return confirm(\"Are You sure want to delete!\");" id="deleteMapping" data-id="'.$row->id.'" data-original-title="Delete Mapping" class="btn btn-xs btn-danger">Delete Mapping</a>';
                })
                ->addColumn('coursescount', function($row) use ($session){
                    //$session = getCurrentSession()->id ?? null;
                    return $row->courses()->where('institutes_courses.session_id', $session)->count();
                })
                ->removeColumn('created_at')
                ->removeColumn('updated_at')
                ->removeColumn('banner')
                ->removeColumn('sliders')
                ->removeColumn('type')
                ->removeColumn('logo')
                ->removeColumn('phone')
                ->removeColumn('description')
                ->rawColumns(['action', 'delete'])
                ->toJson();
        }
        return view('mapping.bachelors');
    }

    public function mapBachelorsInstitute(Request $request)
    {
        if ($request->ajax()) {

            if ($request->query('session')) {

                $session = $request->query('session');
    
                $bachelors = Institute::query()->with('courses')
                    ->where('type', InstituteTypeEnum::BACHELORS())
                    ->whereHas('courses', function($q) use ($session) {
                        $q->where('institutes_courses.session_id', $session);
                    });

            } else {
                $session = getCurrentSession()->id ?? null;
    
                if ($session == null) {
                    throw new \Exception("Mapping does not have a session");
                }
    
                $bachelors = Institute::query()->with('courses')
                    ->where('type', InstituteTypeEnum::BACHELORS())
                    ->whereHas('courses', function($q) use ($session) {
                        $q->where('institutes_courses.session_id', $session);
                    });
            }

            return DataTables::eloquent($bachelors)                
                ->addColumn('action', function($row){
                    return '<button id="selectCourseShow" data-id="'.$row->id.'" data-original-title="Edit courses" class="btn btn-xs btn-primary" href="javascript:void(0)">Edit courses</button>';
                })
                ->addColumn('delete', function($row){
                    return '<a href="' . route('mapping.delete', $row->id) . '" onClick="return confirm(\"Are You sure want to delete!\");" id="deleteMapping" data-id="'.$row->id.'" data-original-title="Delete Mapping" class="btn btn-xs btn-danger">Delete Mapping</a>';
                })
                ->addColumn('coursescount', function($row) use ($session){
                    //$session = getCurrentSession()->id ?? null;
                    return $row->courses()->where('institutes_courses.session_id', $session)->count();
                })
                ->removeColumn('created_at')
                ->removeColumn('updated_at')
                ->removeColumn('banner')
                ->removeColumn('sliders')
                ->removeColumn('type')
                ->removeColumn('logo')
                ->removeColumn('phone')
                ->removeColumn('description')
                ->rawColumns(['action', 'delete'])
                ->toJson();
        }
        return view('mapping.bachelors-institute');
    }


    public function mapDiploma(Request $request)
    {
        if ($request->ajax()) {

            if ($request->query('session')) {
                $diploma = Institute::query()
                    ->with('courses')
                    ->where('session_id', $request->query('session'))
                    ->where('type', InstituteTypeEnum::DIPLOMA());
            } else {
                $diploma = Institute::query()->with('courses')->where('type', InstituteTypeEnum::DIPLOMA());
            }

            return DataTables::eloquent($diploma)                
                ->addColumn('action', function($row){
                    return '<button id="selectCourseShow" data-id="'.$row->id.'" data-original-title="Edit courses" class="btn btn-xs btn-primary" href="javascript:void(0)">Edit courses</button>';
                })
                ->addColumn('coursescount', function($row){
                    return $row->courses()->count();
                })
                ->removeColumn('created_at')
                ->removeColumn('updated_at')
                ->removeColumn('banner')
                ->removeColumn('sliders')
                ->removeColumn('type')
                ->removeColumn('logo')
                ->removeColumn('phone')
                ->removeColumn('description')                
                ->rawColumns(['action'])
                ->toJson();
        }
        return view('mapping.diploma');
    }

    public function mapDiplomaBachelors(Request $request)
    {
        if ($request->ajax()) {

            $diploma = Course::query()->with('mappings')->where('type', CourseTypeEnum::DIPLOMA());

            return DataTables::eloquent($diploma)                
                ->addColumn('action', function($row){
                    return '<button id="selectCourseShow" data-id="'.$row->id.'" data-original-title="Edit diploma courses" class="btn btn-xs btn-primary" href="javascript:void(0)">Map diploma courses</button>';
                })
                ->addColumn('coursescount', function($row){
                    return $row->mappings()->count();
                })
                ->removeColumn('created_at')
                ->removeColumn('updated_at')
                ->removeColumn('type')
                ->removeColumn('description')                
                ->rawColumns(['action'])
                ->toJson();
        }
        return view('mapping.diplomabachelors');
    }

    public function mapGetCourses(Institute $institute, $session)
    {
        $courses = $institute->courses()->where('institutes_courses.session_id', $session)->get();

        return response()->json([
            'courses' => $courses,
            'id' => $institute->id
        ], 200);
    }



    public function mapCoursesCourses($id)
    {     
        $post = Course::with('mappings')->find($id);
        return response()->json($post);
    }

    public function attachCourses(Request $request)
    {
        if ($request->type == 'BACHELORS') {
            $validator = Validator::make($request->all(), [
                'id'            => ['required', 'numeric'],
                'seats'         => ['required', 'array'],
                'seats.*'       => ['required', 'numeric', 'gt:0'],
                'fees'          => ['required', 'array'],
                'fees.*'        => ['required', 'numeric', 'gt:0'],
                'session_id'    => ['required', 'numeric'],
                'type'          => ['required']
            ]);
        } else {
            $validator = Validator::make($request->all(), [
                'id'            => ['required', 'numeric'],
                'courses'       => ['required', 'array'],
                'courses.*'     => ['required', 'numeric', 'gt:0'],
                'fees'          => ['required', 'array'],
                'fees.*'        => ['required', 'numeric', 'gt:0'],
                'session_id'    => ['required', 'numeric'],
                'type'          => ['required']
            ]);
        }

        if ($validator->fails()) {
            $errors = $validator->errors();
            return response()->json([
                    'success' => false,
                    'message' => $errors->first()
            ], 401);
        }

        $institute = Institute::find($request->id);

        if (!$institute) {
            return response()->json([
                    'success' => false,
                    'message' => 'Institute not found..'
            ], 401);
        }

        if ($request->type == 'BACHELORS') {

            foreach ($request->seats as $key => $seatcount) {
                //Validate course exist
                $course = Course::find($key);
                if (!$course) {
                    return response()->json([
                            'success' => false,
                            'message' => 'Course not found..'
                    ], 401);
                }
                //If exists update pivot values
                $exists = $institute->courses()
                    ->where('institutes_courses.course_id', $course->id)
                    ->where('institutes_courses.session_id', $request->session_id)
                    ->exists();

                if ($exists) {
                    $institute->courses()->updateExistingPivot($course->id, [
                        'fees'         => $request->fees[$course->id],
                        'seats'        => $request->seats[$course->id],
                        'session_id'   => $request->session_id
                    ]);
                } else {
                    $institute->courses()->attach($course->id, [
                        'fees'         => $request->fees[$course->id],
                        'seats'        => $request->seats[$course->id],
                        'session_id'   => $request->session_id
                    ]);
                }                
            }       

        } else {
            $tosync = [];

            foreach ($request->courses as $key => $courseid) {
                //Validate course exist
                $course = Course::find($courseid);
                if (!$course) {
                    return response()->json([
                            'success' => false,
                            'message' => 'Course not found..'
                    ], 401);
                }
                $tosync[] = $course->id;
            }
            $institute->courses()->sync($tosync);
        }
   
        return response()->json(['success'=>'Institute course mapping successfully.']);
    }


    public function attachCoursesOld(Request $request)
    {
        if ($request->type == 'BACHELORS') {
            $validator = Validator::make($request->all(), [
                'id'            => ['required', 'numeric'],
                'seats'         => ['required', 'array'],
                'seats.*'       => ['required', 'numeric', 'gt:0'],
                'fees'          => ['required', 'array'],
                'fees.*'        => ['required', 'numeric', 'gt:0'],
                'session_id'    => ['required', 'numeric'],
                'type'          => ['required']
            ]);
        } else {
            $validator = Validator::make($request->all(), [
                'id'            => ['required', 'numeric'],
                'courses'       => ['required', 'array'],
                'courses.*'     => ['required', 'numeric', 'gt:0'],
                'fees'          => ['required', 'array'],
                'fees.*'        => ['required', 'numeric', 'gt:0'],
                'session_id'    => ['required', 'numeric'],
                'type'          => ['required']
            ]);
        }

        if ($validator->fails()) {
            $errors = $validator->errors();
            return response()->json([
                    'success' => false,
                    'message' => $errors->first()
            ], 401);
        }

        $institute = Institute::find($request->id);

        if (!$institute) {
            return response()->json([
                    'success' => false,
                    'message' => 'Institute not found..'
            ], 401);
        }

        if ($request->type == 'BACHELORS') {

            $tosync = [];

            foreach ($request->seats as $key => $seatcount) {
                //Validate course exist
                $course = Course::find($key);
                if (!$course) {
                    return response()->json([
                            'success' => false,
                            'message' => 'Course not found..'
                    ], 401);
                }
                $tosync[$course->id] = [
                    'seats'         => $seatcount,
                    'session_id'    => $request->session_id
                ];
            }
            $institute->courses()->sync($tosync);            

        } else {
            $tosync = [];

            foreach ($request->courses as $key => $courseid) {
                //Validate course exist
                $course = Course::find($courseid);
                if (!$course) {
                    return response()->json([
                            'success' => false,
                            'message' => 'Course not found..'
                    ], 401);
                }
                $tosync[] = $course->id;
            }
            $institute->courses()->sync($tosync);
        }

        $tosync = [];

        foreach ($request->fees as $key => $totalfees) {
            //Validate course exist
            $course = Course::find($key);
            if (!$course) {
                return response()->json([
                        'success' => false,
                        'message' => 'Course not found..'
                ], 401);
            }
            $tosync[$course->id] = [
                'fees'          => $totalfees,
                'session_id'    => $request->session_id
            ];
        }
        
        $institute->courses()->sync($tosync);
   
        return response()->json(['success'=>'Institute course mapping successfully.']);
    }
    
    public function attachCourseCourses(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'id' => ['required', 'numeric'],
            'courses' => ['required', 'array'],
            'courses.*' => ['required', 'numeric', 'gt:0']
        ]);

        if ($validator->fails()) {
            $errors = $validator->errors();
            return response()->json([
                    'success' => false,
                    'message' => $errors->first()
            ], 401);
        }

        $bachelorcourse = Course::find($request->id);

        if (!$bachelorcourse) {
            return response()->json([
                    'success' => false,
                    'message' => 'Bachelor course not found..'
            ], 401);
        }

        $tosync = [];

        foreach ($request->courses as $key => $courseid) {
            //Validate course exist
            $diplomacourse = Course::find($courseid);
            if (!$diplomacourse) {
                return response()->json([
                        'success' => false,
                        'message' => 'Diploma course not found..'
                ], 401);
            }
            $tosync[] = $diplomacourse->id;
        }
        $bachelorcourse->mappings()->sync($tosync);
   
        return response()->json(['success'=>'Bachelor/Diploma course mapping successfully.']);
    }  
}

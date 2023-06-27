<?php

namespace App\Http\Controllers\Student;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\Course;

class ApplicationController extends Controller
{
    public function startApplication()
    {
        $courses = Course::with('institutes')->paginate(4);
        return view('applications.student.start', compact('courses'));
    }

    public function stepTwo($courseId)
    {
        $courses = Course::with('institutes')->find($courseId);

        $institutes = $courses->institutes()->paginate(4);
        
        return view('applications.student.step2', compact('institutes'));
    }
}

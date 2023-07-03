<?php

use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/
Route::get('/', function(){
    return redirect()->route('dashboard');
});

Auth::routes();

Route::middleware(['auth'])->group(function () {
    Route::get('/dashboard', [App\Http\Controllers\HomeController::class, 'index'])->name('dashboard');

    Route::prefix('courses')->group(function () {  
        Route::resource('courses', App\Http\Controllers\CourseController::class, ['names' => 'courses'])->except(['show']);
        Route::get('bachelors', [App\Http\Controllers\CourseController::class, 'showBachelors'])->name('courses.bachelors');
        Route::get('diploma', [App\Http\Controllers\CourseController::class, 'showDiploma'])->name('courses.diploma');
    });

    Route::prefix('institutes')->group(function () {  
        Route::resource('institutes', App\Http\Controllers\InstituteController::class, ['names' => 'institutes'])->except(['show']);
        Route::get('bachelors', [App\Http\Controllers\InstituteController::class, 'showBachelors'])->name('institutes.bachelors');
        Route::get('diploma', [App\Http\Controllers\InstituteController::class, 'showDiploma'])->name('institutes.diploma');
    });

    Route::prefix('users')->group(function () {    
        Route::resource('users', App\Http\Controllers\UsersController::class, ['names' => 'users'])->except(['show']);
        Route::get('admins', [App\Http\Controllers\UsersController::class, 'showAdmins'])->name('users.admins');
        Route::get('managers', [App\Http\Controllers\UsersController::class, 'showManagers'])->name('users.managers');
        Route::get('students', [App\Http\Controllers\UsersController::class, 'showStudents'])->name('users.students');
    });

    Route::get('my-account', [App\Http\Controllers\UsersController::class, 'myAccount'])->name('my.account');

    Route::post('change/password',[App\Http\Controllers\UsersController::class,'updatePassword'])->name('update.password');

    Route::post('update/profile',[App\Http\Controllers\UsersController::class, 'updateProfile'])->name('update.profile');


    Route::prefix('mapping')->group(function () {
        Route::get('bachelors', [App\Http\Controllers\MappingController::class, 'mapBachelors'])->name('mapping.bachelors');
        Route::get('diploma', [App\Http\Controllers\MappingController::class, 'mapDiploma'])->name('mapping.diploma');
        Route::get('diploma/bachelors', [App\Http\Controllers\MappingController::class, 'mapDiplomaBachelors'])->name('mapping.diploma.bachelors');

        Route::get('get/{id}/courses', [App\Http\Controllers\MappingController::class, 'mapGetCourses'])->name('mapping.get.courses');

        Route::get('courses/{id}/courses', [App\Http\Controllers\MappingController::class, 'mapCoursesCourses'])->name('mapping.courses.courses');

        Route::post('/courses/attach', [App\Http\Controllers\MappingController::class, 'attachCourses'])->name('mapping.attach.courses');

        Route::post('/courses/course/attach', [App\Http\Controllers\MappingController::class, 'attachCourseCourses'])->name('mapping.course.courses');
    });

    Route::prefix('applications')->group(function () {
        // Route::prefix('admin')->group(['middleware' => ['role:admin|manager']], function () {
            
        // });

        Route::group(['middleware' => ['role:student']], function () {
            Route::get('/', [App\Http\Controllers\Student\ApplicationController::class, 'index'])->name('applications.student');
            Route::get('start', [App\Http\Controllers\Student\ApplicationController::class, 'startApplication'])->name('applications.student.start');
            Route::get('steptwo/{courseid}', [App\Http\Controllers\Student\ApplicationController::class, 'stepTwo'])->name('applications.student.steptwo');
            Route::get('stepthree/{courseid}/{instituteid}', [App\Http\Controllers\Student\ApplicationController::class, 'stepThree'])->name('applications.student.stepthree');
            Route::get('final/{courseid}/{instituteid}/{pay}', [App\Http\Controllers\Student\ApplicationController::class, 'finalApplication'])->name('applications.student.final');
        });
    });
});

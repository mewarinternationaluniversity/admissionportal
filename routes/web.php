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
});

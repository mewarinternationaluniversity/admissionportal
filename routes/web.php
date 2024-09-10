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

    // Messaging system routes
    Route::prefix('messages')->group(function () {
        Route::get('/inbox', [App\Http\Controllers\MessageController::class, 'adminInbox'])->name('admin.inbox')->middleware('role:admin');
        Route::get('/conversation', [App\Http\Controllers\MessageController::class, 'getConversation'])->name('admin.getConversation')->middleware('role:admin');
        Route::post('/send', [App\Http\Controllers\MessageController::class, 'sendMessage'])->name('message.send'); // For users to send messages
        Route::post('/reply', [App\Http\Controllers\MessageController::class, 'adminReply'])->name('message.reply')->middleware('role:admin'); // For admin to reply to users
        Route::get('/chat', [App\Http\Controllers\MessageController::class, 'userChat'])->name('messages.chat'); // Chatbox for users
    });

    Route::prefix('courses')->group(function () {  
        Route::resource('courses', App\Http\Controllers\CourseController::class, ['names' => 'courses'])->except(['show']);
        Route::get('bachelors', [App\Http\Controllers\CourseController::class, 'showBachelors'])->name('courses.bachelors');
        Route::get('diploma', [App\Http\Controllers\CourseController::class, 'showDiploma'])->name('courses.diploma');

        Route::get('institute/courses', [App\Http\Controllers\InstituteController::class, 'showDiplomaCourses'])->name('courses.diploma.institute');
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

    Route::get('student/profile/{id}', [App\Http\Controllers\UsersController::class, 'viewStudentProfile'])->name('student.profile');

    Route::post('change/password',[App\Http\Controllers\UsersController::class,'updatePassword'])->name('update.password');

    Route::post('update/profile',[App\Http\Controllers\UsersController::class, 'updateProfile'])->name('update.profile');


    Route::prefix('mapping')->group(function () {
        Route::get('bachelors', [App\Http\Controllers\MappingController::class, 'mapBachelors'])->name('mapping.bachelors');

        Route::get('institute/bachelors', [App\Http\Controllers\MappingController::class, 'mapBachelorsInstitute'])->name('mapping.bachelors.institute');

        Route::get('diploma', [App\Http\Controllers\MappingController::class, 'mapDiploma'])->name('mapping.diploma');
        Route::get('diploma/bachelors', [App\Http\Controllers\MappingController::class, 'mapDiplomaBachelors'])->name('mapping.diploma.bachelors');

        Route::get('get/{institute}/courses/{session}', [App\Http\Controllers\MappingController::class, 'mapGetCourses'])->name('mapping.get.courses');

        Route::get('delete/{id}', [App\Http\Controllers\MappingController::class, 'deleteMapping'])->name('mapping.delete');

        Route::get('courses/{id}/courses', [App\Http\Controllers\MappingController::class, 'mapCoursesCourses'])->name('mapping.courses.courses');

        Route::post('/courses/attach', [App\Http\Controllers\MappingController::class, 'attachCourses'])->name('mapping.attach.courses');

        Route::post('/courses/course/attach', [App\Http\Controllers\MappingController::class, 'attachCourseCourses'])->name('mapping.course.courses');
    });

    Route::prefix('applications')->group(function () {

        Route::group(['middleware' => ['role:admin|manager']], function () {
            Route::prefix('admin')->group(function () {
                Route::get('/', [App\Http\Controllers\Admin\ApplicationController::class, 'index'])->name('applications.admin');
                Route::get('/manager', [App\Http\Controllers\Admin\ApplicationController::class, 'manager'])->name('applications.manager');
                Route::get('/approved', [App\Http\Controllers\Admin\ApplicationController::class, 'approved'])->name('applications.manager.approved');
                Route::get('/{application}', [App\Http\Controllers\Admin\ApplicationController::class, 'edit'])->name('applications.admin.edit');
                Route::get('/status/{application}/{status}', [App\Http\Controllers\Admin\ApplicationController::class, 'changeStatus'])->name('applications.admin.changestatus');
                Route::prefix('payments')->group(function () {
                    Route::get('/all', [App\Http\Controllers\Admin\PaymentController::class, 'index'])->name('applications.admin.payments');
                    Route::get('/manager', [App\Http\Controllers\Admin\PaymentController::class, 'manager'])->name('applications.manager.payments');
                });
                Route::get('/print/admission/{application}', [App\Http\Controllers\Admin\ApplicationController::class, 'printAdmission'])->name('applications.admin.print.admission');
            });
        });

        Route::group(['middleware' => ['role:student']], function () {
            Route::prefix('student')->group(function () {
                Route::get('/', [App\Http\Controllers\Student\ApplicationController::class, 'index'])->name('applications.student');
                Route::get('start', [App\Http\Controllers\Student\ApplicationController::class, 'startApplication'])->name('applications.student.start');
                Route::get('steptwo/{courseid}', [App\Http\Controllers\Student\ApplicationController::class, 'stepTwo'])->name('applications.student.steptwo');
                Route::get('stepthree/{courseid}/{instituteid}', [App\Http\Controllers\Student\ApplicationController::class, 'stepThree'])->name('applications.student.stepthree');
                Route::get('final/{courseid}/{instituteid}/{pay}', [App\Http\Controllers\Student\ApplicationController::class, 'finalApplication'])->name('applications.student.final');
                Route::get('finalpay/{courseid}/{instituteid}/paynow', [App\Http\Controllers\Student\ApplicationController::class, 'finalApplicationPayNow'])->name('applications.student.paynow');
                
                Route::prefix('payments')->group(function () {
                    Route::get('/', [App\Http\Controllers\Student\PaymentController::class, 'index'])->name('applications.student.payments');
                    Route::post('/pay', [App\Http\Controllers\Student\PaymentController::class, 'redirectToGateway'])->name('applications.student.pay');

                    Route::get('/callback/pay', [App\Http\Controllers\Student\PaymentController::class, 'handleGatewayCallback'])->name('applications.student.callback');

                    Route::get('/stripe/{application}', [App\Http\Controllers\Student\PaymentController::class, 'stripeView'])->name('applications.student.stripe');
                });

                Route::get('/print/admission/{application}', [App\Http\Controllers\Student\ApplicationController::class, 'printAdmission'])->name('applications.student.print.admission');
            });
        });

        Route::group(['middleware' => ['role:admin|manager']], function () {
            Route::prefix('students')->group(function () {
                Route::get('/upload', [App\Http\Controllers\Admin\StudentsController::class, 'uploadView'])->name('applications.students.upload.view');
                Route::post('/upload', [App\Http\Controllers\Admin\StudentsController::class, 'upload'])->name('applications.students.upload');
                Route::get('/download', [App\Http\Controllers\Admin\StudentsController::class, 'download'])->name('applications.students.download');
            });
        });

    });

    Route::prefix('fees')->group(function () {

        Route::group(['middleware' => ['role:admin|manager']], function () {
            Route::prefix('admin')->group(function () {
                Route::get('/', [App\Http\Controllers\FeeController::class, 'index'])->name('fees.admin');
                Route::get('/manager', [App\Http\Controllers\FeeController::class, 'manager'])->name('fees.manager');
                Route::get('/approved', [App\Http\Controllers\FeeController::class, 'approved'])->name('fees.manager.approved');
                Route::get('/{application}', [App\Http\Controllers\FeeController::class, 'edit'])->name('fees.admin.edit');
                Route::get('/status/{application}/{status}', [App\Http\Controllers\FeeController::class, 'changeStatus'])->name('fees.admin.changestatus');
                Route::get('/print/{fee}', [App\Http\Controllers\FeeController::class, 'printFee'])->name('admin.fees.print');
                Route::get('/print/admission/{application}', [App\Http\Controllers\FeeController::class, 'printAdmission'])->name('fees.admin.print.admission');
                Route::get('/fee/payments', [App\Http\Controllers\FeeController::class, 'studentAdminPayments'])->name('fees.admin.payments');
            });
        });

        Route::group(['middleware' => ['role:student']], function () {
            Route::prefix('student')->group(function () {
                Route::get('/', [App\Http\Controllers\FeeController::class, 'studentIndex'])->name('fees.student');
                Route::get('/payments', [App\Http\Controllers\FeeController::class, 'studentPayments'])->name('fees.student.payments');
                Route::get('/details/{fee}', [App\Http\Controllers\FeeController::class, 'feeDetails'])->name('fees.details');
                Route::post('/pay', [App\Http\Controllers\FeeController::class, 'payFees'])->name('fees.pay');
                Route::get('/send/{fee}/{amount}', [App\Http\Controllers\FeeController::class, 'sendPayment'])->name('fees.send');
                Route::post('/pay/fee', [App\Http\Controllers\FeeController::class, 'redirectToGateway'])->name('fees.send.pay');
                Route::get('/print/{fee}', [App\Http\Controllers\FeeController::class, 'printFee'])->name('fees.print');
            });
        });

    });
});

Route::get('/get/courses/{institute}', [App\Http\Controllers\CourseController::class, 'getCourses'])->name('student.get.courses');

Route::get('/download/receipt/{payment}', [App\Http\Controllers\Student\PaymentController::class, 'download'])->name('download.receipt');

Route::group(['middleware' => ['role:manager']], function () {
    Route::prefix('students')->group(function () {
        Route::get('/institute', [App\Http\Controllers\Institute\IndexController::class, 'showStudents'])->name('manager.students.list');
        Route::get('/{id}/edit', [App\Http\Controllers\Institute\IndexController::class, 'edit'])->name('manager.students.edit');
        Route::post('/store', [App\Http\Controllers\Institute\IndexController::class, 'store'])->name('manager.students.store');
        Route::delete('/delete/{id}', [App\Http\Controllers\Institute\IndexController::class, 'destroy'])->name('manager.students.delete');
    });

    Route::get('/institute/profile', [App\Http\Controllers\Institute\IndexController::class, 'profile'])->name('manager.institute.profile');
    Route::post('/institute/profile', [App\Http\Controllers\Institute\IndexController::class, 'save'])->name('manager.institute.save');
});

Route::group(['middleware' => ['role:admin']], function () {
    Route::prefix('sessions')->group(function () {
        Route::post('/store', [App\Http\Controllers\SessionController::class, 'store'])->name('admin.sessions.store');
        Route::get('/delete/{id}', [App\Http\Controllers\SessionController::class, 'destroy'])->name('admin.sessions.delete');
    });
});

Route::get('/institute/profile/{institute}', [App\Http\Controllers\InstituteController::class, 'profile'])->name('institute.public.profile');

use Illuminate\Support\Facades\DB;

Route::get('/export-applications', function () {
    $data = DB::table('applications')
        ->join('users', 'applications.student_id', '=', 'users.id')
        ->join('institutes', 'applications.institute_id', '=', 'institutes.id')
        ->join('courses', 'applications.course_id', '=', 'courses.id')
        ->leftJoin('payments', 'applications.id', '=', 'payments.application_id')
        ->select(
            'applications.created_at',
            'users.name as student_name',
            'users.phone as student_phone',
            'institutes.title as institute_title',
            'courses.title as course_title',
            'applications.status as application_status',
            DB::raw("CASE WHEN payments.amount > 0 THEN 'Paid' ELSE 'Unpaid' END as payment_status")
        )
        ->get();

    $csvFileName = 'applications.csv';
    $headers = array(
        "Content-type" => "text/csv",
        "Content-Disposition" => "attachment; filename=$csvFileName",
        "Pragma" => "no-cache",
        "Cache-Control" => "must-revalidate, post-check=0, pre-check=0",
        "Expires" => "0"
    );

    $handle = fopen('php://output', 'w');
    fputcsv($handle, ['Submission Date', 'Student Name', 'Student Phone','Institute', 'Course', 'Application Status', 'Payment Status']);

    foreach ($data as $row) {
        fputcsv($handle, (array)$row);
    }

    fclose($handle);
})->name('applications.exportCSV');


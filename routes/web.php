<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\Admin\BatchController;
use App\Http\Controllers\Admin\CertificateRequestController;
use App\Http\Controllers\Admin\CourseCategoryController;
use App\Http\Controllers\Admin\DepartmentController;
use App\Http\Controllers\Admin\StudentController;
use App\Http\Controllers\Admin\CourseController;
use App\Http\Controllers\student\StudentController as StudentStudentController;
use App\Http\Controllers\student\StudentPageController;
use App\Http\Controllers\Admin\CollegeSelectedCourseController;
use App\Http\Controllers\student\CertificateSubmissionController;
use App\Models\CertificateRequest;
use Illuminate\Support\Facades\Route;


// Route::get('/courses', [CourseController::class, 'index']);


// Forgot Password
Route::get('/student/forgot-password', [AuthController::class, 'showForgotPasswordForm'])->name('password.request');
Route::post('/student/forgot-password', [AuthController::class, 'sendResetLink'])->name('password.email');

// Reset Password
Route::get('/student/reset-password/{token}', [AuthController::class, 'showResetPasswordForm'])->name('password.reset');
Route::post('/student/reset-password', [AuthController::class, 'resetPassword'])->name('password.update');



// Authentication Routes
Route::get('/login', [AuthController::class, 'showLoginFormStudent'])->name('login-student');
Route::post('/login', [AuthController::class, 'login']);
Route::get('/', [StudentStudentController::class, 'indexHome'])->name('student.index');

Route::prefix('admin')->group(function () {
    // Admin Dashboard (middleware 'auth' ensures only logged-in users can access this)
    Route::get('/dashboard', [AuthController::class, 'adminDashboard'])->name('dashboard')->middleware('auth');
    
    // Login Routes
    Route::get('/login', [AuthController::class, 'showLoginForm'])->name('login');
    Route::post('/login', [AuthController::class, 'login']);
    
    // Logout Route
    Route::post('/logout', [AuthController::class, 'logoutAdmin'])->name('logout');
});
// Admin Routes with Authentication Middleware
Route::prefix('admin')->middleware(['auth', 'is_admin'])->group(function () {

    // Batch Routes
    Route::controller(BatchController::class)->group(function () {
        Route::get('/batch', 'index')->name('batch.index'); 
        Route::get('/batch/create', 'create')->name('batch.create');
        Route::post('/batch', 'store')->name('batch.store'); 
        Route::get('/batch/{id}/edit', 'edit')->name('batch.edit');
        Route::put('/batch/{id}', 'update')->name('batch.update'); 
        Route::delete('/batch/{id}', 'destroy')->name('batch.destroy');
    });

    // Department Routes
    Route::controller(DepartmentController::class)->group(function () {
        Route::get('/department', 'index')->name('department.index'); 
        Route::get('/department/create', 'create')->name('department.create');
        Route::post('/department', 'store')->name('department.store'); 
        Route::get('/department/{id}/edit', 'edit')->name('department.edit');
        Route::put('/department/{id}', 'update')->name('department.update'); 
        Route::delete('/department/{id}', 'destroy')->name('department.destroy');
    });

    // Student Routes
    Route::controller(StudentController::class)->group(function () {
        Route::get('/student', 'index')->name('students.index'); 
        Route::get('/student/create', 'create')->name('students.create');
        Route::post('/student', 'store')->name('students.store'); 
        Route::get('/student/{id}/edit', 'edit')->name('students.edit');
        Route::put('/student/{id}', 'update')->name('students.update'); 
        Route::delete('/student/{id}', 'destroy')->name('students.destroy');
        Route::get('/students/export', 'export')->name('students.export');
        Route::post('/students/upload', 'upload')->name('students.upload');
    });

    // Course Routes
    Route::controller(CourseController::class)->group(function () {
        Route::get('/course', 'index')->name('admin.courses.index');
        Route::get('/course/create', 'create')->name('admin.courses.create');
        Route::post('/course', 'store')->name('admin.courses.store');
        Route::get('/course/{id}/edit', 'edit')->name('admin.courses.edit');
        Route::put('/course/{id}', 'update')->name('admin.courses.update');
        Route::delete('/course/{id}', 'destroy')->name('admin.courses.destroy');
        Route::get('/course/{id}', 'show')->name('admin.courses.show');
    });

    Route::controller(CourseCategoryController::class)->group(function(){
        Route::get('/course_categories' ,'index')->name('admin.course_categories.index');
        Route::get('/course_categories/create', 'create')->name('admin.course_categories.create');
        Route::post('/course_categories',  'store')->name('admin.course_categories.store');
        Route::delete('/course_categories/{id}',  'destroy')->name('admin.course_categories.destroy');
        Route::get('/course_categories/{id}/edit', 'edit')->name('admin.course_categories.edit');
        Route::put('/course_categories/{id}', 'update')->name('admin.course_categories.update');
    });

    Route::controller(CollegeSelectedCourseController::class)->group(function(){
        Route::get('/college-courses', 'index')->name('admin.college-courses.index');
        Route::get('/college-courses/create',  'create')->name('admin.college-courses.create');
        
        Route::get('/college-courses/{id}/edit', 'edit')->name('admin.college-courses.edit');
        Route::put('/college-courses/{id}',  'update')->name('admin.college-courses.update');
        Route::delete('/college-courses/{id}',  'destroy')->name('admin.college-courses.destroy');
        Route::post('/college-courses', 'store')->name('admin.college-courses.store');
   
        Route::get('/search-coursera-form', 'showSearchForm')->name('admin.search-course-form');
        Route::get('/search-coursera-courses', 'search')->name('admin.search-coursera-courses');
        
    });

    Route::controller(CertificateRequestController::class)->group(function () {
        Route::get('/certificate-requests', 'index')->name('admin.certificate-requests.index');
        Route::get('/certificate-requests/create', 'create')->name('admin.certificate-requests.create');
        Route::post('/certificate-requests', 'store')->name('admin.certificate-requests.store');
        Route::post('/admin/certificate-requests/{id}/close', 'close')->name('admin.certificate-requests.close');
        Route::post('/admin/certificate-requests/{id}/open', 'open')->name('admin.certificate-requests.open');
        Route::get('/certificate-requests/{id}', 'show')->name('admin.certificate-requests.show');
        Route::get('/certificate-requests/{id}/edit', 'edit')->name('admin.certificate-requests.edit');
        Route::put('/certificate-requests/{id}', 'update')->name('admin.certificate-requests.update');
        Route::delete('/certificate-requests/{id}', 'destroy')->name('admin.certificate-requests.destroy');
    });

});
Route::prefix('student')->group(function (){
    Route::controller(StudentStudentController::class)->group(function(){
        Route::get('/signup', 'index')->name('student.signup');
        Route::post('/signup', 'store')->name('student.store');
        Route::post('/send-otp', 'send')->name('otp.send');
        Route::post('/verify-otp', 'verify')->name('otp.verify');
        
        Route::get('/search-course',  'searchCourses')->name('coursesNew.search');
    });
});

Route::prefix('student')->middleware(['auth', 'is_student'])->group(function () {
    Route::controller(StudentPageController::class)->group(function () {
        Route::get('/edit/{enrollment_no}',  'edit')->name('student.edit');
        Route::put('/update/{enrollment_no}', 'update')->name('student.update');
        Route::get('/profile','showProfile')->name('student.profile');

    });
    Route::get('/student/logout', [AuthController::class, 'logoutStudent'])->name('Studentlogout');
    Route::controller(CertificateSubmissionController::class)->group(function () {
        Route::get('/certificate-requests', 'showAvailableRequests')->name('certificate-requests.index');
        Route::post('/certificate/upload', 'upload')->name('student.certificate.upload');
        Route::get('/my-certificates','index')->name('student.certificate-submissions.index');

    });
});


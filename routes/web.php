<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\Admin\BatchController;
use App\Http\Controllers\Admin\CourseCategoryController;
use App\Http\Controllers\Admin\DepartmentController;
use App\Http\Controllers\Admin\StudentController;
use App\Http\Controllers\Admin\CourseController;
use App\Http\Controllers\student\StudentController as StudentStudentController;
use App\Http\Controllers\student\StudentPageController;
use Illuminate\Support\Facades\Route;


// Route::get('/courses', [CourseController::class, 'index']);


// Login Route


// Authentication Routes
Route::get('/student/login', [AuthController::class, 'showLoginFormStudent'])->name('login-student');
Route::post('/student/login', [AuthController::class, 'login']);
Route::get('/student/logout', [AuthController::class, 'logoutStudent'])->name('Studentlogout');;
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
Route::prefix('admin')->middleware(['auth'])->group(function () {

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


});
Route::prefix('student')->group(function (){
    Route::controller(StudentStudentController::class)->group(function(){
        Route::get('/signup', 'index')->name('student.signup');
        Route::post('/signup', 'store')->name('student.store');
    });
});

Route::prefix('student')->group(function () {
    Route::controller(StudentPageController::class)->group(function () {
        Route::get('/edit/{enrollment_no}',  'edit')->name('student.edit');
        Route::put('/update/{enrollment_no}', 'update')->name('student.update');
        Route::get('/profile','showProfile')->name('student.profile');
    });
});
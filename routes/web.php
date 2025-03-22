<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\admin\BatchController;
use App\Http\Controllers\admin\DepartmentController;
use App\Http\Controllers\admin\StudentController;
use App\Http\Controllers\admin\CourseController;
use App\Http\Controllers\student\StudentController as StudentStudentController;
use App\Http\Controllers\student\StudentPageController;
use Illuminate\Support\Facades\Route;


// Route::get('/courses', [CourseController::class, 'index']);


// Login Route

Route::get('/', function () {
    return view('user.index');
});

// Authentication Routes
Route::get('/student/login', [AuthController::class, 'showLoginFormStudent'])->name('login-student');
Route::post('/student/login', [AuthController::class, 'login']);
Route::get('/student/logout', [AuthController::class, 'logoutStudent'])->name('Studentlogout');;
Route::get('/index', [StudentPageController::class, 'index'])->name('student.index');

Route::prefix('admin')->group(function () {
    // Admin Dashboard (middleware 'auth' ensures only logged-in users can access this)
    Route::get('/dashboard', [AuthController::class, 'adminDashboard'])->name('dashboard')->middleware('auth');
    
    // Login Routes
    Route::get('/login', [AuthController::class, 'showLoginForm'])->name('login');
    Route::post('/login', [AuthController::class, 'login']);
    
    // Logout Route
    Route::get('/logout', [AuthController::class, 'logoutAdmin'])->name('logout');
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
    });


});

Route::prefix('student')->group(function (){
    Route::controller(StudentStudentController::class)->group(function(){
        Route::get('/signup', 'index')->name('student.signup');
        Route::post('/signup', 'store')->name('student.store');
    });
});

Route::prefix('student')->middleware(['auth'])->group(function () {
    Route::controller(StudentPageController::class)->group(function () {
        Route::get('/index', 'index')->name('student.index');
        Route::get('/edit/{enrollment_no}',  'edit')->name('student.edit');
        Route::put('/update/{enrollment_no}', 'update')->name('student.update');
        Route::get('/profile','showProfile')->name('student.profile');
    });
});
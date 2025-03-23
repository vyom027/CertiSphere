<?php

namespace App\Http\Controllers;

use App\Models\Admin;
use App\Models\Student;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Session;

class AuthController extends Controller
{
    // Show login form
    public function showLoginForm()
    {
        // $2y$12$GIhoB6yps0yAY6mwZiXtZuueVZowoq.OhW808jjA/G0PnI2csRVjm
        // $validated = bcrypt('Admin@123');
        // echo $validated;
        // die;

        return view('user.authentication.login');
    }

    public function showLoginFormStudent(){
        // $pass = bcrypt('Vivek_27');
        // echo $pass;
        // die;

        return view('user.authentication.login');
    }
    // Handle login request
    public function login(Request $request)
    {
        
        $request->validate([
            'email' => 'required',
            'password' => 'required|min:8|max:20'
        ]);
        // Check if user exists
        $user = User::where('email', $request->email)->first();
        
        if (!$user) {
            return redirect()->back()->with('email_error', 'Email not found.');
        }

        // Check password
        if (!Hash::check($request->password, $user->password)) {
            return redirect()->back()->with('password_error', 'Incorrect password.');
        }

        // Log the user in
        Auth::login($user); 

        Session::put('user_email', $user->email);

        // Redirect based on user type
        if ($user->user_type === 'admin') {
            Session::put('admin_logged_in', true);
            
            $admin = Admin::where('email', $user->email)->first();
            if ($admin) {
                Session::put('admin_name', $admin->first_name);
                return redirect()->route('dashboard')->with('welcome_admin', 'Welcome, ' . $admin->first_name . '!');
            } else {
                return redirect()->route('dashboard')->with('welcome_admin', 'Welcome, Admin!');
            }
        } elseif ($user->user_type === 'student') {
            Session::put('student_logged_in', true);

            $student = Student::where('email', $user->email)->first();
            if ($student) {
                Session::put('student_name', $student->first_name);
                Session::put('student_profile', $student->profile_picture);
                return redirect()->route('student.index')->with('welcome_student', 'Welcome, ' . $student->first_name . '!');
            } else {
                return redirect()->route('student.index')->with('welcome_student', 'Welcome, Student!');
            }
        }

        return redirect()->back()->with('error', 'Unauthorized access.');
    }


    public function adminDashboard()
    {
        if (!Session::get('admin_logged_in')) {
            return redirect()->route('login')->with('error', 'Please log in first.');
        }
        return view('admin.dashboard');
    }

    // Logout user
    public function logoutAdmin()
    {
        Auth::logout();
        if(Session::get('admin_logged_in')){
            Session::forget('admin_logged_in');
            Session::forget('admin_name');
        }
        return redirect()->route('login-student')->with('welcome_admin', 'Welcome, Admin!');
    }
    public function logoutStudent()
    {
        Auth::logout();
        if(Session::get('student_logged_in')){
            Session::forget('student_logged_in');
            Session::forget('student_name');
        }
        return redirect()->route('student.index')->with('welcome_student', 'Welcome, User!');
    }
}

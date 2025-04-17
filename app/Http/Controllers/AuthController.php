<?php

namespace App\Http\Controllers;

use App\Models\Admin;
use App\Models\Student;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Str;
use Carbon\Carbon;
use Illuminate\Support\Facades\Password;

class AuthController extends Controller
{


   public function showForgotPasswordForm()
{
    return view('User.authentication.forgot-password'); // Make sure the path matches your file location
}

    
    public function sendResetLink(Request $request)
    {
        $request->validate(['email' => 'required|email']);
        $status = Password::sendResetLink($request->only('email'));
        
        return $status === Password::RESET_LINK_SENT
        ? back()->with(['message' => 'Reset link sent to your email.'])
        : back()->withErrors(['email' => 'Email not found.']);
        dd('call');
    }
    
    public function showResetPasswordForm($token)
    {
        return view('User.authentication.reset-password', ['token' => $token]);
    }
    
    public function resetPassword(Request $request)
    {
        $request->validate([
            'email' => 'required|email',
            'password' => 'required|min:8|confirmed',
            'token' => 'required'
        ]);
    
        $status = Password::reset(
            $request->only('email', 'password', 'password_confirmation', 'token'),
            function ($user, $password) {
                $user->password = Hash::make($password);
                $user->save();
            }
        );
    
        return $status === Password::PASSWORD_RESET
            ? redirect()->route('login-student')->with('message', 'Password reset successful.')
            : back()->withErrors(['email' => 'Invalid token or email.']);
    }
    
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
            'email' => 'required|email',
            'password' => 'required|min:8|max:20',
        ]);

        $user = User::where('email', $request->email)->first();

        if (!$user) {
            return redirect()->back()->with('email_error', 'Email not found.');
        }

        if (!Hash::check($request->password, $user->password)) {
            return redirect()->back()->with('password_error', 'Incorrect password.');
        }

        
        Auth::login($user, $request->filled('remember'));
        Session::put('user_email', $user->email);

        if ($user->user_type === 'admin') {
            $admin = Admin::where('email', $user->email)->first();
            if ($admin) {
                Session::put('admin_logged_in', true);
                Session::put('admin_name', $admin->first_name);
                return redirect()->route('dashboard')->with('welcome_admin', 'Welcome, ' . $admin->first_name . '!');
            } else {
                return redirect()->back()->with('error', 'Admin details not found.');
            }
        } elseif ($user->user_type === 'student') {
            $student = Student::where('email', $user->email)->first();
            if ($student) {
                // dd('student');
                $startYear =  $student->batch->start_year;
                // dd($startYear);
                $currentYear = now()->year;
        
                $yearsPassed = $currentYear - $startYear;
        
                $semesters = $yearsPassed * 2;
        
                if ($yearsPassed === 0) {
                    $currentMonth = now()->month;
        
                    if ($currentMonth >= 7) {
                        $semesters = 1;
                    } else {
                        $semesters = 0;
                    }
        
                } else {
                    // If the current year is past the start year, check if a semester has passed in the current year
                    $currentMonth = now()->month;
                    if ($currentMonth >= 7) {
                        $semesters++;
                    }
                }
                session(['semesters' => $semesters]);
                Session::put('student_logged_in', true);
                Session::put('student_enrollment', $student->enrollment_no);
                Session::put('student_name', $student->first_name);
                Session::put('student_profile', $student->profile_picture);
                Session::put('student_dept', $student->dept_id);
                return redirect()->route('student.index')->with('welcome_student', 'Welcome, ' . $student->first_name . '!');
            } else {
                return redirect()->back()->with('error', 'Student details not found.');
            }
        }

        return redirect()->back()->with('error', 'User type is invalid.');
    }


    public function adminDashboard()
    {
        if (!Auth::check() || Auth::user()->user_type !== 'admin') {
            return redirect()->route('login-student')->with('error', 'Unauthorized access.');
        }

        return view('admin.dashboard');
    }

    public function logoutAdmin()
    {

        Session::forget('admin_name');
        Session::forget('admin_logged_in');
        return redirect()->route('login-student')->with('logout_msg', 'Admin logged out successfully!');
    }

    public function logoutStudent()
    {
        Session::forget('semester');
        Session::forget('student_logged_in');
        Session::forget('student_name');
        Session::forget('student_profile');
        Session::forget('mail_password');
        return redirect()->route('student.index')->with('logout_msg', 'Student logged out successfully!');
    }

    
}

<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Str;
use App\Models\User;
use Carbon\Carbon;


class PasswordResetController extends Controller
{
    // Show the Forgot Password Form
    public function showForgotForm()
    {
        return view('auth.forgot-password');
    }

    // Handle sending the reset link
    public function sendResetLink(Request $request)
    {
        $request->validate(['email' => 'required|email|exists:users,email']);

        // Generate a token
        $token = Str::random(60);

        // Store token in password_resets table
        DB::table('password_resets')->insert([
            'email' => $request->email,
            'token' => $token,
            'created_at' => Carbon::now(),
        ]);

        // Send email with reset link
        $resetLink = url("/student/reset-password/{$token}");
        Mail::raw("Click here to reset your password: $resetLink", function ($message) use ($request) {
            $message->to($request->email)->subject('Reset Your Password');
        });

        return back()->with('message', 'Password reset link has been sent to your email.');
    }

    // Show the Reset Password Form
    public function showResetForm($token)
    {
        return view('auth.reset-password', compact('token'));
    }

    // Handle resetting the password
    public function resetPassword(Request $request)
    {
        $request->validate([
            'email' => 'required|email|exists:users,email',
            'password' => 'required|min:6|confirmed',
            'token' => 'required',
        ]);

        // Verify token
        $record = DB::table('password_resets')
            ->where('email', $request->email)
            ->where('token', $request->token)
            ->first();

        if (!$record) {
            return back()->withErrors(['email' => 'Invalid or expired token.']);
        }

        // Update user password
        User::where('email', $request->email)->update([
            'password' => Hash::make($request->password),
        ]);

        // Delete used token
        DB::table('password_resets')->where('email', $request->email)->delete();

        return redirect('/login')->with('message', 'Password has been reset successfully.');
    }
}


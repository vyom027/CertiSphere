<?php

namespace App\Http\Controllers\student;

use App\Http\Controllers\Controller;
use App\Models\Batch;
use App\Models\Department;
use Illuminate\Http\Request;
use App\Models\Student;
use App\Models\User;    
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Auth;
class StudentPageController extends Controller
{
    public function index()
    {
        return view('user.index');
    }

    public function showProfile()
    {
        $student = Student::where('email', Auth::user()->email)->first();
        $batches = Batch::where('batch_id', $student->batch_id)->first();
        $departments = Department::where('dept_id', $student->dept_id)->first();

        $startYear = $batches->start_year;

        // Get the current year
        $currentYear = now()->year;

        // Calculate the number of years passed
        $yearsPassed = $currentYear - $startYear;

        // Calculate the number of semesters (2 semesters per year)
        $semesters = $yearsPassed * 2;

        // If the current year is the same as the start year, check if a semester has passed
        if ($yearsPassed === 0) {
            $currentMonth = now()->month;

            // If it's the second semester (Fall), count 1 semester
            if ($currentMonth >= 7) {
                $semesters = 1;
            } else {
                $semesters = 0;
            }
        } else {
            // If the current year is past the start year, check if a semester has passed in the current year
            $currentMonth = now()->month;
            if ($currentMonth >= 7) {
                // Add 1 semester for Fall semester
                $semesters++;
            }
        }
        return view('user.profile', compact('student', 'batches', 'departments','semesters'));
    }


    public function edit($enrollment_no)
    {
        $student = Student::where('enrollment_no', $enrollment_no)->first();
        $batches = Batch::all();
        $departments = Department::all();
        return view('user.edit', compact('student', 'batches', 'departments'));
    }

    public function update(Request $request, $enrollment_no)
    {   
        //dd($request->all());
        // Find the student by enrollment number
        $student = Student::where('enrollment_no', $enrollment_no)->first();

        // Check if student exists
        if (!$student) {
            return redirect()->back()->with('error', 'Student not found!');
        }

        // Find the associated user
        $user = User::where('email', $student->email)->first();

        // Validate input data
        try {
            $validated = $request->validate([
                'first_name' => 'required|string|max:255',
                'last_name' => 'required|string|max:255',
                'phone_number' => 'required|numeric|unique:students,phone_number,' . $student->enrollment_no . ',enrollment_no',
                'batch_id' => 'required|exists:batch,batch_id',
                'dept_id' => 'required|exists:department,dept_id',
                'profile_picture' => 'nullable|image|max:10240',
                'password' => 'nullable|min:8|max:20|regex:/[a-z]/|regex:/[A-Z]/|regex:/[0-9]/|regex:/[@$!%*#?&_]/',
                'division' => 'required',
            ]);
        
            //dd($validated); // If validation passes, this should print data
        } catch (\Illuminate\Validation\ValidationException $e) {
            dd($e->errors()); // Show validation errors
        }
        ;

        // Update student details
        $student->fill([
            'first_name' => $validated['first_name'],
            'last_name' => $validated['last_name'],
            'phone_number' => $validated['phone_number'],
            'batch_id' => $validated['batch_id'],
            'dept_id' => $validated['dept_id'],
            'division' => $validated['division'],
        ]);
        
        $student->save();

        // Handle profile picture upload
        if ($request->hasFile('profile_picture')) {
            // Delete old picture
            if ($student->profile_picture) {
                Storage::delete('public/' . $student->profile_picture);
            }

            // Store and update profile picture
            $file = $request->file('profile_picture');
    
            // Generate a unique file name
            $fileName = time() . '.' . $file->getClientOriginalExtension();
        
            $destinationPath = public_path('profile_pictures');
            $file->move($destinationPath, $fileName);

            // Update the student record with the new file path (without 'public/' prefix)
            $student->update(['profile_picture' => 'profile_pictures/' . $fileName]);
        }

        // Update password if provided
        if ($request->filled('password')) {
            $hashedPassword = Hash::make($validated['password']);
            $student->update(['password' => $hashedPassword]);
            if ($user) {
                $user->update(['password' => $hashedPassword]);
            }
        }

        return redirect()->route('student.profile')->with('success', 'Profile updated successfully!');
    }

}

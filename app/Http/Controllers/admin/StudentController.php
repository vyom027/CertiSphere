<?php

namespace App\Http\Controllers\admin;

use App\Http\Controllers\Controller;
use App\Models\Batch;
use App\Models\Department;
use App\Models\Student;
use App\Models\User;
use Illuminate\Http\Request;

class StudentController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $students = Student::with('batch','department')->get();

        return view('admin.students.student-list',compact('students'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $batches = Batch::all();
        $departments = Department::all();
        return view('admin.students.add-student',compact('batches','departments'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'enrollment_no' => 'required|numeric|unique:students',
            'first_name' => 'required|string|max:255',
            'last_name' => 'required|string|max:255',
            'email' => 'required|email|unique:students',
            'phone_number' => 'required|numeric|unique:students',
            'batch_id' => 'required|exists:batch,batch_id',
            'dept_id' => 'required|exists:department,dept_id',
            'profile_picture' => 'nullable|image|max:2048',
            'password' => 'required|min:8|max:20| regex:/[a-z]/| regex:/[A-Z]/| regex:/[0-9]/| regex:/[@$!%*#?&_]/',
            'division' => 'required',
        ]);
    
        // Handle file upload
        if ($request->hasFile('profile_picture')) {
            $validated['profile_picture'] = $request->file('profile_picture')->store('profile_pictures', 'public');
        }
    
        // Hash password
        $validated['password'] = bcrypt($validated['password']);
    
        // Save the student
        $student = new Student();
        $student->enrollment_no = $validated['enrollment_no'];
        $student->first_name = $validated['first_name'];
        $student->last_name = $validated['last_name'];
        $student->email = $validated['email'];
        $student->phone_number = $validated['phone_number'];
        $student->batch_id = $validated['batch_id'];
        $student->dept_id = $validated['dept_id'];
        $student->division = $validated['division'];
        if (isset($validated['profile_picture'])) {
            $student->profile_picture = $validated['profile_picture'];
        }
        else{
            $student->profile_picture = 'profile_pictures/default.png';
        }
        $student->save();
        $user = new User();
        $user->email = $validated['email'];
        $user->password = $validated['password'];
        $user->user_type = 'Student';
        $user->save();
        return redirect()->route('students.index')->with('success', 'Student registered successfully!');
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        $student = Student::find($id);
        $batches = Batch::all();
        $departments = Department::all();
        $user = User::where('email',$student->email)->first();
        return view('admin.students.edit-student',compact('student','batches','departments','user'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $validated = $request->validate([
            'enrollment_no' => 'required|numeric|unique:students,enrollment_no,'.$id.',enrollment_no',
            'first_name' => 'required|string|max:255',
            'last_name' => 'required|string|max:255',
            'email' => 'required|email|unique:students,email,'.$id.',enrollment_no',
            'phone_number' => 'required|numeric|unique:students,phone_number,'.$id.',enrollment_no',
            'batch_id' => 'required|exists:batch,batch_id',
            'dept_id' => 'required|exists:department,dept_id',
            'profile_picture' => 'nullable|image|max:2048',
            'password' => 'min:8|max:20| regex:/[a-z]/| regex:/[A-Z]/| regex:/[0-9]/| regex:/[@$!%*#?&_]/'
        ]);

        $student = Student::findOrFail($id);
        
        $student->update([
            'enrollment_no' => $validated['enrollment_no'],
            'first_name' => $validated['first_name'],
            'last_name' => $validated['last_name'],
            'email' => $validated['email'],
            'phone_number' => $validated['phone_number'],
            'batch_id' => $validated['batch_id'],
            'dept_id' => $validated['dept_id'],
        ]);

        // Handle profile picture update
        if ($request->hasFile('profile_picture')) {
            $fileName = time().'.'.$request->file('profile_picture')->getClientOriginalExtension();
            $request->file('profile_picture')->move(public_path('profile_picture'), $fileName);
            $student->profile_picture = 'profile_picture/' . $fileName;
            $student->save();
        }

        return redirect()->route('students.index')->with('success', 'Student details updated successfully!');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $student = Student::find($id);

        if ($student) {
            $email = $student->email;

            $student->delete();

            $user = User::where('email', $email)->first();
            if ($user) {
                $user->delete();
            }
            return redirect()->route('students.index')->with('success', 'Student details updated successfully!');
            
        }
    }
}

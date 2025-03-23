<?php

namespace App\Http\Controllers\student;

use App\Models\Batch;
use App\Models\Department;
use App\Models\Student;
use App\Models\User;
use App\Http\Controllers\Controller;
use App\Models\Course;
use App\Models\CourseCategory;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Storage;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;
class StudentController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $batches = Batch::all();
        $departments = Department::all();
        return view('user.authentication.sign-up',compact('batches','departments'));
    }

    public function indexHome()
    {
        $courseCategories = CourseCategory::all();
        // dd($courseCategories);
        foreach ($courseCategories as $category) {
            $response = Http::get($category->link); 
    
            if ($response->successful()) {
                $courses = collect($response->json()); 
                $category->topCourses = $courses->take(5);
            } else {
                $category->topCourses = collect(); 
            }
        }
        // dd($category->topCourses);
        $unCourses = Course::with('courseCategory')->get();

        return view('user.index',compact('courseCategories','unCourses'))->with('welcome_student', 'Welcome, Student!');
    }


    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        
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
                'profile_picture' => 'nullable|image|max:10240',
                'password' => 'required|min:8|max:20| regex:/[a-z]/| regex:/[A-Z]/| regex:/[0-9]/| regex:/[@$!%*#?&_]/',
                'division' => 'required',
            ]);

        
        // echo "test";
        // die;
        // Handle file upload
        if ($request->hasFile('profile_picture')) {
            $file = $request->file('profile_picture');
            $fileName = time() . '.' . $file->getClientOriginalExtension();
            $file->move(public_path('profile_pictures'), $fileName);
        
            $validated['profile_picture'] = 'profile_pictures/' . $fileName;
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
        
        return view("user.authentication.login")->with('success', 'Student registered successfully!');
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
        return view('student.students.edit-student',compact('student','batches','departments','user'));
    }

    /**
     * Update the specified resource in storage.
     */
    


    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }
}

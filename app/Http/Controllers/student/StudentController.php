<?php

namespace App\Http\Controllers\student;

use App\Models\Batch;
use App\Models\Department;
use App\Models\Student;
use App\Models\User;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Cache;
use App\Models\Course;
use App\Models\CourseCategory;
use Illuminate\Support\Facades\Session;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Mail;
use App\Mail\SendOtpMail;
use App\Models\CollegeSelectedCourse;
use Illuminate\Support\Facades\Validator;

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
        if(session('student_logged_in')){
            $semester = session('semesters'); // Get semester from session
            // dd($semester);
            $student = Student::where('enrollment_no', session('student_enrollment'))->first();

            $departmentName = Department::where('dept_id', $student->dept_id)->value('name');

            $clgCourses = CollegeSelectedCourse::where('semester', $semester)
            ->where('department', $departmentName)
            ->get();
        }
        $courseCategories = CourseCategory::all();
        
        foreach ($courseCategories as $category) {
            // First, check if data exists in cache
            $cachedResponse = Cache::get("category_{$category->id}");
    
            if (!$cachedResponse) {
                // If not cached, make API request
                $httpResponse = Http::get($category->link);
                
                if ($httpResponse->successful()) {
                    $cachedResponse = $httpResponse->json();
                    Cache::put("category_{$category->id}", $cachedResponse, 50000);
                } else {
                    $cachedResponse = []; // Set empty array on failure
                }
            }
    
            // Process courses
            $courses = collect($cachedResponse);
            $category->topCourses = $courses->take(5);
        }
    
        $unCourses = Course::with('courseCategory')->get();
        if(session('student_logged_in'))
            return view('user.index', compact('courseCategories', 'unCourses','clgCourses'))->with('welcome_student', 'Welcome, Student!');
        else
            return view('user.index', compact('courseCategories', 'unCourses'))->with('welcome_student', 'Welcome, Student!');
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
            'phone_number' => 'required|numeric|unique:students|digits:10',
            'batch_id' => 'required|exists:batch,batch_id',
            'dept_id' => 'required|exists:department,dept_id',
            'profile_picture' => 'nullable|image|max:10240',
            'password' => 'required|min:8|max:20|regex:/[a-z]/|regex:/[A-Z]/|regex:/[0-9]/|regex:/[@$!%*#?&_]/',
            'division' => 'required',
        ], [
            'enrollment_no.numeric' => 'The enrollment number must be a number.',
            'enrollment_no.unique' => 'The enrollment number has already been taken.',
            'first_name.string' => 'The first name must be a string.',
            'last_name.string' => 'The last name must be a string.',
            'email.unique' => 'The email has already been taken.',
            'phone_number.numeric' => 'The phone number must be a number.',
            'phone_number.digits' => 'The phone number must be exactly 10 digits.',
            'phone_number.unique' => 'The phone number has already been taken.',
            'profile_picture.max' => 'The profile picture may not be greater than 10MB.',
            'password.min' => 'The password must be at least 8 characters.',
            'password.max' => 'The password may not be greater than 20 characters.',
            'password.regex' => 'The password must include at least one lowercase letter, one uppercase letter, one number, and one special character.',
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
        $student->verified = 'verified';
        $student->save();
        $user = new User();
        $user->email = $validated['email'];
        $user->password = $validated['password'];
        $user->user_type = 'Student';
        $user->save();
        
        return view("user.authentication.login")->with('success', 'Student registered successfully!');
        // dd('call');
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

    public function send(Request $request)
    {

        $data = $request->json()->all();

        $validator = Validator::make($data, [
            'enrollment_no' => 'required|numeric|unique:students',
            'first_name' => 'required|string|max:255',
            'last_name' => 'required|string|max:255',
            'email' => 'required|email|unique:students',
            'phone_number' => 'required|numeric|unique:students|digits:10',
            'batch_id' => 'required|exists:batch,batch_id',
            'dept_id' => 'required|exists:department,dept_id',
            'profile_picture' => 'nullable|image|max:10240',
            'password' => 'required|min:8|max:20|regex:/[a-z]/|regex:/[A-Z]/|regex:/[0-9]/|regex:/[@$!%*#?&_]/',
            'division' => 'required',
        ], [
            'enrollment_no.numeric' => 'The enrollment number must be a number.',
            'enrollment_no.unique' => 'The enrollment number has already been taken.',
            'first_name.string' => 'The first name must be a string.',
            'last_name.string' => 'The last name must be a string.',
            'email.unique' => 'The email has already been taken.',
            'phone_number.numeric' => 'The phone number must be a number.',
            'phone_number.digits' => 'The phone number must be exactly 10 digits.',
            'phone_number.unique' => 'The phone number has already been taken.',
            'profile_picture.max' => 'The profile picture may not be greater than 10MB.',
            'password.min' => 'The password must be at least 8 characters.',
            'password.max' => 'The password may not be greater than 20 characters.',
            'password.regex' => 'The password must include at least one lowercase letter, one uppercase letter, one number, and one special character.',
        ]);

        $request->validate([
            'email' => 'required|email'
        ]);

        $otp = rand(100000, 999999);
        Session::put('otp_' . $request->email, $otp);
    
        // Send Email
        Mail::to($request->email)->send(new SendOtpMail($otp));
        // Send SMS        
        return response()->json([
            'status' => 'success',
            'message' => 'OTP sent successfully',
            'otp' => $otp // optional: include it for testing/demo
        ]);

    }

    public function verify(Request $request)
    {
        $sessionOtp = Session::get('otp_' . $request->email);

        if ($sessionOtp == $request->otp) {
            Session::forget('otp_' . $request->email); // one-time use
            return response()->json(['status' => 'verified']);
        }

        return response()->json(['status' => 'failed']);
    }
   

    public function searchCourses(Request $request)
    {
        $query = $request->input('keyword');

        if (!$query) {
            return view('user.search-results', ['courses' => [], 'query' => '']);
        }

        // Check cache for this keyword, store results for 1 hour
        $cacheKey = 'courses_search_' . strtolower($query);
        $courses = Cache::remember($cacheKey, now()->addHour(), function () use ($query) {
            $response = Http::get('https://api.coursera.org/api/courses.v1', [
                'q' => 'search',
                'query' => $query,
                'limit' => 10
            ]);

            $results = [];

            if ($response->successful()) {
                $data = $response->json();

                foreach ($data['elements'] as $course) {
                    $results[] = [
                        'id' => $course['id'],
                        'name' => $course['name'],
                        'slug' => $course['slug'],
                        'link' => 'https://www.coursera.org/learn/' . $course['slug'],
                    ];
                }
            }

            return $results;
        });

        return view('user.search-results', compact('courses', 'query'));
    }

    
}

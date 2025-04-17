<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Batch;
use App\Models\Department;
use App\Models\Student;
use App\Models\User;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\StreamedResponse;
use League\Csv\Reader;
use League\Csv\Statement;
use Carbon\Carbon;

class StudentController extends Controller
{
    /**
     * Display a listing of the resource.
     */

    public function index(Request $request)
    {
        $departments = Department::all();
        $divisions = Student::distinct('division')->pluck('division');
    
        // Fetch all batches to compute all possible semesters
        $batches = Batch::all();
    
        $semesterBatchMap = [];
        foreach ($batches as $batch) {
            $startYear = $batch->start_year;
            $currentYear = now()->year;
            $yearsPassed = $currentYear - $startYear;
            $semesters = $yearsPassed * 2;
    
            $currentMonth = now()->month;
            if ($yearsPassed === 0) {
                $semesters = ($currentMonth >= 7) ? 1 : 0;
            } else {
                if ($currentMonth >= 7) {
                    $semesters++;
                }
            }
    
            if ($semesters > 0) {
                $semesterBatchMap[$semesters] = $semesters;
            }
        }
    
        $uniqueSemesters = array_unique(array_keys($semesterBatchMap));
        sort($uniqueSemesters);
    
        // Build student query with filters
        $query = Student::with('department', 'batch');
    
        if ($request->filled('dept_id')) {
            $query->where('dept_id', $request->dept_id);
        }
    
        if ($request->filled('division')) {
            $query->where('division', $request->division);
        }
    
        if ($request->filled('semester')) {
            $targetSemester = (int)$request->semester;
            $currentYear = now()->year;
            $currentMonth = now()->month;
    
            $yearsBack = intdiv($targetSemester, 2);
            $startYear = $currentYear - $yearsBack;
    
            // Adjust for odd semesters before July
            if ($targetSemester % 2 != 0 && $currentMonth < 7) {
                $startYear--;
            }
    
            $query->whereHas('batch', function ($q) use ($startYear) {
                $q->where('start_year', $startYear);
            });
        }
    
        $students = $query->paginate(30)->appends($request->except('page'));

    
        return view('admin.students.student-list', compact('students', 'departments', 'divisions', 'uniqueSemesters'));
    }
    

    private function calculateSemester($startYear)
    {
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

        return $semesters;
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
    public function export()
        {
            // Prepare the column headers for the CSV (adjust these headers as per your model fields)
            $headers = [
                'Index', 
                'First Name', 
                'Last Name', 
                'Enrollment No.', 
                'Division',
                'Email',
                'Department',
                'Batch',
                'Batch Start Year', 
                'Batch End Year',
                'Mobile No.',
                'Profile Picture',
            ];

            // Create a streamed response
            $response = new StreamedResponse(function () use ($headers) {
                // Open PHP output stream
                $output = fopen('php://output', 'w');
                
                // Write the headers to the CSV
                fputcsv($output, $headers);

                // Write student data to the CSV
                $students = Student::with('department', 'batch')->get(); // Fetch all students with their related data

                $i = 1; // Index counter
                foreach ($students as $student) {
                    $enrollment_no = '"' . (string) $student->enrollment_no . '"';
                    $row = [
                        $i,
                        $student->first_name,
                        $student->last_name,
                        $enrollment_no,
                        $student->division,
                        $student->email,
                        $student->department->name, 
                        $student->batch_id, 
                        $student->batch->start_year,
                        $student->batch->end_year,  
                        $student->phone_number,
                        $student->profile_picture,
                    ];

                    fputcsv($output, $row);
                    $i++;
                }
                fclose($output);
            });
            // Set the headers for the CSV file download
            $response->headers->set('Content-Type', 'text/csv');
            $response->headers->set('Content-Disposition', 'attachment; filename="students.csv"');

            // Return the response to prompt the download
            return $response;
        }

        public function upload(Request $request)
        {
            // Validate the file
            $request->validate([
                'csv_file' => 'required|mimes:csv,txt|max:10240', // max file size 10MB
            ]);

            if ($request->hasFile('csv_file')) {
                $file = $request->file('csv_file');
                
                $filePath = public_path('csv/' . $file->getClientOriginalName()); // Save the file in public/csv/
                
                $file->move(public_path('csv'), $file->getClientOriginalName());

                $this->importStudentsFromCsv($filePath);

                return redirect()->back()->with('success', 'Students have been uploaded successfully.');
            }


            return redirect()->back()->with('error', 'No file selected.');
        }

    // Method to import students from CSV file
    private function importStudentsFromCsv($filePath)
    {
        // Use the League\Csv library to parse the CSV file
        $csv = Reader::createFromPath($filePath, 'r');
        $csv->setHeaderOffset(0); // Set the first row as header

        // Get all rows from the CSV
        $records = (new Statement())->process($csv);

        foreach ($records as $row) {
            // Assuming your CSV columns match these
            $enrollment_no = str_replace('"', '', $row['Enrollment No.']);
            $enrollment_no = (int) $enrollment_no;
            // echo($enrollment_no);
            $existingStudent = Student::where('enrollment_no', $enrollment_no)->first();
            // If student already exists, skip to the next record
            if ($existingStudent) {
                continue; // Skip to the next record
            }
            $student = new Student();
            $student->first_name = $row['First Name'];
            $student->last_name = $row['Last Name'];
            $student->email = $row['Email'];
            $student->enrollment_no = $enrollment_no;
            $dept = $this->getDepartmentIdByName($row['Department']);
            $student->dept_id = $dept->dept_id;
            $student->phone_number = $row['Mobile No.'];
            $student->batch_id = $row['Batch'];
            $student->division = $row['Division'];
            $student->profile_picture = $row['Profile Picture'];
            $student->save();
        }
    }

    // Helper method to get department ID by name
    private function getDepartmentIdByName($departmentName)
    {
        $departmentName = trim($departmentName);
        $department = Department::where('name', $departmentName)->first();
    
        return $department; // If department not found, return null
    }
}

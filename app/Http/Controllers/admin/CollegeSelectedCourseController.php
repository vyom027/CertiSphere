<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\CollegeSelectedCourse;
use App\Models\Department;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Auth;

class CollegeSelectedCourseController extends Controller
{
    // List all courses
    public function index(Request $request)
    {
        $query = CollegeSelectedCourse::query();

        if ($request->filled('semester')) {
            $query->where('semester', $request->semester);
        }

        $courses = $query->get();

        return view('admin.college_courses.index', compact('courses'));
    }


    public function showSearchForm()
    {
        return view('admin.college_courses.search-course');
    }

    // Show form to create new course
    public function search(Request $request)
    {
        $request->validate([
            'query' => 'required|string'
        ]);

        $response = Http::get("https://api.coursera.org/api/courses.v1", [
            'q' => 'search',
            'query' => $request->query('query'),
            'fields' => 'name,slug'
        ]);

        $data = $response->json();

        if (!empty($data['elements'])) {
            $courses = $data['elements'];
            return view('admin.college_courses.search-results', compact('courses'));
        } else {
            return redirect()->back()->with('error', 'No results found for your query.');
        }
    }

    // Step 3: Create form
    public function create(Request $request)
    {
        $dept = Department::all();
        return view('admin.college_courses.create', compact('dept'));
    }


    // Store new course
    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'link' => 'required|url',
            'semester' => 'required|string',
            'department' => 'required|string',
        ]);

        // Check if course already exists
        $exists = CollegeSelectedCourse::where('name', $request->name)
                    ->where('link', $request->link)
                    ->where('semester', $request->semester)
                    ->where('department', $request->department)
                    ->exists();

        if ($exists) {
            return back()->withErrors(['duplicate' => 'Course already exists.'])->withInput();
        }

        CollegeSelectedCourse::create([
            'name' => $request->name,
            'link' => $request->link,
            'semester' => $request->semester,
            'department' => $request->department,
            'added_by' => Auth::id(),
        ]);

        return redirect()->route('admin.college-courses.index')->with('success', 'Course added successfully.');
    }

    // Show form to edit a course
    public function edit($id)
    {
        $course = CollegeSelectedCourse::findOrFail($id);
        $dept = Department::all(); // or however you're getting the departments
        return view('admin.college_courses.edit', compact('course', 'dept'));
    }
    
    // Update course
    public function update(Request $request, $id)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'link' => 'required|url',
            'semester' => 'required|string',
            'department' => 'required|string',
        ]);

        $course = CollegeSelectedCourse::findOrFail($id);
        $course->update([
            'name' => $request->name,
            'link' => $request->link,
            'semester' => $request->semester,
            'department' => $request->department,
        ]);

        return redirect()->route('admin.college-courses.index')->with('success', 'Course updated successfully.');
    }

    // Delete a course
    public function destroy($id)
    {
        $course = CollegeSelectedCourse::findOrFail($id);
        $course->delete();

        return redirect()->route('admin.college-courses.index')->with('success', 'Course deleted successfully.');
    }
    

}

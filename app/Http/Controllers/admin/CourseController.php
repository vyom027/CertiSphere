<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Course;
use App\Models\CourseCategory;

class CourseController extends Controller {
    public function index() {
        $courses = Course::with('courseCategory')->get();
        return view('admin.courses.index', compact('courses'));
    }

    public function create() {
        $courseCategories = CourseCategory::all();
        return view('admin.courses.create', compact('courseCategories'));
    }

    public function store(Request $request) {
        $request->validate([
            'name' => 'required',
            'link' => 'required|url',
            'image' => 'nullable|image|max:10240',
            'description' => 'nullable',
            'course_category_id' => 'required|exists:course_categories,id'
        ]);

        if ($request->hasFile('image')) {
            $image = $request->file('image');
            $imageName = time() . '.' . $image->getClientOriginalExtension();
            $image->move(public_path('courses'), $imageName);
            $imagePath = 'courses/' . $imageName; // Store relative path
        }
        
        // Save course details
        $course = new Course();
        $course->name = $request->name;
        $course->image = $imagePath; // Assign the correct image path
        $course->link = $request->link;
        $course->description = $request->description;
        $course->course_category_id = $request->course_category_id;
        $course->save();
        

        return redirect()->route('admin.courses.index')->with('success', 'Course added successfully!');
    }

    public function show($id) {
        $course = Course::with('courseCategory')->findOrFail($id);
        return view('admin.courses.view', compact('course'));
    }

    public function edit($id) {
        $course = Course::with('courseCategory')->findOrFail($id);
        $courseCategories = CourseCategory::all();
        return view('admin.courses.edit', compact('course', 'courseCategories'));
    }

    public function update(Request $request, $id) {
        $course = Course::with('courseCategory')->findOrFail($id);
        
        $request->validate([
            'name' => 'required',
            'link' => 'required|url',
            'image' => 'nullable|image|max:2048',
            'description' => 'nullable',
            'course_category_id' => 'required|exists:course_categories,id'
        ]);

        if ($request->hasFile('image')) {
            $image = $request->file('image');
            $imageName = time() . '.' . $image->getClientOriginalExtension();
            $image->move(public_path('courses'), $imageName);
            $imagePath = 'courses/' . $imageName; // Store relative path
        }

        $course->update([
            'name' => $request->name,
            'link' => $request->link,
            'image' => $imagePath,
            'description' => $request->description,
            'course_category_id' => $request->course_category_id
        ]);

        return redirect()->route('admin.courses.index')->with('success', 'Course updated successfully!');
    }

    public function destroy($id) {
        $course = Course::findOrFail($id);
        $course->delete();
        return redirect()->route('admin.courses.index')->with('success', 'Course deleted successfully!');
    }
}

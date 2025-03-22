<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Course;

class AdminCourseController extends Controller {
    public function index() {
        $courses = Course::all();
        return view('admin.courses.index', compact('courses'));
    }

    public function create() {
        return view('admin.courses.create');
    }

    public function store(Request $request) {
        $request->validate([
            'name' => 'required',
            'link' => 'required|url',
            'image' => 'nullable|image|max:2048',
            'description' => 'nullable'
        ]);

        $imagePath = $request->file('image') ? $request->file('image')->store('courses', 'public') : null;

        Course::create([
            'name' => $request->name,
            'link' => $request->link,
            'image' => $imagePath ? asset("storage/$imagePath") : 'https://via.placeholder.com/150',
            'description' => $request->description
        ]);

        return redirect()->route('admin.courses.index')->with('success', 'Course added successfully!');
    }

    public function edit(Course $course) {
        return view('admin.courses.edit', compact('course'));
    }

    public function update(Request $request, Course $course) {
        $request->validate([
            'name' => 'required',
            'link' => 'required|url',
            'image' => 'nullable|image|max:2048',
            'description' => 'nullable'
        ]);

        if ($request->hasFile('image')) {
            $imagePath = $request->file('image')->store('courses', 'public');
            $course->image = asset("storage/$imagePath");
        }

        $course->update([
            'name' => $request->name,
            'link' => $request->link,
            'description' => $request->description
        ]);

        return redirect()->route('admin.courses.index')->with('success', 'Course updated successfully!');
    }

    public function destroy(Course $course) {
        $course->delete();
        return redirect()->route('admin.courses.index')->with('success', 'Course deleted successfully!');
    }
}

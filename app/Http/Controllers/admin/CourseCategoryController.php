<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\CourseCategory;

class CourseCategoryController extends Controller
{
    public function index()
    {
        $courseCategories = CourseCategory::all();
        return view('admin.course_categories.index', compact('courseCategories'));
    }

    public function create()
    {
        return view('admin.course_categories.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|unique:course_categories|max:255',
            'link' => 'nullable|url|max:255',
        ]);
        $category = new CourseCategory();
        $category->name = $request->name;
        $category->link = $request->link;
        $category->save();

        return redirect()->route('admin.course_categories.index')->with('success', 'Category added successfully!');
    }

    public function destroy($id)
    {
        CourseCategory::findOrFail($id)->delete();
        return redirect()->route('admin.course_categories.index')->with('success', 'Category deleted successfully!');
    }

    public function edit($id)
    {
        $category = CourseCategory::findOrFail($id);
        return view('admin.course_categories.edit', compact('category'));
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'name' => 'required|unique:course_categories,name,' . $id . '|max:255',
            'link' => 'nullable|url|max:255',
        ]);

        $category = CourseCategory::findOrFail($id);
        $category->name = $request->name;
        $category->link = $request->filled('link') ? $request->link : $category->link; // Save existing link if not filled
        $category->save();

        return redirect()->route('admin.course_categories.index')->with('success', 'Category updated successfully!');
    }
}

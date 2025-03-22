<?php

namespace App\Http\Controllers\admin;

use App\Models\Department;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class DepartmentController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $departments = Department::get();

        return view('admin.department.department-list',compact('departments'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('admin.department.add-department');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required'
        ]);

        $record = new Department();
        $record->name = $request->name;
        $record->save();

        return redirect()->route('department.index')->with('success','Department Added Successfully');//with-flash messagee
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
        $department = Department::findOrFail($id);

        return view('admin.department.edit-department',compact('department'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $request->validate([
            'name' => 'required'
        ]);

        $dept = Department::findOrFail($id);
        $dept->update($request->all());
        return redirect()->route('department.index')->with('success', 'Department updated successfully!');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $dept = Department::findOrFail($id);
        $dept->delete();
        return redirect()->route('department.index')->with('success', 'Department deleted successfully!');
    }
}

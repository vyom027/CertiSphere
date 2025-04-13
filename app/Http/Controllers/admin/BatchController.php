<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Batch;
use App\Models\Department;
use Illuminate\Http\Request;

class BatchController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $batches = Batch::with('department')->get();

        return view('admin.batch.batch-list', compact('batches'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $departments = Department::all(); // Fetch all departments
        return view('admin.batch.add-batch', compact('departments'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'dept_id' => 'required|exists:department,dept_id',
            'start_year' => 'required|integer',
            'end_year' => 'required|integer|gt:start_year',
        ]);

        $record = new Batch();
        $record->dept_id = $request->dept_id;
        $record->start_year = $request->start_year;
        $record->end_year = $request->end_year;
        $record->save();


        return redirect()->route('batch.index')->with('success', 'Batch added successfully!');
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
        $batch = Batch::findOrFail($id);
        $departments = Department::all();
        return view('admin.batch.edit-batch', compact('batch', 'departments'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, $id)
    {
        $request->validate([
            'department_id' => 'required',
            'start_year' => 'required|numeric',
            'end_year' => 'required|numeric',
        ]);

        $batch = Batch::findOrFail($id);
        $batch->update($request->all());
        return redirect()->route('batch.index')->with('success', 'Batch updated successfully!');
    }
    /**
     * Remove the specified resource from storage.
     */
    public function destroy($id)
    {
        $batch = Batch::findOrFail($id);
        $batch->delete();
        return redirect()->route('batch.index')->with('success', 'Batch deleted successfully!');
    }
}

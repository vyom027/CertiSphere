<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\CertificateRequest;
use App\Models\Department;
use App\Models\Batch;
use Illuminate\Http\Request;

class CertificateRequestController extends Controller
{
    public function index(Request $request)
    {
        $departments = Department::all();

        $requests = CertificateRequest::with('department', 'batch');

        if ($request->has('department_id') && $request->department_id != '') {
            $requests = $requests->where('department_id', $request->department_id);
        }

        $requests = $requests->get();

        return view('admin.certificate_requests.index', compact('requests', 'departments'));
    }


    public function create()
    {
        $departments = Department::all();
        $batches = Batch::all();
        return view('admin.certificate_requests.create', compact('departments', 'batches'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'course_name' => 'required|string|max:255',
            'batch_id' => 'required|exists:batch,dept_id',
            'department_id' => 'required|exists:department,dept_id',
            'description' => 'nullable|string|max:1000',
        ]);

        CertificateRequest::create($request->all());

        return redirect()->route('admin.certificate-requests.index')->with('success', 'Certificate upload request created.');
    }

    public function close($id)
    {
        $request = CertificateRequest::findOrFail($id);
        $request->status = 'close';
        $request->save();

        return redirect()->back()->with('success', 'Certificate request closed successfully.');
    }

    public function open($id)
    {
        $request = CertificateRequest::find($id);
        $request->status = 'Open';
        $request->save();

        return redirect()->back()->with('success', 'Certificate request opened.');
    }

    public function edit($id)
    {
        $request = CertificateRequest::findOrFail($id);
        $departments = Department::all();
        $batches = Batch::all();
        return view('admin.certificate_requests.edit', compact('request', 'departments', 'batches'));
    }

    public function update(Request $request, $id)
    {
        $certificateRequest = CertificateRequest::findOrFail($id);
        
        $validatedData = $request->validate([
            'course_name' => 'required|string|max:255',
            'department_id' => 'nullable|exists:department,dept_id',
            'batch_id' => 'nullable|exists:batch,batch_id',
            'status' => 'required|in:open,close',
            'description' => 'nullable|string|max:1000',
        ]);
    
        $certificateRequest->fill($validatedData);
        // For debugging:
        // dd($certificateRequest->toArray());
    
        $certificateRequest->save();
    
        return redirect()->route('admin.certificate-requests.index')
            ->with('success', 'Certificate request updated successfully.');
    }
    

    public function show($id)
    {
        $request = CertificateRequest::with(['department', 'batch'])->findOrFail($id);
        return view('admin.certificate_requests.view', compact('request'));
    }
}

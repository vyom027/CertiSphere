<?php

namespace App\Http\Controllers\student;

use App\Http\Controllers\Controller;
use App\Models\Batch;
use App\Models\CertificateRequest;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use Illuminate\Http\Request;
use App\Models\CertificateSubmission;
use App\Models\Department;
use Carbon\Carbon;
use Illuminate\Support\Facades\Validator;

class CertificateSubmissionController extends Controller
{

    public function showAvailableRequests()
    {
        $student = Auth::user()->student;
        // dd($student);
        // dd($student->dept_id, $student->batch_id);

        $requests = CertificateRequest::where(function ($query) use ($student) {
            $query->whereNull('department_id')
                ->orWhere('department_id', $student->dept_id);
        })->where(function ($query) use ($student) {
            $query->whereNull('batch_id')
                ->orWhere('batch_id', $student->batch_id);
        })->where('status', 'open')->paginate(10);

        // dd($requests);

        return view('user.certificate_requests.index', compact('requests'));
    }


    public function upload(Request $request)
    {
        $student = Auth::user()->student;
        
        // Validate the incoming request
        $validator = Validator::make($request->all(), [
            'certificate_request_id' => 'required|exists:certificate_requests,id',
            'enrollment_no' => 'exists:students,enrollment_no',
            'batch_id' => 'exists:batches,batch_id',
            'dept_id' => 'exists:departments,dept_id',
            'division' => 'string',
            'certificate_file' => 'required|mimes:pdf|max:100', 
        ]);
    
        if ($validator->fails()) {
            return redirect()->back()
                ->withErrors($validator->errors()->get('certificate_file'))
                ->withInput([
                    'certificate_request_id' => $request->certificate_request_id,
                    'course_name' => $request->course_name,
                ]);
        }
    
        $certificateRequestId = $request->certificate_request_id;
        $enrollmentNo = $student->enrollment_no;
        $batchId = $student->batch_id;
        $deptId = $student->dept_id;
        $division = $student->division;
        $file = $request->file('certificate_file');
    
        $batch = Batch::where('batch_id', $batchId)->first();
        $department = Department::where('dept_id', $deptId)->first();
    
        $batchRange = "{$batch->start_year}-{$batch->end_year}";
        $departmentName = strtolower($department->name); 
    
        $path = "certificates/{$departmentName}/{$batchRange}/{$division}/";
    
        $extension = $file->getClientOriginalExtension();
        $originalFileName = pathinfo($file->getClientOriginalName(), PATHINFO_FILENAME);
        $fileName = $originalFileName . '.' . $extension;
    
        $filePath = $file->storeAs($path, $fileName, 'public');
    
        $certificateSubmission = new CertificateSubmission();
        $certificateSubmission->certificate_request_id = $certificateRequestId;
        $certificateSubmission->enrollment_no = $enrollmentNo;
        $certificateSubmission->batch_id = $batchId;
        $certificateSubmission->dept_id = $deptId;
        $certificateSubmission->division = $division;
        $certificateSubmission->certificate_file = "storage/{$filePath}";
        $certificateSubmission->submitted_at = Carbon::now();
        $certificateSubmission->status = 'Not Approved'; 
        $certificateSubmission->save();
    
        return redirect()->back()->with('success', 'Certificate file uploaded successfully.');
    }

    

}
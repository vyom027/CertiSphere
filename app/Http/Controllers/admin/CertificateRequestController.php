<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\CertificateRequest;
use App\Models\Department;
use App\Models\Batch;
use Illuminate\Support\Facades\DB;

use App\Models\CertificateSubmission;
use App\Models\Student;
use App\Notifications\CertificateRequestPublished;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Notification;

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

        $certificateRequest = CertificateRequest::create($request->all());

        // Retrieve students in the given batch and department
        $students = Student::where('batch_id', $request->batch_id)
                            ->where('dept_id', $request->department_id)
                            ->get();
    
        // Send email to all students
        Notification::send($students, new CertificateRequestPublished($certificateRequest));

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

    public function destroy($id)
    {
        $request = CertificateRequest::findOrFail($id);
        $request->delete();

        return redirect()->route('admin.certificate-requests.index')->with('success', 'Certificate request deleted successfully.');
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
        return view('admin.certificate_requests.view', compact('certificate_request'));
    }

    public function list(Request $request)
    {
        $filters = [
            'department' => $request->department,
            'batch_id' => $request->batch_id,
            'division' => $request->division,
            'certificate_name' => $request->certificate_name,
        ];

        $baseSelect = [
            'students.enrollment_no',
            'students.first_name',
            'students.last_name',
            'students.dept_id',
            'students.batch_id',
            'students.division',
            'certificate_submissions.id as submission_id',
            'certificate_submissions.certificate_request_id',
            'certificate_submissions.status',
            'certificate_submissions.certificate_file',
            'certificate_submissions.created_at as submission_created_at',
            'certificate_requests.course_name',
            'certificate_requests.id as course_id'
        ];

        // $certificateNames = DB::table('certificate_requests')
        // ->select('course_name')
        // ->distinct()
        // ->pluck('course_name');

        $certificateNames = DB::table('certificate_requests')
        ->when(!empty($filters['department']), function ($query) use ($filters) {
            $query->where('certificate_requests.department_id', $filters['department']);
        })
        ->when(!empty($filters['batch_id']), function ($query) use ($filters) {
            $query->where('certificate_requests.batch_id', $filters['batch_id']);
        })
        ->select('course_name')
        ->distinct()
        ->pluck('course_name');
    

        // Helper function for filters
        $applyFilters = function ($query) use ($filters) {
            if (!empty($filters['department'])) {
                $query->where('students.dept_id', $filters['department']);
            }
            if (!empty($filters['batch_id'])) {
                $query->where('students.batch_id', $filters['batch_id']);
            }
            if (!empty($filters['division'])) {
                $query->where('students.division', $filters['division']);
            }
            if (!empty($filters['certificate_name'])) {
                $query->where('certificate_requests.course_name', $filters['certificate_name']);
            }
        };

        // 1. Approved
        $approvedStudents = DB::table('students')
            ->join('certificate_submissions', 'students.enrollment_no', '=', 'certificate_submissions.enrollment_no')
            ->join('certificate_requests', 'certificate_submissions.certificate_request_id', '=', 'certificate_requests.id')
            ->select($baseSelect)
            ->where('certificate_submissions.status', 'Approved')
            ->tap($applyFilters)
            ->paginate(30);

        // 2. Not Approved (Pending)
        $notApprovedStudents = DB::table('students')
            ->join('certificate_submissions', 'students.enrollment_no', '=', 'certificate_submissions.enrollment_no')
            ->join('certificate_requests', 'certificate_submissions.certificate_request_id', '=', 'certificate_requests.id')
            ->select($baseSelect)
            ->where('certificate_submissions.status', 'Not Approved')
            ->tap($applyFilters)
            ->paginate(30);

        // 3. Rejected
        $rejectedStudents = DB::table('students')
            ->join('certificate_submissions', 'students.enrollment_no', '=', 'certificate_submissions.enrollment_no')
            ->join('certificate_requests', 'certificate_submissions.certificate_request_id', '=', 'certificate_requests.id')
            ->select($baseSelect)
            ->where('certificate_submissions.status', 'Rejected')
            ->tap($applyFilters)
            ->paginate(30);

        // 4. Not Uploaded
        $notUploadedStudents = DB::table('students')
        ->join('certificate_requests', function ($join) use ($filters) {
            $join->on(DB::raw(1), '=', DB::raw(1)); // cross join logic
        })
        ->where(function ($query) use ($filters) {
            if (!empty($filters['department'])) {
                $query->where('students.dept_id', $filters['department']);
            }
            if (!empty($filters['batch_id'])) {
                $query->where('students.batch_id', $filters['batch_id']);
            }
            if (!empty($filters['division'])) {
                $query->where('students.division', $filters['division']);
            }
        })
        ->where(function ($query) use ($filters) {
            if (!empty($filters['certificate_name'])) {
                $query->where('certificate_requests.course_name', $filters['certificate_name']);
            }
        })
        ->whereNotExists(function ($query) {
            $query->select(DB::raw(1))
                ->from('certificate_submissions')
                ->whereColumn('certificate_submissions.enrollment_no', 'students.enrollment_no')
                ->whereColumn('certificate_submissions.certificate_request_id', 'certificate_requests.id');
        })
        ->selectRaw('
            students.enrollment_no,
            students.first_name,
            students.last_name,
            students.dept_id,
            students.batch_id,
            students.division,
            NULL as submission_id,
            NULL as certificate_request_id,
            NULL as status,
            NULL as certificate_file,
            NULL as submission_created_at,
            certificate_requests.course_name,
            certificate_requests.id as course_id
        ')
        ->paginate(30);
    

        // Filters for UI
        $departments = Department::all();
        $batches = Batch::all();
        $divisions = DB::table('students')->distinct()->pluck('division');

            // dd($certificateNames); // add this temporarily

        return view('admin.certificate_requests.list', [
            'approvedStudents' => $approvedStudents,
            'notApprovedStudents' => $notApprovedStudents,
            'rejectedStudents' => $rejectedStudents,
            'notUploadedStudents' => $notUploadedStudents,
            'departments' => $departments,
            'batches' => $batches,
            'divisions' => $divisions,
            'certificateNames' => $certificateNames,
        ]);
    }


    public function approveCertificate($id)
    {
        // Find the certificate submission by ID
        $submission = CertificateSubmission::find($id);

        // Check if the submission exists
        if (!$submission) {
            return redirect()->back()->with('error', 'Certificate submission not found.');
        }

        // Update the status to approved
        $submission->status = 'Approved';
        $submission->save();

        return redirect()->back()->with('success', 'Certificate request approved successfully.');
    }

    // Reject Certificate
    public function rejectCertificate($id)
    {
        // Find the certificate submission by ID
        $submission = CertificateSubmission::find($id);

        // Check if the submission exists
        if (!$submission) {
            return redirect()->back()->with('error', 'Certificate submission not found.');
        }

        // Update the status to rejected
        $submission->status = 'Rejected';
        $submission->save();

        return redirect()->back()->with('success', 'Certificate request rejected successfully.');
    }


}

<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Models\Department;
use App\Models\Batch;
use App\Models\CertificateRequest;
use App\Models\CertificateSubmission;
use App\Models\Student;
use Barryvdh\DomPDF\Facade\Pdf;


class ReportController extends Controller
{
    public function certificateReport(Request $request)
    {
        $deptId = $request->input('dept_id');
    
        // Fetch filters for dropdown
        $departments = Department::all();
        $batches = Batch::when($deptId, function ($q) use ($deptId) {
            $q->where('dept_id', $deptId);
        })->orderBy('start_year')->get();
    
        // Fetch all students
        $studentsQuery = Student::query();
        if ($deptId) {
            $studentsQuery->where('dept_id', $deptId);
        }
        $students = $studentsQuery->get();
    
        // Group by batch and division
        $studentsGrouped = $students->groupBy(['batch_id', 'division']);
    
        // Fetch certificate requests
        $requests = CertificateRequest::query();
        if ($deptId) {
            $requests->where('department_id', $deptId);
        }
        $requests = $requests->get()->groupBy('batch_id');
    
        // Get all certificate submissions
        $submissions = CertificateSubmission::all();
    
        // Map submissions for quick lookup
        $submittedMap = [];
        foreach ($submissions as $submission) {
            $submittedMap[$submission->enrollment_no][$submission->certificate_request_id] = true;
        }
    
        // Generate Report
        $report = [];
    
        foreach ($studentsGrouped as $batchId => $divisions) {
            foreach ($divisions as $division => $studentsInGroup) {
                foreach ($studentsInGroup as $student) {
                    $studentRequests = $requests[$batchId] ?? collect();
                    foreach ($studentRequests as $request) {
                        $hasSubmitted = !empty($submittedMap[$student->enrollment_no][$request->id]);
                        if (!$hasSubmitted) {
                            $report[$batchId][$division][$request->course_name] = ($report[$batchId][$division][$request->course_name] ?? 0) + 1;
                        }
                    }
                }
            }
        }
    
        return view('admin.report.report-list', compact('departments', 'batches', 'report'));
    }
    
    public function downloadSubmissionReport(Request $request)
    {
        $departmentId = $request->department_id;
        $batchId = $request->batch_id;
    
        // Fetch all relevant courses (certificate requests)
        $courses = CertificateRequest::where('department_id', $departmentId)
                        ->where('batch_id', $batchId)
                        ->pluck('course_name', 'id');
    
        // Fetch all course IDs from the certificate requests
        $coursesIds = $courses->keys()->toArray();
    
        // Fetch all students for the department and batch, sorted by division (A→Z)
        $students = Student::where('dept_id', $departmentId)
                        ->where('batch_id', $batchId)
                        ->orderBy('division')
                        ->orderBy('first_name')
                        ->get();
    
        // Fetch all submissions for the courses and students
        $submissions = CertificateSubmission::whereIn('enrollment_no', $students->pluck('enrollment_no'))
                        ->whereIn('certificate_request_id', $coursesIds)
                        ->get();
    
        // Map submissions for quick check (using enrollment_no and certificate_request_id)
        $submittedMap = $submissions->map(function($submission) {
            return $submission->student->enrollment_no . '-' . $submission->certificate_request_id;
        })->toArray();
    
        // Initialize totals for each course
        $submittedCount = [];
        $totalSubmitted = [];
        $totalNotSubmitted = [];
    
        // Calculate the total submitted and not submitted for each course
        foreach ($coursesIds as $cid) {
            $count = $submissions->where('certificate_request_id', $cid)->count();
            $submittedCount[$cid] = $students->count();
            $totalSubmitted[$cid] = $count;
            $totalNotSubmitted[$cid] = $students->count() - $count;
        }
    
        // Group students by division for better report display
        $grouped = $students->groupBy('division');
    
        // Return the view with all necessary data
        
        // ✅ Generate PDF
        $pdf = Pdf::loadView('admin.report.submission_report', [
            'students' => $students,
            'courses' => $courses,
            'coursesIds' => $coursesIds,
            'submittedMap' => $submittedMap,
            'submittedCount' => $submittedCount,
            'totalSubmitted' => $totalSubmitted,
            'totalNotSubmitted' => $totalNotSubmitted,
            'grouped' => $grouped,
        ]);
    
        return $pdf->download('submission_report.pdf');
    }
    
    
}    

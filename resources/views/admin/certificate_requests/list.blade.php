<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="utf-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
  
  <title>
    Certificate Submissions | LJKU
  </title>
  @include('admin.components.links')  <style>
    .table-responsive {
      padding: 0 1rem;
    }
    
    .status-badge {
      padding: 0.35rem 0.65rem;
      border-radius: 6px;
      font-size: 0.75rem;
      font-weight: 600;
    }
    
    .status-pending {
      background-color: #fff3cd;
      color: #856404;
    }
    
    .status-approved {
      background-color: #d4edda;
      color: #155724;
    }
    
    .status-rejected {
      background-color: #f8d7da;
      color: #721c24;
    }
    
    .filter-form {
      background: white;
      padding: 1.5rem;
      border-radius: 0.5rem;
      margin-bottom: 1.5rem;
      box-shadow: 0 0.125rem 0.25rem rgba(0, 0, 0, 0.075);
    }
    
    .filter-form select {
      border-radius: 0.375rem;
      border: 1px solid #dee2e6;
      padding: 0.5rem;
    }
    
    .filter-form .btn {
      padding: 0.5rem 1.5rem;
    }
  </style>
</head>

<body class="g-sidenav-show bg-gray-100">
  <div class="min-height-300 bg-dark position-absolute w-100"></div>
  
  <aside class="sidenav bg-white navbar navbar-vertical navbar-expand-xs border-0 border-radius-xl my-3 fixed-start ms-4" id="sidenav-main">
    @include('admin.components.sidebar')
  </aside>

  <main class="main-content position-relative border-radius-lg">
    <nav class="navbar navbar-main navbar-expand-lg px-0 mx-4 shadow-none border-radius-xl" id="navbarBlur" data-scroll="false">
      <div class="container-fluid py-1 px-3">
        <nav aria-label="breadcrumb">
          <ol class="breadcrumb bg-transparent mb-0 pb-0 pt-1 px-0 me-sm-6 me-5">
            <li class="breadcrumb-item text-sm"><a class="opacity-5 text-white" href="javascript:;">Pages</a></li>
            <li class="breadcrumb-item text-sm text-white active" aria-current="page">Certificate Submissions</li>
          </ol>
          <h6>Certificate Submissions</h6>
        </nav>
      </div>
    </nav>

    <div class="container-fluid py-4">
      <div class="row">
        <div class="col-12">
          <!-- Filter Form -->
          <form method="GET" action="{{ route('admin.certificate-requests.list') }}" class="filter-form">
            <div class="row g-3">
                <!-- Department Filter -->
                <div class="col-md-2">
                    <select name="department" class="form-control">
                        <option value="" disabled selected>Department</option>
                        @foreach($departments as $department)
                            <option value="{{ $department->dept_id }}" 
                                {{ request('department', 1) == $department->dept_id ? 'selected' : '' }}>
                                {{ $department->name }}
                            </option>
                        @endforeach
                    </select>
                </div>
        
                <!-- Semester/Batch Filter -->
                <div class="col-md-2">
                    <select name="batch_id" class="form-control">
                        <option value="" disabled selected>Semester</option>
                        @php
                            $semestersList = [];
                            $semesterBatchMap = []; // To store mapping of semester to batch_id
                        @endphp
        
                        @foreach($batches as $batch)
                            @php
                                $startYear = $batch->start_year;
                                $currentYear = now()->year;
                                $yearsPassed = $currentYear - $startYear;
                                $semesters = $yearsPassed * 2;
        
                                if ($yearsPassed === 0) {
                                    $currentMonth = now()->month;
                                    if ($currentMonth >= 7) {
                                        $semesters = 1;
                                    } else {
                                        $semesters = 0;
                                    }
                                } else {
                                    $currentMonth = now()->month;
                                    if ($currentMonth >= 7) {
                                        $semesters++;
                                    }
                                }
        
                                if ($semesters != 0) {
                                    if (!isset($semesterBatchMap[$semesters])) {
                                        $semesterBatchMap[$semesters] = $batch->batch_id;
                                    }
                                }
                            @endphp
                        @endforeach
        
                        @php
                            // Filter out unique semesters
                            $uniqueSemesters = array_unique(array_keys($semesterBatchMap));
                            $defaultBatchId = reset($semesterBatchMap); // Get the first batch_id if available
                        @endphp
        
                        @foreach($uniqueSemesters as $semester)
                            <option value="{{ $semesterBatchMap[$semester] }}" 
                                {{ request('batch_id', $defaultBatchId) == $semesterBatchMap[$semester] ? 'selected' : '' }}>
                                Semester {{ $semester }}
                            </option>
                        @endforeach
                    </select>
                </div>
        
                <!-- Division Filter -->
                <div class="col-md-2">
                    <select name="division" class="form-control">
                        <option value="" disabled selected>Division</option>
                        @foreach($divisions as $division)
                            <option value="{{ $division }}" 
                                {{ request('division', $divisions->first()) == $division ? 'selected' : '' }}>
                                {{ $division }}
                            </option>
                        @endforeach
                    </select>
                </div>
        
                <!-- Certificate Name Filter -->
                <div class="col-md-2">
                    <select name="certificate_name" class="form-control">
                        <option value="" {{ request('certificate_name') ? '' : 'selected' }}>All Certificates</option>
                        @foreach($certificateNames as $certificateName)
                            <option value="{{ $certificateName }}" 
                                {{ request('certificate_name') == $certificateName ? 'selected' : '' }}>
                                {{ $certificateName }}
                            </option>
                        @endforeach
                        
                    </select>
                </div>
        
                <!-- Status Filter -->
                <div class="form-group col-md-2">
                    <select name="certificate_request_status" class="form-control">
                        <option value="" disabled selected>Status</option>
                        <option value="Approved" 
                            {{ request('certificate_request_status', 'Approved') == 'Approved' ? 'selected' : '' }}>
                            Approved
                        </option>
                        <option value="Not Approved" 
                            {{ request('certificate_request_status', 'Not Approved') == 'Not Approved' ? 'selected' : '' }}>
                            Pending
                        </option>
                        <option value="Not Uploaded" 
                            {{ request('certificate_request_status', 'Not Uploaded') == 'Not Uploaded' ? 'selected' : '' }}>
                            Not Uploaded
                        </option>
                        <option value="Rejected" 
                            {{ request('certificate_request_status', 'Rejected') == 'Rejected' ? 'selected' : '' }}>
                            Rejected
                        </option>
                    </select>
                </div>
        
                <!-- Filter Button -->
                <div class="col-md-2">
                    <button type="submit" class="btn btn-primary w-100">
                        <i class="fas fa-filter me-2"></i>Filter
                    </button>
                </div>
            </div>
        </form>
        <div style="margin-top: 00px"></div>
       @php
    $statusFilter = request('certificate_request_status', 'Not Approved');
@endphp

{{-- Approved --}}
@if ($statusFilter === 'Approved')
    <h4 class="mt-5" style="color: white">✅ Approved Submissions</h4>
    @include('admin.certificate_requests.partials.table', ['students' => $approvedStudents])
@endif

{{-- Not Approved (Pending) --}}
@if ($statusFilter === 'Not Approved')
    <h4 class="mt-5" style="color: white">🕒 Pending Approvals</h4>
    @include('admin.certificate_requests.partials.table', ['students' => $notApprovedStudents])
@endif

{{-- Rejected --}}
@if ($statusFilter === 'Rejected')
    <h4 class="mt-5" style="color: white">❌ Rejected Submissions</h4>
    @include('admin.certificate_requests.partials.table', ['students' => $rejectedStudents])
@endif

{{-- Not Uploaded --}}
@if ($statusFilter === 'Not Uploaded')
    <h4 class="mt-5" style="color: white">📭 Not Uploaded Yet</h4>
    @include('admin.certificate_requests.partials.table', ['students' => $notUploadedStudents])
@endif

          
          </div>
        </div>
      </div>
    </div>
  </main>

  <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
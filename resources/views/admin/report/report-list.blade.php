<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="utf-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
  
  <title>
    Certificate Report | LJKU
  </title>
  @include('admin.components.links')
  <style>
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

    .card {
      border: none;
      box-shadow: 0 0.125rem 0.25rem rgba(0, 0, 0, 0.075);
      margin-bottom: 1.5rem;
    }

    .card-header {
      background: linear-gradient(87deg, #5e72e4 0, #825ee4 100%) !important;
      border-radius: 0.5rem 0.5rem 0 0 !important;
    }

    .table {
      margin-bottom: 0;
    }

    .table thead th {
      background-color: #f8f9fa;
      border-bottom: 2px solid #dee2e6;
      font-weight: 600;
      text-transform: uppercase;
      font-size: 0.75rem;
      letter-spacing: 0.025em;
    }

    .table td {
      vertical-align: middle;
    }

    .download-btn {
      background: linear-gradient(87deg, #5e72e4 0, #825ee4 100%);
      border: none;
      color: white;
      padding: 0.5rem 1.5rem;
      border-radius: 0.375rem;
      transition: all 0.2s ease;
    }

    .download-btn:hover {
      transform: translateY(-1px);
      box-shadow: 0 0.5rem 1rem rgba(0, 0, 0, 0.15);
    }

    .search-box {
      background: rgba(255, 255, 255, 0.1);
      border: none;
      border-radius: 0.375rem;
      padding: 0.5rem 1rem;
      color: white;
    }

    .search-box::placeholder {
      color: rgba(255, 255, 255, 0.8);
    }

    .search-box:focus {
      background: rgba(255, 255, 255, 0.2);
      color: white;
    }
  </style>
  <!-- CSS Files -->
  <link id="pagestyle" href="{{ asset('admin/css/argon-dashboard.css?v=2.1.0') }} " rel="stylesheet" />
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
            <li class="breadcrumb-item text-sm text-white active" aria-current="page">Reports</li>
          </ol>
          <h6 class="font-weight-bolder text-white mb-0">Certificate Reports</h6>
        </nav>
        <div class="collapse navbar-collapse mt-sm-0 mt-2 me-md-0 me-sm-4" id="navbar">
          <div class="ms-md-auto pe-md-3 d-flex align-items-center">
            <div class="input-group">
              <span class="input-group-text text-body"><i class="fas fa-search" aria-hidden="true"></i></span>
              <input type="text" class="form-control search-box" placeholder="Search...">
            </div>
          </div>
        </div>
      </div>
    </nav>

    <div class="container-fluid py-4">
      <div class="row">
        <div class="col-12">
          <!-- Filter Form -->
          <form method="GET" action="{{ route('admin.certificate.report') }}" class="filter-form">
            <div class="row g-3">
              <div class="col-md-4">
                <label for="department_filter" class="form-label">Department</label>
                <select id="department_filter" name="dept_id" class="form-control" onchange="this.form.submit()">
                  <option value="">All Departments</option>
                  @foreach($departments as $department)
                    <option value="{{ $department->dept_id }}" {{ request('dept_id') == $department->dept_id ? 'selected' : '' }}>
                      {{ $department->name }}
                    </option>
                  @endforeach
                </select>
              </div>
            </div>
          </form>

          <!-- Download Report Form -->
          <form action="{{ route('admin.submission.report') }}" method="POST" class="filter-form">
            @csrf
            <div class="row g-3">
              <div class="col-md-4">
                <label for="download_dept" class="form-label">Department</label>
                <select id="download_dept" name="department_id" class="form-control" required>
                  <option value="">Select Department</option>
                  @foreach($departments as $dept)
                    <option value="{{ $dept->dept_id }}">{{ $dept->name }}</option>
                  @endforeach
                </select>
              </div>
              {{-- <div class="col-md-4">
                <label for="download_batch" class="form-label">Batch</label>
                <select id="download_batch" name="batch_id" class="form-control" required>
                  <option value="">Select Batch</option>
                  @foreach($batches as $batch)
                    <option value="{{ $batch->batch_id }}">{{ $batch->start_year }}</option>
                  @endforeach
                </select>
              </div>
               --}}
               <div class="col-md-2">
                <label for="download_batch" class="form-label">Semester</label>

                <select name="batch_id" class="form-control" required>
                    <option value="" disabled selected>Semester</option>
            
                    @php
                        $semesterBatchMap = [];
            
                        foreach ($batches as $batch) {
                            $startYear = $batch->start_year;
                            $currentYear = now()->year;
                            $yearsPassed = $currentYear - $startYear;
                            $semesters = $yearsPassed * 2;
            
                            $currentMonth = now()->month;
                            if ($yearsPassed === 0) {
                                $semesters = ($currentMonth >= 7) ? 1 : 0;
                            } else {
                                if ($currentMonth >= 7) {
                                    $semesters++;
                                }
                            }
            
                            if ($semesters != 0 && !isset($semesterBatchMap[$semesters])) {
                                $semesterBatchMap[$semesters] = $batch->batch_id;
                            }
                        }
            
                        $uniqueSemesters = array_unique(array_keys($semesterBatchMap));
                        $defaultBatchId = request('batch_id', reset($semesterBatchMap));
                    @endphp
            
                    @foreach($uniqueSemesters as $semester)
                        <option value="{{ $semesterBatchMap[$semester] }}"
                            {{ $defaultBatchId == $semesterBatchMap[$semester] ? 'selected' : '' }}>
                            Semester {{ $semester }}
                        </option>
                    @endforeach
                </select>
            </div>
            
              
               <div class="col-md-4 d-flex align-items-end">
                <button type="submit"  class="btn download-btn w-100" style="color: white;margin-top:32px">
                  <i class="fas fa-download me-2"></i>Download Report PDF
                </button>
              </div>
            </div>
          </form>

          <!-- Report Tables -->
          @foreach($report as $batchId => $divisions)
            @php
              $batch = $batches->firstWhere('batch_id', $batchId);
            @endphp
            <div class="card">
              <div class="card-header">
                <h6 class="mb-0 text-white">
                  <i class="fas fa-calendar-alt me-2"></i>
                  Batch (Semester): {{ $batch->start_year }} - {{ $batch->end_year }}
                </h6>
              </div>
              <div class="card-body">
                <div class="table-responsive">
                  @php
                    $allCourses = collect($divisions)->flatMap(fn($d) => array_keys($d))->unique();
                  @endphp
                  <table class="table table-bordered text-center">
                    <thead>
                      <tr>
                        <th>Division</th>
                        @foreach($allCourses as $courseName)
                          <th>{{ $courseName }}</th>
                        @endforeach
                      </tr>
                    </thead>
                    <tbody>
                      @foreach($divisions as $division => $courseCounts)
                        <tr>
                          <td class="font-weight-bold">{{ $division }}</td>
                          @foreach($allCourses as $courseName)
                            <td>{{ $courseCounts[$courseName] ?? 0 }}</td>
                          @endforeach
                        </tr>
                      @endforeach
                    </tbody>
                  </table>
                </div>
              </div>
            </div>
          @endforeach
        </div>
      </div>
    </div>
  </main>

  <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
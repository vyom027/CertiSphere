<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="utf-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
  <link rel="apple-touch-icon" sizes="76x76" href="{{asset('admin//apple-icon.png') }}">
  <link rel="icon" type="image/png" href="{{asset('admin//favicon.png') }}">
  <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css" rel="stylesheet">
  
  <title>
    Certificate Requests | LJKU
  </title>
  <!-- Bootstrap CSS -->
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet">
  <!-- Bootstrap Bundle JS -->
  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.bundle.min.js"></script>

  <!-- Fonts and icons -->
  <link href="https://fonts.googleapis.com/css?family=Open+Sans:300,400,600,700" rel="stylesheet" />
  <!-- Nucleo Icons -->
  <link href="https://demos.creative-tim.com/argon-dashboard-pro/assets/css/nucleo-icons.css" rel="stylesheet" />
  <link href="https://demos.creative-tim.com/argon-dashboard-pro/assets/css/nucleo-svg.css" rel="stylesheet" />
  <!-- Font Awesome Icons -->
  <script src="https://kit.fontawesome.com/42d5adcbca.js" crossorigin="anonymous"></script>
  
  <!-- CSS Files -->
  <link id="pagestyle" href="{{ asset('admin/css/argon-dashboard.css?v=2.1.0') }} " rel="stylesheet" />

  <style>
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
    
    .action-btn {
      padding: 0.25rem 0.5rem;
      border-radius: 4px;
      transition: all 0.2s ease;
    }
    
    .action-btn:hover {
      transform: translateY(-1px);
    }
    
    .btn-view {
      background-color: #e3f2fd;
      color: #0d47a1;
    }
    
    .btn-edit {
      background-color: #e8f5e9;
      color: #1b5e20;
    }
    
    .btn-delete {
      background-color: #ffebee;
      color: #b71c1c;
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
            <li class="breadcrumb-item text-sm text-white active" aria-current="page">Certificate Requests</li>
          </ol>
          <h6>Certificate Requests</h6>
        </nav>
      </div>
    </nav>

    <div class="container-fluid py-4">
      <div class="row">
        <div class="col-12">
          <div class="card mb-4">
            <div class="card-header pb-0 d-flex justify-content-between align-items-center">
              <h6>Certificate Requests</h6>
              <!-- Department Filter -->
              <form action="{{ route('admin.certificate-requests.index') }}" method="GET" class="d-flex gap-2">
                <select name="department_id" class="form-control form-control-sm">
                  <option value="">All Departments</option>
                  @foreach($departments as $department)
                    <option value="{{ $department->dept_id }}" {{ request()->department_id == $department->dept_id ? 'selected' : '' }}>
                      {{ $department->name }}
                    </option>
                  @endforeach
                </select>
                <button type="submit" class="btn btn-primary btn-sm">Filter</button>
              </form>
              <a href="{{ route('admin.certificate-requests.create') }}" class="btn btn-primary btn-sm">
                <i class="fas fa-plus-circle me-2"></i>Create Request
              </a>
            </div>
            <div class="card-body px-0 pt-0 pb-2">
              <div class="table-responsive p-0">
                <table class="table align-items-center mb-0">
                  <thead>
                    <tr>
                      <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">#</th>
                      <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">Course Name</th>
                      <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">Department</th>
                      <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">Batch</th>
                      <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">Status</th>
                      <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">Created At</th>
                      <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">Actions</th>
                    </tr>
                  </thead>
                  <tbody>
                    @foreach($requests as $request)
                    <tr>
                      <td class="ps-4">
                        <span class="text-secondary text-xs font-weight-bold">{{ $loop->iteration }}</span>
                      </td>
                      <td class="ps-4">
                        <span class="text-secondary text-xs font-weight-bold">{{ $request->course_name }}</span>
                      </td>
                      <td class="ps-4">
                        <span class="text-secondary text-xs font-weight-bold">
                          {{ $request->department_id? $request->department->name : 'All Departments' }}
                        </span>
                      </td>
                      <td class="ps-4">
                        <span class="text-secondary text-xs font-weight-bold">
                          @if($request->batch_id)
                            {{ $request->batch->start_year }} - {{ $request->batch->end_year }}
                          @else
                            All Batches
                          @endif
                        </span>
                      </td>
                      <td class="ps-4">
                        <span class="status-badge status-{{ strtolower($request->status) }}">
                          {{ strtoupper($request->status) }}
                        </span>
                      </td>
                      <td class="ps-4">
                        <span class="text-secondary text-xs font-weight-bold">
                          {{ $request->created_at->format('d M Y') }}
                        </span>
                      </td>
                      <td class="ps-4">
                        <div class="d-flex gap-2">
                          <a href="{{ route('admin.certificate-requests.show', $request->id) }}" 
                             class="action-btn btn-view" title="View">
                            <i class="fas fa-eye"></i>
                          </a>
                        
                          <a href="{{ route('admin.certificate-requests.edit', $request->id) }}" 
                             class="action-btn btn-edit" title="Edit">
                            <i class="fas fa-edit"></i>
                          </a>
                          <form action="{{ route('admin.certificate-requests.destroy', $request->id) }}" 
                                method="POST" style="display: inline;">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="action-btn btn-delete" title="Delete"
                                    onclick="return confirm('Are you sure you want to delete this request?')">
                              <i class="fas fa-trash"></i>
                            </button>
                          </form>
                          @if($request->status == 'close')
                          <form action="{{ route('admin.certificate-requests.open', $request->id) }}" method="POST">
                            @csrf
                            <button type="submit" class="btn btn-success btn-sm">Open</button>
                          </form>
                        @else
                          <form action="{{ route('admin.certificate-requests.close', $request->id) }}" method="POST">
                            @csrf
                            <button type="submit" class="btn btn-danger btn-sm">Close</button>
                          </form>
                        @endif

                        </div>
                      </td>
                    </tr>
                    @endforeach
                  </tbody>
                </table>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>
  </main>

  <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
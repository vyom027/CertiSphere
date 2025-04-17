<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="utf-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
 
  <title>
    View Certificate Request | LJKU
  </title>
  <!-- Bootstrap CSS -->
  @include('admin.components.links')
  <style>
    .card {
      background: white;
      border-radius: 15px;
      box-shadow: 0 0 2rem 0 rgba(136, 152, 170, .15);
    }

    .info-label {
      font-weight: 600;
      color: #344767;
    }

    .info-value {
      color: #67748e;
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

    .action-buttons .btn {
      padding: 0.5rem 1rem;
      font-weight: 600;
      border-radius: 8px;
    }

    .description-box {
      background-color: #f8f9fa;
      border-radius: 8px;
      padding: 1rem;
      margin-top: 1rem;
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
          <h6 class="font-weight-bolder text-white mb-0">View Certificate Request</h6>
        </nav>
      </div>
    </nav>

    <div class="container-fluid py-4">
      <div class="row">
        <div class="col-md-8 mx-auto">
          <div class="card">
            <div class="card-header d-flex justify-content-between align-items-center">
              <h5 class="mb-0">Certificate Request Details</h5>
              <div class="action-buttons">
                <a href="{{ route('admin.certificate-requests.edit', $request->id) }}" class="btn btn-primary me-2">
                  <i class="fas fa-edit me-2"></i>Edit
                </a>
                <a href="{{ route('admin.certificate-requests.index') }}" class="btn btn-secondary">
                  <i class="fas fa-arrow-left me-2"></i>Back
                </a>
              </div>
            </div>
            <div class="card-body">
              @if(session('success'))
                <div class="alert alert-success">
                  {{ session('success') }}
                </div>
              @endif

              <div class="row mb-4">
                <div class="col-md-6">
                  <p class="mb-2">
                    <span class="info-label">Course Name:</span>
                    <span class="info-value">{{ $request->course_name }}</span>
                  </p>
                  <p class="mb-2">
                    <span class="info-label">Department:</span>
                    <span class="info-value">{{ $request->department->name ?? 'N/A' }}</span>
                  </p>
                  <p class="mb-2">
                    <span class="info-label">Batch:</span>
                    <span class="info-value">
                      @if($request->batch)
                        {{ $request->batch->start_year }} - {{ $request->batch->end_year }}
                      @else
                        N/A
                      @endif
                    </span>
                  </p>
                </div>
                <div class="col-md-6">
                  <p class="mb-2">
                    <span class="info-label">Division:</span>
                    <span class="info-value">{{ $request->division ?? 'N/A' }}</span>
                  </p>
                  <p class="mb-2">
                    <span class="info-label">Status:</span>
                    <span class="status-badge status-{{ $request->status }}">
                      {{ ucfirst($request->status) }}
                    </span>
                  </p>
                  <p class="mb-2">
                    <span class="info-label">Created At:</span>
                    <span class="info-value">{{ $request->created_at->format('d M Y, h:i A') }}</span>
                  </p>
                </div>
              </div>

              @if($request->description)
                <div class="description-box">
                  <h6 class="info-label mb-3">Description</h6>
                  <p class="info-value">{{ $request->description }}</p>
                </div>
              @endif
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
<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="utf-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
  <link rel="apple-touch-icon" sizes="76x76" href="{{asset('admin//apple-icon.png') }}">
  <link rel="icon" type="image/png" href="{{asset('admin//favicon.png') }}">
  <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css" rel="stylesheet">
  
  <title>
    Create Certificate Request | LJKU
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
    .form-container {
      background: white;
      border-radius: 15px;
      box-shadow: 0 0 2rem 0 rgba(136, 152, 170, .15);
      padding: 2rem;
    }

    .form-label {
      font-weight: 600;
      color: #344767;
      margin-bottom: 0.5rem;
    }

    .form-control, .form-select {
      border-radius: 8px;
      padding: 0.75rem 1rem;
      border: 1px solid #d2d6da;
      transition: all 0.2s ease;
    }

    .form-control:focus, .form-select:focus {
      border-color: #5e72e4;
      box-shadow: 0 0 0 0.2rem rgba(94, 114, 228, 0.25);
    }

    .btn-submit {
      background: linear-gradient(310deg, #5e72e4 0%, #825ee4 100%);
      border: none;
      padding: 0.75rem 1.5rem;
      font-weight: 600;
      transition: all 0.2s ease;
    }

    .btn-submit:hover {
      transform: translateY(-2px);
      box-shadow: 0 7px 14px rgba(50, 50, 93, 0.1), 0 3px 6px rgba(0, 0, 0, 0.08);
    }

    .optional-badge {
      background: #f8f9fa;
      color: #6c757d;
      padding: 0.25rem 0.5rem;
      border-radius: 4px;
      font-size: 0.75rem;
      margin-left: 0.5rem;
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
          <h6 class="font-weight-bolder text-white mb-0">Create Certificate Request</h6>
        </nav>
      </div>
    </nav>

    <div class="container-fluid py-4">
      <div class="row">
        <div class="col-md-8 mx-auto">
          <div class="form-container">
            <div class="card-header pb-0">
              <h5 class="mb-0">Create New Certificate Request</h5>
            </div>
            <div class="card-body">
              <form method="POST" action="{{ route('admin.certificate-requests.store') }}" class="needs-validation" novalidate>
                @csrf
                
                <div class="mb-4">
                  <label for="course_name" class="form-label">Course Name <span class="text-danger">*</span></label>
                  <input type="text" class="form-control" id="course_name" name="course_name" required>
                  <div class="invalid-feedback">
                    Please provide a course name.
                  </div>
                </div>

                <div class="mb-4">
                  <label for="department_id" class="form-label">
                    Department
                  </label>
                  <select class="form-select" id="department_id" name="department_id">
                    <option value="">All Departments</option>
                    @foreach($departments as $dept)
                      <option value="{{ $dept->dept_id }}">{{ $dept->name }}</option>
                    @endforeach
                  </select>
                </div>

                <div class="mb-4">
                  <label for="batch_id" class="form-label">
                    Batch
                  </label>
                  <select class="form-select" id="batch_id" name="batch_id">
                    <option value="">All Batches</option>
                    @foreach($batches as $batch)
                      <option value="{{ $batch->batch_id }}">{{ $batch->start_year }} - {{ $batch->end_year }}</option>
                    @endforeach
                  </select>
                </div>

                <div class="mb-4">
                  <label for="description" class="form-label">
                    Description
                    <span class="optional-badge">Optional</span>
                  </label>
                  <textarea class="form-control" id="description" name="description" rows="4"></textarea>
                </div>

                <div class="d-flex justify-content-end">
                  <button type="submit" class="btn btn-submit text-white">
                    <i class="fas fa-plus-circle me-2"></i>Create Certificate Request
                  </button>
                </div>
              </form>
            </div>
          </div>
        </div>
      </div>
    </div>
  </main>

  <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
  <script>
    // Form validation
    (function () {
      'use strict'
      var forms = document.querySelectorAll('.needs-validation')
      Array.prototype.slice.call(forms).forEach(function (form) {
        form.addEventListener('submit', function (event) {
          if (!form.checkValidity()) {
            event.preventDefault()
            event.stopPropagation()
          }
          form.classList.add('was-validated')
        }, false)
      })
    })()
  </script>
</body>
</html>
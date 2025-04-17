<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="utf-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
 
  <title>
    Edit Certificate Request | LJKU
  </title>
  <!-- Bootstrap CSS -->
  @include('admin.components.links')
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

    .alert {
      border-radius: 8px;
      margin-bottom: 1.5rem;
    }

    .invalid-feedback {
      font-size: 0.875rem;
      color: #dc3545;
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
          <h6 class="font-weight-bolder text-white mb-0">Edit Certificate Request</h6>
        </nav>
      </div>
    </nav>

    <div class="container-fluid py-4">
      <div class="row">
        <div class="col-md-8 mx-auto">
          <div class="form-container">
            <div class="card-header pb-0">
              <h5 class="mb-0">Edit Certificate Request</h5>
            </div>
            <div class="card-body">
              @if(session('success'))
                <div class="alert alert-success">
                  {{ session('success') }}
                </div>
              @endif

              @if($errors->any())
                <div class="alert alert-danger">
                  <ul class="mb-0">
                    @foreach($errors->all() as $error)
                      <li>{{ $error }}</li>
                    @endforeach
                  </ul>
                </div>
              @endif

              <form method="POST" action="{{ route('admin.certificate-requests.update', $request->id) }}" class="needs-validation" novalidate>
                @csrf
                @method('PUT')
                
                <div class="mb-4">
                  <label for="course_name" class="form-label">Course Name <span class="text-danger">*</span></label>
                  <input type="text" class="form-control @error('course_name') is-invalid @enderror" 
                         id="course_name" name="course_name" value="{{ old('course_name', $request->course_name) }}" required>
                  @error('course_name')
                    <div class="invalid-feedback">
                      {{ $message }}
                    </div>
                  @enderror
                </div>

                <div class="mb-4">
                  <label for="department_id" class="form-label">Department</label>
                  <select class="form-select @error('department_id') is-invalid @enderror" id="department_id" name="department_id">
                    <option value="">Select Department</option>
                    @foreach($departments as $dept)
                      <option value="{{ $dept->dept_id }}" {{ old('department_id', $request->department_id) == $dept->dept_id ? 'selected' : '' }}>
                        {{ $dept->dept_id }}
                      </option>
                    @endforeach
                  </select>
                  @error('department_id')
                    <div class="invalid-feedback">
                      {{ $message }}
                    </div>
                  @enderror
                </div>

                <div class="mb-4">
                  <label for="batch_id" class="form-label">Batch</label>
                  <select class="form-select @error('batch_id') is-invalid @enderror" id="batch_id" name="batch_id">
                    <option value="">Select Batch</option>
                    @foreach($batches as $batch)
                      <option value="{{ $batch->batch_id }}" {{ old('batch_id', $request->batch_id) == $batch->batch_id ? 'selected' : '' }}>
                        {{ $batch->start_year }} - {{ $batch->end_year }}
                      </option>
                    @endforeach
                  </select>
                  @error('batch_id')
                    <div class="invalid-feedback">
                      {{ $message }}
                    </div>
                  @enderror
                </div>


                <div class="mb-4">
                  <label for="status" class="form-label">Status <span class="text-danger">*</span></label>
                  <select class="form-select" id="status" name="status" required>
                    <option value="open" {{ $request->status == 'open' ? 'selected' : '' }}>Open</option>
                    <option value="close" {{ $request->status == 'close' ? 'selected' : '' }}>Close</option>
                  </select>
                  @error('status')
                    <div class="invalid-feedback">
                      {{ $message }}
                    </div>
                  @enderror
                </div>

                <div class="mb-4">
                  <label for="description" class="form-label">Description</label>
                  <textarea class="form-control @error('description') is-invalid @enderror" 
                            id="description" name="description" rows="4">{{ old('description', $request->description) }}</textarea>
                  @error('description')
                    <div class="invalid-feedback">
                      {{ $message }}
                    </div>
                  @enderror
                </div>

                <div class="d-flex justify-content-between">
                  <a href="{{ route('admin.certificate-requests.index') }}" class="btn btn-secondary">
                    <i class="fas fa-arrow-left me-2"></i>Back
                  </a>
                  <button type="submit" class="btn btn-submit text-white">
                    <i class="fas fa-save me-2"></i>Update Request
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
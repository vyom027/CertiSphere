<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="utf-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
  <link rel="apple-touch-icon" sizes="76x76" href="{{ asset('admin/apple-icon.png') }}">
  <link rel="icon" type="image/png" href="{{ asset('admin/favicon.png') }}">
  <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css" rel="stylesheet">

  <title>Edit Course | LJKU</title>

  <!-- Bootstrap CSS & JS -->
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet">
  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.bundle.min.js"></script>

  <!-- Fonts and icons -->
  <link href="https://fonts.googleapis.com/css?family=Open+Sans:300,400,600,700" rel="stylesheet" />
  <link href="https://demos.creative-tim.com/argon-dashboard-pro/assets/css/nucleo-icons.css" rel="stylesheet" />
  <link href="https://demos.creative-tim.com/argon-dashboard-pro/assets/css/nucleo-svg.css" rel="stylesheet" />
  <script src="https://kit.fontawesome.com/42d5adcbca.js" crossorigin="anonymous"></script>

  <!-- Argon CSS -->
  <link id="pagestyle" href="{{ asset('admin/css/argon-dashboard.css?v=2.1.0') }}" rel="stylesheet" />
</head>

<body class="g-sidenav-show bg-gray-100">
  <div class="min-height-300 bg-dark position-absolute w-100"></div>

  <aside class="sidenav bg-white navbar navbar-vertical navbar-expand-xs border-0 border-radius-xl my-3 fixed-start ms-4" id="sidenav-main">
    @include('admin.components.sidebar')
  </aside>

  <main class="main-content position-relative border-radius-lg">
    <nav class="navbar navbar-main navbar-expand-lg px-0 mx-4 shadow-none border-radius-xl" id="navbarBlur">
      <div class="container-fluid py-1 px-3">
        <nav aria-label="breadcrumb">
          <ol class="breadcrumb bg-transparent mb-0 pb-0 pt-1 px-0 me-sm-6 me-5">
            <li class="breadcrumb-item text-sm"><a class="opacity-5 text-white" href="#">Pages</a></li>
            <li class="breadcrumb-item text-sm text-white active" aria-current="page">College Courses</li>
          </ol>
          <h6 class="font-weight-bolder text-white mb-0">Edit College Course</h6>
        </nav>
      </div>
    </nav>

    @if ($errors->has('duplicate'))
      <div class="alert alert-danger">
        {{ $errors->first('duplicate') }}
      </div>
    @endif

    <div class="container-fluid py-5">
      <div class="row justify-content-center">
        <div class="col-md-8">
          <div class="card shadow">
            <div class="card-header d-flex justify-content-between align-items-center">
              <h5>Edit Course</h5>
              <a href="{{ route('admin.college-courses.index') }}" class="btn btn-secondary btn-sm">Back</a>
            </div>
            <div class="card-body">
              <form action="{{ route('admin.college-courses.update', $course->id) }}" method="POST">
                @csrf
                @method('PUT')

                <div class="mb-3">
                  <label for="semester" class="form-label">Semester</label>
                  <select name="semester" id="semester" class="form-control" required>
                    <option value="" disabled>Select Semester</option>
                    @for ($i = 1; $i <= 10; $i++)
                      <option value="{{ $i }}" {{ $course->semester == $i ? 'selected' : '' }}>{{ $i }}</option>
                    @endfor
                  </select>
                </div>

                <div class="mb-3">
                  <label for="department" class="form-label">Department</label>
                  <select name="department" id="department" class="form-control" required>
                    <option value="" disabled>Select Department</option>
                    @foreach($dept as $d)
                      <option value="{{ $d->name }}" {{ $course->department == $d->name ? 'selected' : '' }}>{{ $d->name }}</option>
                    @endforeach
                  </select>
                </div>

                <div class="mb-3">
                  <label for="name" class="form-label">Course Name</label>
                  <input type="text" name="name" id="name" class="form-control" value="{{ old('name', $course->name) }}" required>
                </div>

                <div class="mb-3">
                  <label for="link" class="form-label">Course Link</label>
                  <input type="url" name="link" id="link" class="form-control" value="{{ old('link', $course->link) }}" required>
                </div>

                <button type="submit" class="btn btn-primary">Update Course</button>
              </form>
            </div>
          </div>
        </div>
      </div>
    </div>
  </main>

  <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
</body>
</html>

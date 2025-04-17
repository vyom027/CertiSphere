<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="utf-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
  
  <title>
    Student List | LJKU
  </title>
  @include('admin.components.links')
  <style>
    .dropdown-menu {
  top: 100% !important;
  left: 0 !important;
  transform: translateY(-125px) !important;
}

  </style>
  <!-- CSS Files -->
  <link id="pagestyle" href="{{ asset('admin/css/argon-dashboard.css?v=2.1.0') }} " rel="stylesheet" />
</head>

<body class="g-sidenav-show   bg-gray-100">
  <div class="min-height-300 bg-dark position-absolute w-100"></div>
  {{--  --}}
  <aside class="sidenav bg-white navbar navbar-vertical navbar-expand-xs border-0 border-radius-xl my-3 fixed-start ms-4" id="sidenav-main">
  @include('admin.components.sidebar')
    </aside>
    <main class="main-content position-relative border-radius-lg ">

    <nav class="navbar navbar-main navbar-expand-lg px-0 mx-4 shadow-none border-radius-xl " id="navbarBlur" data-scroll="false">
        <div class="container-fluid py-1 px-3">
          <nav aria-label="breadcrumb">
            <ol class="breadcrumb bg-transparent mb-0 pb-0 pt-1 px-0 me-sm-6 me-5">
              <li class="breadcrumb-item text-sm"><a class="opacity-5 text-white" href="javascript:;">Pages</a></li>
              <li class="breadcrumb-item text-sm text-white active" aria-current="page">College Courses</li>
            </ol>
            <h6 class="font-weight-bolder text-white mb-0">Add College Course</h6>
          </nav>
          <div class="collapse navbar-collapse mt-sm-0 mt-2 me-md-0 me-sm-4" id="navbar">
            <div class="ms-md-auto pe-md-3 d-flex align-items-center">
              <div class="input-group">
                <span class="input-group-text text-body"><i class="fas fa-search" aria-hidden="true"></i></span>
                <input type="text" class="form-control" placeholder="Type here...">
              </div>
            </div>
            <ul class="navbar-nav  justify-content-end">
              <li class="nav-item d-xl-none ps-3 d-flex align-items-center">
                <a href="javascript:;" class="nav-link text-white p-0" id="iconNavbarSidenav">
                  <div class="sidenav-toggler-inner">
                    <i class="sidenav-toggler-line bg-white"></i>
                    <i class="sidenav-toggler-line bg-white"></i>
                    <i class="sidenav-toggler-line bg-white"></i>
                  </div>
                </a>
              </li>
              <li class="nav-item px-3 d-flex align-items-center">
                <a href="javascript:;" class="nav-link text-white p-0">
                  <i class="fa fa-cog fixed-plugin-button-nav cursor-pointer"></i>
                </a>
              </li>
                </ul>
          </div>
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
                <h5>Step 2: Add Course Details</h5>
                <a href="{{ route('admin.college-courses.index') }}" class="btn btn-secondary btn-sm">Back</a>
              </div>
              <div class="card-body">
                <form action="{{ route('admin.college-courses.store') }}" method="POST">
                  @csrf
                
                  <div class="mb-3">
                    <label for="semester" class="form-label">Semester</label>
                    <select name="semester" id="semester" class="form-control" required>
                      <option value="" disabled selected>Select Semester</option>
                      @for ($i = 1; $i <= 10; $i++)
                        <option value="{{ $i }}">{{ $i }}</option>
                      @endfor
                    </select>
                  </div>
                
                  <div class="mb-3">
                    <label for="department" class="form-label">Department</label>
                    <select name="department" id="department" class="form-control" required>
                      <option value="" disabled selected>Select Department</option>
                      @foreach($dept as $d)
                        <option value="{{ $d->name }}">{{ $d->name }}</option>
                      @endforeach
                    </select>
                  </div>
                  
                
                  <div class="mb-3">
                    <label for="name" class="form-label">Course Name</label>
                    <input type="text" name="name" id="name" value="{{ request('name') }}" class="form-control" required>
                  </div>
                
                  <div class="mb-3">
                    <label for="link" class="form-label">Course Link</label>
                    <input type="url" name="link" id="link" value="{{ request('link') }}" class="form-control" required>
                  </div>
                
                  <button type="submit" class="btn btn-primary">Add Course</button>
                </form>
                
              </div>
            </div>
          </div>
        </div>
      </div>
    


    </main>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>

</body>
</html>
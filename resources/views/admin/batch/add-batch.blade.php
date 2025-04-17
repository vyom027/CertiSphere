<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="utf-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
   <title>
    Add Batch | LJKU
  </title>
  <!-- Bootstrap CSS -->
  @include('admin.components.links')
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
              <li class="breadcrumb-item text-sm text-white active" aria-current="page">Batch</li>
            </ol>
            <h6 class="font-weight-bolder text-white mb-0">Batch List</h6>
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
      </nav><div class="container mt-5">
        <div class="row justify-content-center">
            <div class="col-md-9"> <!-- Adjust column width here -->
                <div class="card shadow">
                    <div class="card-header d-flex justify-content-between align-items-center">
                        <h6 class="mb-0">Add Batch</h6>
                        <a href="{{ route('batch.index') }}" class="btn btn-light btn-sm">Back to List</a>
                    </div>
                    <div class="card-body">
                        <form action="{{ route('batch.store') }}" method="POST">
                            @csrf
                            <!-- Department Name -->
                            <div class="mb-4">
                                <label for="department_id" class="form-label">Department Name</label>
                                <select name="dept_id" id="department_id" class="form-select" required>
                                    <option value="" selected disabled>-- Select Department --</option>
                                    @foreach($departments as $department)
                                    <option value="{{ $department->dept_id }}">{{ $department->name }}</option>
                                    @endforeach
                                </select>
                            </div>
    
                            <!-- Start Year -->
                            <div class="mb-4">
                                <label for="start_year" class="form-label">Start Year</label>
                                <input type="number" name="start_year" id="start_year" class="form-control" placeholder="Enter start year" required>
                            </div>
    
                            <!-- End Year -->
                            <div class="mb-4">
                                <label for="end_year" class="form-label">End Year</label>
                                <input type="number" name="end_year" id="end_year" class="form-control" placeholder="Enter end year" required>
                            </div>
    
                            <!-- Submit Button -->
                            <div class="d-flex justify-content-end">
                                <button type="submit" class="btn btn-primary px-4">Add Batch</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
    
    
    
    </main>
</body>
</html>
<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="utf-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
  @include('admin.components.links')
  <title>
    Student List | LJKU
  </title>
  
  <style>
    .dropdown-menu {
      top: 100% !important;
      left: 0 !important;
      transform: translateY(-125px) !important;
    }
  
    .pagination-wrapper nav {
  display: flex;
  justify-content: center;
  align-items: center;
  width: 100%;
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
              <li class="breadcrumb-item text-sm text-white active" aria-current="page">Student</li>
            </ol>
            <h6 class="font-weight-bolder text-white mb-0">Student List</h6>
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
      <div class="container-fluid py-4">
        <div class="row">
          <div class="col-12">
            <div class="card py-5 pb-0" >
              <div class="card-header pb-3">
                <div class="d-flex justify-content-between align-items-center">
                    <h6>Student List</h6>
                    <div class="d-flex gap-2">
                        <!-- Download CSV Button -->
                        
                        <!-- Upload CSV Form -->
                        <form action="{{ route('students.upload') }}" method="POST" enctype="multipart/form-data" class="d-flex align-items-center">
                            @csrf
                            <div class="input-group">
                              <input type="file" style="width: 200px; border: none; " name="csv_file" class="form-control" id="csv_file" accept=".csv" required>
                              <button type="submit" class="btn btn-success btn-sm">Upload</button>
                            </div>
                          </form>
                          
                          <a href="{{ route('students.export') }}" class="btn btn-secondary btn-sm">Download CSV</a>
                        <!-- Add Student Button -->
                        <a href="{{ route('students.create') }}" class="btn btn-primary btn-sm">Add Student</a>
                    </div>
                  
               </div>
            </div>
            
            <div class="card-body pb-3">
              <div class="row">
                <form method="GET" action="{{ route('students.index') }}">
                  <div class="row mb-3">
                    <div class="col-md-3">
                      <label for="department_filter">Department</label>
                      <select id="department_filter" name="dept_id" class="form-control" onchange="this.form.submit()">
                        <option value="">All</option>
                        @foreach($departments as $department)
                          <option value="{{ $department->dept_id }}" {{ request('dept_id') == $department->dept_id ? 'selected' : '' }}>
                            {{ $department->name }}
                          </option>
                        @endforeach
                      </select>
                    </div>
                    <div class="col-md-2">
                      <label for="semester_filter">Semester</label>
                      <select name="semester" class="form-control" onchange="this.form.submit()">
                          <option value="">All</option>
                          @foreach($uniqueSemesters as $semester)
                              <option value="{{ $semester }}"
                                  {{ request('semester') == $semester ? 'selected' : '' }}>
                                  Semester {{ $semester }}
                              </option>
                          @endforeach
                      </select>
                  </div>
                  
                    <div class="col-md-3">
                      <label for="division_filter">Division</label>
                      <select id="division_filter" name="division" class="form-control" onchange="this.form.submit()">
                        <option value="">All</option>
                        @foreach($divisions as $division)
                          <option value="{{ $division }}" {{ request('division') == $division ? 'selected' : '' }}>
                            {{ $division }}
                          </option>
                        @endforeach
                      </select>
                    </div>
                  </div>
                </form>
                
              </div>
            </div>

            <div class="card-body px-0 pt-0 pb-0">
              <div class="table-responsive p-0">
                <table class="table align-items-center">
                  <thead>
                    <tr>
                      <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7 ps-3">Index</th>
                      <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7 ps-1">Name</th>
                      <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7 ps-2">Enrollment No.</th>
                      <th class="text-center text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">Department</th>
                      <th class="text-center text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">Mobile No.</th>
                      <th class="text-secondary opacity-7"></th>
                    </tr>
                  </thead>
                  <tbody>
                    @foreach($students as $student)
                    <tr>
                      <td class="align-middle ps-2">
                        <span class="text-secondary text-xs font-weight-bold ps-3">{{$loop->iteration}}</span>
                      </td>
                      <td>
                        <div class="d-flex px-0 py-1">
                          <div class="d-flex flex-column justify-content-center">
                            <h6 class="mb-0 text-sm">{{ $student->first_name }} {{ $student->last_name }}</h6>
                            <p class="text-xs text-secondary mb-0">{{ $student->email }}</p>
                          </div>
                        </div>
                      </td>
                      <td>
                        <p class="text-xs font-weight-bold mb-0">{{ $student->enrollment_no }}</p>
                      </td>
                      <td class="align-middle text-center text-sm">
                        <p class="text-xs font-weight-bold mb-0">{{ $student->department->name }}</p>
                        <p class="text-xs text-secondary mb-0">{{ $student->batch->start_year }} - {{ $student->batch->end_year }}</p>
                      </td>
                      <td class="align-middle text-center">
                        <p class="text-xs font-weight-bold mb-0">+91 {{ $student->phone_number }}</p>
                      </td>
                      <td class="align-middle text-center">
                        <a href="" class="text-info mx-2" title="Show">
                          <i class="fas fa-eye"></i>
                        </a>
                        <a href="{{ route('students.edit', ['id' => $student->enrollment_no]) }}" class="text-success mx-2" title="Edit">
                          <i class="fas fa-edit"></i>
                        </a>
                        <form action="{{ route('students.destroy', ['id' => $student->enrollment_no]) }}" method="POST" style="display:inline;">
                          @csrf
                          @method('DELETE')
                          <button style="border: none;background:none;" class="text-danger mx-2" title="Delete">
                            <i class="fas fa-trash"></i>
                          </button>
                        </form>
                      </td>
                    </tr>
                    @endforeach
                  </tbody>
                </table>
            
                <!-- ✅ Properly Centered Pagination -->
                <div class="container-fluid">
                  <div class="row">
                      <div class="col-12 text-center">
                          <nav aria-label="Page navigation">
                              {{ $students->appends(request()->except('page'))->links() }}
                          </nav>
                      </div>
                  </div>
              </div>
              
                
              </div> <!-- .table-responsive -->
            </div> <!-- .card-body -->
          </div>
        </div>
      </div>
    </div>
  </main>
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
   
</body>
</html>
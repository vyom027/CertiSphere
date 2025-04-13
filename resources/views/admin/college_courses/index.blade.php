<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="utf-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
  <link rel="apple-touch-icon" sizes="76x76" href="{{ asset('admin//apple-icon.png') }}">
  <link rel="icon" type="image/png" href="{{ asset('admin//favicon.png') }}">
  <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css" rel="stylesheet">

  <title>Student List | LJKU</title>

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

  <!-- Custom Styling to Fix Table Overflow -->
  <style>
    .dropdown-menu {
      top: 100% !important;
      left: 0 !important;
      transform: translateY(-125px) !important;
    }

    .table-responsive {
      overflow-x: auto;
      width: 100%;
    }

    .table {
      table-layout: auto;
      white-space: nowrap;
    }

    td a {
      word-break: break-word;
      white-space: normal;
    }

    @media screen and (max-width: 768px) {
      .table th,
      .table td {
        font-size: 12px;
        padding-left: 6px !important;
        padding-right: 6px !important;
      }
    }
  </style>

  <!-- Main CSS -->
  <link id="pagestyle" href="{{ asset('admin/css/argon-dashboard.css?v=2.1.0') }}" rel="stylesheet" />
</head>

<body class="g-sidenav-show bg-gray-100">
  <div class="min-height-300 bg-dark position-absolute w-100"></div>

  <aside class="sidenav bg-white navbar navbar-vertical navbar-expand-xs border-0 border-radius-xl my-3 fixed-start ms-4"
    id="sidenav-main">
    @include('admin.components.sidebar')
  </aside>

  <main class="main-content position-relative border-radius-lg">
    <nav class="navbar navbar-main navbar-expand-lg px-0 mx-4 shadow-none border-radius-xl" id="navbarBlur"
      data-scroll="false">
      <div class="container-fluid py-1 px-3">
        <nav aria-label="breadcrumb">
          <ol class="breadcrumb bg-transparent mb-0 pb-0 pt-1 px-0 me-sm-6 me-5">
            <li class="breadcrumb-item text-sm"><a class="opacity-5 text-white" href="javascript:;">Pages</a></li>
            <li class="breadcrumb-item text-sm text-white active" aria-current="page">College Courses</li>
          </ol>
          <h6 class="font-weight-bolder text-white mb-0">College Courses List</h6>
        </nav>
        <div class="collapse navbar-collapse mt-sm-0 mt-2 me-md-0 me-sm-4" id="navbar">
          <div class="ms-md-auto pe-md-3 d-flex align-items-center">
            <div class="input-group">
              <span class="input-group-text text-body"><i class="fas fa-search" aria-hidden="true"></i></span>
              <input type="text" class="form-control" placeholder="Type here...">
            </div>
          </div>
          <ul class="navbar-nav justify-content-end">
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
          <div class="card py-5 pb-0">
            <div class="card-header pb-0">
              <div class="row align-items-center justify-content-between g-3">
                <div class="col-lg-4 col-md-6">
                  <h6 class="mb-0">College Selected Courses</h6>
                </div>

                <div class="col-lg-8 col-md-6">
                  <form method="GET" action="{{ route('admin.college-courses.index') }}" class="d-flex justify-content-end align-items-center gap-3 flex-wrap">
                    <div class="form-floating" style="min-width: 150px;">
                      <select name="semester" id="semesterSelect" class="form-select form-select-sm" onchange="this.form.submit()">
                        <option value="">All</option>
                        @foreach(range(1, 10) as $sem)
                          <option value="{{ $sem }}" {{ request('semester') == $sem ? 'selected' : '' }}>{{ $sem }}</option>
                        @endforeach
                      </select>
                      <label for="semesterSelect">Semester</label>
                    </div>

                    <a href="{{ route('admin.search-course-form') }}" class="btn btn-sm btn-primary d-flex align-items-center">
                      <i class="fas fa-plus me-1"></i> Add Course
                    </a>
                  </form>
                </div>
              </div>
            </div>

            
            <div class="card-body px-3 pt-0 pb-0">
              <div class="table-responsive" style="overflow-x: auto;">
                <table class="table align-items-center mb-0">
                  <thead>
                    <tr>
                      <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7 ps-3">#</th>
                      <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7 ps-3">Course Name</th>
                      <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7 ps-3">Link</th>
                      <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7 ps-3">Semester</th>
                      <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7 ps-3">Department</th>
                      <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7 ps-3">Actions</th>
                    </tr>
                  </thead>
                  <tbody>
                    @foreach($courses as $course)
                    <tr>
                      <td class="align-middle ps-3">{{ $loop->iteration }}</td>
                      <td class="align-middle ps-3">
                        <span class="text-secondary text-xs font-weight-bold">{{ $course->name }}</span>
                      </td>
                      <td class="align-middle ps-3 text-truncate" style="max-width: 150px;">
                        <a href="{{ $course->link }}" target="_blank"
                          class="text-xs text-info d-inline-block text-truncate" style="max-width: 150px;">{{ $course->link }}</a>
                      </td>
                      <td class="align-middle ps-3">
                        <span class="text-secondary text-xs">{{ $course->semester }}</span>
                      </td>
                      <td class="align-middle ps-3">
                        <span class="text-secondary text-xs">{{ $course->department }}</span>
                      </td>
                      <td class="align-middle">
                        <a href="{{ route('admin.college-courses.edit', $course->id) }}" class="text-success mx-2"
                          title="Edit">
                          <i class="fas fa-edit"></i>
                        </a>
                        <form action="{{ route('admin.college-courses.destroy', $course->id) }}" method="POST"
                          style="display:inline;">
                          @csrf
                          @method('DELETE')
                          <button type="submit" style="border: none; background: none;" class="text-danger mx-2"
                            title="Delete">
                            <i class="fas fa-trash"></i>
                          </button>
                        </form>
                      </td>
                    </tr>
                    @endforeach
                    @if($courses->isEmpty())
                    <tr>
                      <td colspan="7" class="text-center text-muted py-4">No courses found.</td>
                    </tr>
                    @endif
                  </tbody>
                </table>
              </div> <!-- table-responsive -->
            </div> <!-- card-body -->
          </div> <!-- card -->
        </div> <!-- col -->
      </div> <!-- row -->
    </div> <!-- container -->

  </main>

  <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>

</html>

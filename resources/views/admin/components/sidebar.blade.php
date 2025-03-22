<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="utf-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
  <link rel="apple-touch-icon" sizes="76x76" href="{{asset('admin//apple-icon.png') }}">
  <link rel="icon" type="image/png" href="{{asset('admin//favicon.png') }}">
  <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css" rel="stylesheet">

  <!-- Bootstrap CSS -->
<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet">
<!-- Bootstrap Bundle JS -->
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.bundle.min.js"></script>

  <!--     Fonts and icons     -->
  <link href="https://fonts.googleapis.com/css?family=Open+Sans:300,400,600,700" rel="stylesheet" />
  <!-- Nucleo Icons -->
  <link href="https://demos.creative-tim.com/argon-dashboard-pro/assets/css/nucleo-icons.css" rel="stylesheet" />
  <link href="https://demos.creative-tim.com/argon-dashboard-pro/assets/css/nucleo-svg.css" rel="stylesheet" />
  <!-- Font Awesome Icons -->
  <script src="https://kit.fontawesome.com/42d5adcbca.js" crossorigin="anonymous"></script>
  <!-- CSS Files -->
  <link id="pagestyle" href="{{ asset('admin/css/argon-dashboard.css?v=2.1.0') }} " rel="stylesheet" />
</head>

<body class="g-sidenav-show   bg-gray-100">
  <aside class="sidenav bg-white navbar navbar-vertical navbar-expand-xs border-0 border-radius-xl my-3 fixed-start ms-4" id="sidenav-main">
    <div class="sidenav-header">
      <i class="fas fa-times p-3 cursor-pointer text-secondary opacity-5 position-absolute end-0 top-0 d-none d-xl-none" aria-hidden="true" id="iconSidenav"></i>
      <a class="navbar-brand m-0" href="https://demos.creative-tim.com/argon-dashboard/pages/dashboard.html" target="_blank">
        <img src="{{ asset('admin/img/ljwide.png') }} " height="60px" width="150px" class="navbar-brand-img h-100" alt="main_logo">
        {{-- <span class="ms-1 font-weight-bold"> LJKU </span> --}}
      </a>
    </div>
    <hr class="horizontal dark mt-0">
    <div class="collapse navbar-collapse w-auto" id="sidenav-collapse-main">
      <ul class="navbar-nav">
        <li class="nav-item">
          <a class="nav-link active" href="../pages/dashboard.html">
            <div class="icon icon-shape icon-sm border-radius-md text-center me-2 d-flex align-items-center justify-content-center">
              <i class="ni ni-tv-2 text-dark text-sm opacity-10"></i>
            </div>
            <span class="nav-link-text ms-1">Dashboard</span>
          </a>
        </li>
        
        <!-- Batch & Department Section -->
        <li class="nav-item position-relative">
          <a class="nav-link toggle-dropdown" href="javascript:void(0);">
            <div class="icon icon-shape icon-sm border-radius-md text-center me-2 d-flex align-items-center justify-content-center">
              <i class="ni ni-single-02 text-dark text-sm opacity-10"></i>
            </div>
            <span class="nav-link-text ms-1">Student</span>
          </a>
          <!-- Sub-options -->
          <ul class="sub-options d-none ms-4">
            <li><a href="{{ route('students.create')}}" class="nav-link"><i class="fas fa-user-plus"></i>Add Student</a></li>
            <li><a href="{{ route('students.index')}}" class="nav-link"><i class="fas fa-list"></i>Student List</a></li>
            <li><a href="#" class="nav-link"><i class="fas fa-file-alt"></i>Student List for Selected Course Enrollment</a></li>
          </ul>
        </li>
      
        <!-- Batch -->
        <li class="nav-item position-relative">
          <a class="nav-link toggle-dropdown" href="javascript:void(0);">
            <div class="icon icon-shape icon-sm border-radius-md text-center me-2 d-flex align-items-center justify-content-center">
              <i class="ni ni-books text-dark text-sm opacity-10"></i>
            </div>
            <span class="nav-link-text ms-1">Batch</span>
          </a>
          <!-- Sub-options -->
          <ul class="sub-options d-none ms-4">
            <li><a href="{{ route('batch.create')}}" class="nav-link"><i class="fas fa-plus"></i>Add Batch</a></li>
            <li><a href="{{ route('batch.index')}}" class="nav-link"><i class="fas fa-list"></i>Batch List</a></li>
          </ul>
        </li>
      
        <!-- Department -->
        <li class="nav-item position-relative">
          <a class="nav-link toggle-dropdown" href="javascript:void(0);">
            <div class="icon icon-shape icon-sm border-radius-md text-center me-2 d-flex align-items-center justify-content-center">
              <i class="ni ni-building text-dark text-sm opacity-10"></i>
            </div>
            <span class="nav-link-text ms-1">Department</span>
          </a>
          <!-- Sub-options -->
          <ul class="sub-options d-none ms-4">
            <li><a href="{{ route('department.create')}}" class="nav-link"><i class="fas fa-plus"></i>Add Department</a></li>
            <li><a href="{{ route('department.index')}}" class="nav-link"><i class="fas fa-list"></i>Department List</a></li>
          </ul>
        </li>
      
        <!-- Course -->
        <li class="nav-item position-relative">
          <a class="nav-link toggle-dropdown" href="javascript:void(0);">
            <div class="icon icon-shape icon-sm border-radius-md text-center me-2 d-flex align-items-center justify-content-center">
              <i class="ni ni-folder-17 text-dark text-sm opacity-10"></i>
            </div>
            <span class="nav-link-text ms-1">Course</span>
          </a>
          <!-- Sub-options -->
          <ul class="sub-options d-none ms-4">
            <li><a href="#" class="nav-link"><i class="fas fa-plus"></i>Add Course</a></li>
            <li><a href="#" class="nav-link"><i class="fas fa-list"></i>Selected Course List</a></li>
          </ul>
        </li>
      
        <!-- Reports & Analytics -->
        <li class="nav-item position-relative">
          <a class="nav-link toggle-dropdown" href="javascript:void(0);">
            <div class="icon icon-shape icon-sm border-radius-md text-center me-2 d-flex align-items-center justify-content-center">
              <i class="ni ni-chart-bar-32 text-dark text-sm opacity-10"></i>
            </div>
            <span class="nav-link-text ms-1">Reports & Analytics</span>
          </a>
          <!-- Sub-options -->
          <ul class="sub-options d-none ms-4">
            <li><a href="#" class="nav-link"><i class="fas fa-file-export"></i>Generate Report</a></li>
            <li><a href="#" class="nav-link"><i class="fas fa-download"></i>Export Report</a></li>
          </ul>
        </li>
      
        <!-- Request & Notification -->
        <li class="nav-item position-relative">
          <a class="nav-link toggle-dropdown" href="javascript:void(0);">
            <div class="icon icon-shape icon-sm border-radius-md text-center me-2 d-flex align-items-center justify-content-center">
              <i class="ni ni-bell-55 text-dark text-sm opacity-10"></i>
            </div>
            <span class="nav-link-text ms-1">Request & Notification</span>
          </a>
          <!-- Sub-options -->
          <ul class="sub-options d-none ms-4">
            <li><a href="#" class="nav-link"><i class="fas fa-paper-plane"></i>Send Notification</a></li>
            <li><a href="#" class="nav-link"><i class="fas fa-list"></i>List Notification</a></li>
            <li><a href="#" class="nav-link"><i class="fas fa-envelope"></i>Request List</a></li>
          </ul>
        </li>
      
        <!-- Profile -->
        <li class="nav-item">
          <a class="nav-link" href="#">
            <div class="icon icon-shape icon-sm border-radius-md text-center me-2 d-flex align-items-center justify-content-center">
              <i class="ni ni-circle-08 text-dark text-sm opacity-10"></i>
            </div>
            <span class="nav-link-text ms-1">{{ session('admin_name') }}</span>
          </a>
        </li>
      </ul>
    </div>
  </aside>

  <script src="{{asset('admin/js/core/popper.min.js') }}"></script>
  <script src="{{asset('admin/js/core/bootstrap.min.js') }}"></script>
  <script src="{{asset('admin/js/plugins/perfect-scrollbar.min.js') }}"></script>
  <script src="{{asset('admin/js/plugins/smooth-scrollbar.min.js') }}"></script>
  <script src="{{asset('admin/js/plugins/chartjs.min.js') }}"></script>
  
  <script>
    var win = navigator.platform.indexOf('Win') > -1;
    if (win && document.querySelector('#sidenav-scrollbar')) {
      var options = {
        damping: '0.5'
      }
      Scrollbar.init(document.querySelector('#sidenav-scrollbar'), options);
    }
  </script>
  <!-- Github buttons -->
  <script async defer src="https://buttons.github.io/buttons.js"></script>
  <!-- Control Center for Soft Dashboard: parallax effects, scripts for the example pages etc -->
  <script src="{{ asset('admin/js/argon-dashboard.min.js?v=2.1.0') }}"></script>
  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.bundle.min.js"></script>
  
  <script>
    document.addEventListener("DOMContentLoaded", function () {
      const dropdownToggles = document.querySelectorAll(".toggle-dropdown");
  
      dropdownToggles.forEach(toggle => {
        toggle.addEventListener("click", function () {
          const subOptions = this.nextElementSibling;
          const isVisible = subOptions.classList.contains("d-block");
  
          // Close all other dropdowns
          document.querySelectorAll(".sub-options").forEach(item => {
            item.classList.remove("d-block");
            item.classList.add("d-none");
          });
  
          // Toggle the clicked dropdown
          if (isVisible) {
            subOptions.classList.remove("d-block");
            subOptions.classList.add("d-none");
          } else {
            subOptions.classList.remove("d-none");
            subOptions.classList.add("d-block");
          }
        });
      });
    });
  </script>
</body>
</html>
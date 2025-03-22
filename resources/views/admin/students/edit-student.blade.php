<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="utf-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
  <link rel="apple-touch-icon" sizes="76x76" href="{{asset('admin//apple-icon.png') }}">
  <link rel="icon" type="image/png" href="{{asset('admin//favicon.png') }}">
  <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css" rel="stylesheet">
  
  <title>
    Update Student | LJKU
  </title>
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
            <h6 class="font-weight-bolder text-white mb-0">Add Student </h6>
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
              <div class="card-header d-flex justify-content-between align-items-center pb-0">
                <h6>Student List</h6>

                <a href="{{ route('students.index') }}" class="btn btn-primary btn-sm">Back To List</a>
              </div>
              <div class="container mt-5">
                <div class="card shadow-lg rounded">
                    <div class="card-header bg-primary text-white">
                        <h4 class="mb-0">Student Registration - Multi-Step Form</h4>
                    </div>
                    <div class="card-body">
                        <form id="multiStepForm" action="{{ route('students.update',['id' =>  $student->enrollment_no]) }}" method="POST" enctype="multipart/form-data">
                            @csrf
                            @method('PUT')
                            <!-- Progress Bar -->
                            <div class="progress mb-4">
                                <div class="progress-bar bg-primary" id="form-progress" role="progressbar" style="width: 33%"></div>
                            </div>
        
                            <!-- Step 1: Personal Details -->
                            <div class="step step-1">
                                <h5 class="text-primary">Step 1: Personal Details</h5>
                                <div class="mb-3">
                                    <label class="form-label">First Name</label>
                                    <input type="text" name="first_name" class="form-control" value="{{ $student->first_name}}" required>
                                </div>
                                <div class="mb-3">
                                    <label class="form-label">Last Name</label>
                                    <input type="text" name="last_name" class="form-control" value="{{ $student->last_name}}" required>
                                </div>
                                <div class="mb-3">
                                    <label class="form-label">Phone Number</label>
                                    <input type="text" name="phone_number" class="form-control" value="{{ $student->phone_number}}" required>
                                </div>
                                <button type="button" class="btn btn-primary next-btn float-end">Next <i class="fas fa-arrow-right"></i></button>
                            </div>
        
                            <!-- Step 2: Academic Details -->
                            <div class="step step-2 d-none">
                                <h5 class="text-primary">Step 2: Academic Details</h5>
                                <div class="mb-3">
                                    <label class="form-label">Enrollment No</label>
                                    <input type="text" name="enrollment_no" class="form-control" value="{{ $student->enrollment_no}}" required>
                                </div>
                                <div class="mb-3">
                                    <label class="form-label">Batch</label>
                                    <select name="batch_id" class="form-control" required>
                                        <option value="" disabled>Select Batch</option>
                                        @foreach($batches as $batch)
                                            <option value="{{ $batch->batch_id }}" 
                                                @if(isset($student) && $student->batch_id == $batch->batch_id) selected @endif>
                                                {{ $batch->start_year }} - {{ $batch->end_year }}
                                            </option>
                                        @endforeach
                                    </select>
                                    
                                </div>
                                <div class="mb-3">
                                    <label class="form-label">Department</label>
                                    <select name="dept_id" class="form-control" required>
                                        <option value="" disabled>Select Department</option>
                                        @foreach($departments as $department)
                                            <option value="{{ $department->dept_id }}" 
                                                @if(isset($student) && $student->dept_id == $department->dept_id) selected @endif>
                                                {{ $department->name }}
                                            </option>
                                        @endforeach
                                    </select>
                                    
                                </div>
                                <button type="button" class="btn btn-secondary prev-btn">Previous</button>
                                <button type="button" class="btn btn-primary next-btn float-end">Next</button>
                            </div>
        
                            <!-- Step 3: Account Details & Profile -->
                            <div class="step step-3 d-none">
                                <h5 class="text-primary">Step 3: Account & Profile</h5>
                                <div class="mb-3">
                                    <label class="form-label">Email</label>
                                    <input type="email" name="email" value="{{ $user->email}}"class="form-control" required>
                                </div>
                                <div class="mb-3">
                                    <label class="form-label">Password</label>
                                    <input type="password" name="password" class="form-control" required>
                                </div>
                                <div class="mb-3">
                                    <label class="form-label">Profile Picture</label>
                                    <input type="file" name="profile_picture" class="form-control">
                                </div>
                                <button type="button" class="btn btn-secondary prev-btn">Previous</button>
                                <button type="submit" class="btn btn-success float-end">Submit</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
            </div>
          </div>
        </div>
      </div>
    </main>
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    <script>
        $(document).ready(function () {
            let currentStep = 1;
            const totalSteps = 3;
        
            $(".next-btn").click(function () {
                if (validateStep(currentStep)) {
                    $(".step-" + currentStep).addClass("d-none");
                    currentStep++;
                    $(".step-" + currentStep).removeClass("d-none");
                    updateProgressBar();
                }
            });
        
            $(".prev-btn").click(function () {
                $(".step-" + currentStep).addClass("d-none");
                currentStep--;
                $(".step-" + currentStep).removeClass("d-none");
                updateProgressBar();
            });
        
            function validateStep(step) {
                let isValid = true;
                $(".step-" + step + " input[required], .step-" + step + " select[required]").each(function () {
                    if ($(this).val().trim() === "") {
                        $(this).addClass("is-invalid");
                        isValid = false;
                    } else {
                        $(this).removeClass("is-invalid");
                    }
                });
        
                if (!isValid) {
                    alert("Please fill in all required fields before proceeding.");
                }
        
                return isValid;
            }
        
            function updateProgressBar() {
                let progress = (currentStep / totalSteps) * 100;
                $("#form-progress").css("width", progress + "%");
            }
        });
        </script>
        

</body>
</html>
<!DOCTYPE html>
<html lang="en">
<head>
   <meta charset="UTF-8">
   <meta name="viewport" content="width=device-width, initial-scale=1.0">

   <!--=============== REMIXICONS ===============-->
   <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/remixicon/4.2.0/remixicon.css">
   <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">


   <!--=============== CSS ===============-->
   <link rel="stylesheet" href="{{asset('student/css/sign-up.css')}}">
   <link rel="stylesheet" href="{{asset('student/css/bootstrap.min.css')}}">
   <link rel="stylesheet" href="{{asset('student/css/bootstrap-icons.css')}}">
   <link rel="stylesheet" href="{{asset('student/css/templatemo-topic-listing.css')}}">
   <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
   
   <title>Student Registration | LJKU</title>
</head>
<body>

    @include('user.components.navbar')
   <!--=============== LOGIN IMAGE ===============-->
   <svg class="login__blob" viewBox="0 0 566 840" xmlns="http://www.w3.org/2000/svg">
      <mask id="mask0" mask-type="alpha">
         <path d="M342.407 73.6315C388.53 56.4007 394.378 17.3643 391.538 0H566V840H0C14.5385 834.991 100.266 804.436 77.2046 707.263C49.6393 
            591.11 115.306 518.927 176.468 488.873C363.385 397.026 156.98 302.824 
            167.945 179.32C173.46 117.209 284.755 95.1699 342.407 73.6315Z"/>
      </mask>
   
      <g mask="url(#mask0)">
         <path d="M342.407 73.6315C388.53 56.4007 394.378 17.3643 391.538 
            0H566V840H0C14.5385 834.991 100.266 804.436 77.2046 707.263C49.6393 
            591.11 115.306 518.927 176.468 488.873C363.385 397.026 156.98 302.824 
            167.945 179.32C173.46 117.209 284.755 95.1699 342.407 73.6315Z" fill='#80d0c7'/>
   
      </g>
   </svg>      

   <!--=============== LOGIN ===============-->
   <div class="login container grid" id="loginAccessRegister">
      <!--===== LOGIN ACCESS =====-->
      <div class="login__access">
        <h1 class="login__title"> Student Registration</h1> 
@if ($errors->any())
    <div class="alert alert-danger">
        <ul>
            @foreach ($errors->all() as $error)
                <li>{{ $error }}</li>
            @endforeach
        </ul>
    </div>
@endif
        <div class="login__area">
             <form action="{{ route('student.store') }}" enctype="multipart/form-data" class="login__form" method="post">
                @csrf
                <div id="step-1" class="login__content grid">
                   <h3>Personal Information </h3>
                    <div class="login__box">
                       <input type="text" required placeholder=" " name="first_name" class="login__input">
                       <label for="first_name" class="login__label">First Name</label>
                       <i class="ri-user-fill login__icon"></i>
                    </div>
        
                    <div class="login__box">
                       <input type="text" required placeholder=" " name="last_name" class="login__input">
                       <label for="last_name" class="login__label">Last Name</label>
                       <i class="ri-user-fill login__icon"></i>
                    </div>

                    <div class="login__box">
                       <input type="text" required placeholder=" " name="phone_number" class="login__input">
                       <label for="phone_number" class="login__label">Phone Number</label>
                       <i class="ri-phone-fill login__icon login__password" id="loginPassword"></i>
                    </div>
                
                    <p class="login__switch_container" style="justify-content: end;" >
                        
                       <button type="button" id="next1" class="login__switch_right">Next</button>
                    </p>
                </div>

                <div id="step-2" class="login__content grid" style="display:none;">
                   <h3>Academic Information </h3>
                   <div class="login__box">
                       <input type="text" required placeholder=" " name="enrollment_no" class="login__input">
                       <label for="enrollment_no" class="login__label">Enrollment No</label>
                       <i class="ri-id-card-fill login__icon"></i>
                   </div>
       
                   <div class="login__box">
                    <select name="batch_dept_id" required class="login__input" onchange="updateFields(this)">
                        @foreach($batches as $batch)
                            <option value="{{ $batch->batch_id }}_{{ $batch->department->dept_id }}">
                                {{ $batch->department->name }} {{ $batch->start_year }} - {{ $batch->end_year }}
                            </option>
                        @endforeach
                        <option value="0" selected disabled>Select Batch and Department</option>
                    </select>
                    <input type="hidden" id="batch_id" name="batch_id">
                    <input type="hidden" id="dept_id" name="dept_id">
                    <label for="batch_dept_id" class="login__label">Batch and Department</label>
                    <i class="ri-group-2-fill login__icon"></i>
                </div>
                
                

                   <div class="login__box">
                       <select name="division" required class="login__input">
                            <option value="" disabled selected>Select Division</option>
                            <option value="A"> A </option>
                            <option value="B"> B </option>
                            <option value="C"> C </option>
                            <option value="D"> D </option>
                            <option value="E"> E </option>
                        </select>
                       <label for="division" class="login__label">Division</label>
                       <i class="ri-building-fill login__icon"></i>
                   </div>
       
                   <p class="login__switch_container">
                       <button type="button" id="prev2" class="login__switch_left">Previous</button>
                       <button type="button" id="next2" class="login__switch_right">Next</button>
                   </p>
                </div>

                <div id="step-3" class="login__content grid" style="display:none;">
                   <h3>Profile Information </h3>
                   <div class="login__box">
                       <input type="email" required placeholder=" " name="email" class="login__input">
                       <label for="email" class="login__label">E-mail</label>
                       <i class="ri-mail-fill login__icon"></i>
                   </div>
       
                   <div class="login__box">
                       <input type="password" required placeholder=" " name="password" class="login__input">
                       <label for="password" class="login__label">Password</label>
                       <i class="ri-eye-off-fill login__icon login__password" id="loginPassword"></i>
                   </div>

                   <div class="login__box profile-picture-box">
                        <label for="profilePicture" class="login__label">Profile Picture</label>
                        <div class="profile-picture-input">
                            <input type="file" id="profilePicture" name="profile_picture" class="login__input login__input_file" accept="image/*" onchange="displayFileName()">
                            <label for="profilePicture" class="custom-file-label" ><i class="ri-image-fill login__icon"></i> Choose File</label>
                            <span id="fileName" class="file-name">No file chosen</span>
                        </div>
                    </div>
                
       
                   <p class="login__switch_container">
                       <button type="button" id="prev3" class="login__switch_left">Previous</button>
                       <button type="button" id="submitOtpBtn" class="login__switch_right">Submit</button>
                   </p>
                </div>
                <!-- OTP Verification Modal -->
                
  

            </form>
            <div class="modal fade" id="otpModal" tabindex="-1" aria-labelledby="otpModalLabel" aria-hidden="true">
                <div class="modal-dialog modal-dialog-centered">
                <div class="modal-content p-4">
                    <h5 class="modal-title mb-3" id="otpModalLabel">Verify OTP</h5>
                    <div class="form-group">
                    <input type="text" class="form-control" id="otp_input" placeholder="Enter OTP">
                    </div>
                    <div class="text-end mt-3">
                    <button class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                    <button class="btn btn-primary" id="verifyOtpBtn">Verify</button>
                    </div>
                </div>
                </div>
            </div>
         </div>
      </div>
   </div>
   
   <!--=============== MAIN JS ===============-->
   <script src="{{asset('student/js/sign-up.js')}}"></script>
   <!-- Bootstrap JS Bundle (includes Popper) -->
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>

   <script>
    document.getElementById('next1').addEventListener('click', function() {
        // Validate if all fields in step-1 are filled
        const firstName = document.querySelector('[name="first_name"]');
        const lastName = document.querySelector('[name="last_name"]');
        const phoneNumber = document.querySelector('[name="phone_number"]');
        
        if (firstName.value === '' || lastName.value === '' || phoneNumber.value === '') {
            alert('Please fill in all fields in the Personal Information section.');
        } else {
            document.getElementById('step-1').style.display = 'none';
            document.getElementById('step-2').style.display = 'block';
        }
    });

    document.getElementById('next2').addEventListener('click', function() {
        // Validate if all fields in step-2 are filled
        const enrollmentNo = document.querySelector('[name="enrollment_no"]');
        const deptId = document.querySelector('[name="dept_id"]');
        const batchId = document.querySelector('[name="batch_id"]');
        const division = document.querySelector('[name="division"]');
        
        if (enrollmentNo.value === '' || deptId.value === '' || batchId.value === '' || division.value === '') {
            alert('Please fill in all fields in the Academic Information section.');
        } else {
            document.getElementById('step-2').style.display = 'none';
            document.getElementById('step-3').style.display = 'block';
        }
    });

    document.getElementById('prev2').addEventListener('click', function() {
        document.getElementById('step-2').style.display = 'none';
        document.getElementById('step-1').style.display = 'block';
    });

    document.getElementById('prev3').addEventListener('click', function() {
        document.getElementById('step-3').style.display = 'none';
        document.getElementById('step-2').style.display = 'block';
    });
    function updateFields(selectElement) {
        const value = selectElement.value;
        console.log(value);  // Check the full combined value (e.g., 1_3)
        if (value !== "0") {
            const [batchId, deptId] = value.split('_');
            console.log(batchId, deptId);  // Check if both values are extracted correctly
            document.getElementById('batch_id').value = batchId;
            document.getElementById('dept_id').value = deptId;
        } else {
            document.getElementById('batch_id').value = '';
            document.getElementById('dept_id').value = '';
        }
    }

    

</script>
<script>
document.getElementById('submitOtpBtn').addEventListener('click', function () {
    const form = document.querySelector('.login__form');
    const formData = new FormData(form);

    // Convert FormData to plain object
    const data = {};
    formData.forEach((value, key) => {
        data[key] = value;
    });

    Swal.fire({
        title: 'Validating & Sending OTP...',
        text: 'Please wait while we validate your data and send the OTP.',
        allowOutsideClick: false,
        didOpen: () => {
            Swal.showLoading();
        }
    });

    fetch("{{ route('otp.send') }}", {
    method: "POST",
    headers: {
        "Content-Type": "application/json",
        "X-CSRF-TOKEN": "{{ csrf_token() }}"
    },
    body: JSON.stringify(data)
    })
    .then(async (res) => {
        Swal.close();
        if (res.ok) {
            const data = await res.json();
            if (data.status === "success") {
                const otpModal = new bootstrap.Modal(document.getElementById('otpModal'));
                otpModal.show();
                Swal.fire("Success", data.message, "success");
            } else {
                Swal.fire("Error", data.message || "Something went wrong.", "error");
            }
        } else if (res.status === 422) {
            const errorData = await res.json();
            let errorMessages = Object.values(errorData.errors).flat().join("<br>");
            Swal.fire({
                icon: "error",
                title: "Validation Error",
                html: errorMessages
            });
        } else {
            Swal.fire("Error", "Something went wrong. Please try again.", "error");
        }
    })
    .catch(() => {
        Swal.close();
        Swal.fire("Error", "Request failed. Please check your internet or try again.", "error");
    });

});

document.getElementById('verifyOtpBtn').addEventListener('click', function () {
    const otp = document.getElementById('otp_input').value;
    const email = document.querySelector('[name="email"]').value;

    fetch("{{ route('otp.verify') }}", {
        method: "POST",
        headers: {
            "Content-Type": "application/json",
            "X-CSRF-TOKEN": "{{ csrf_token() }}"
        },
        body: JSON.stringify({ email: email, otp: otp })
    })
    .then(res => res.json())
    .then(data => {
        if (data.status === "verified") {
            document.querySelector('.login__form').submit(); // submit only now
        } else {
            Swal.fire("Invalid OTP", "Please try again.", "error");
        }
    });
});

</script>
    
</body>
</html>

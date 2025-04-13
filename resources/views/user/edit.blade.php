<!doctype html>
<html lang="en">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">

        <meta name="description" content="">
        <meta name="author" content="">

        <title>Edit Profile</title>

        <!-- CSS FILES -->        
        <link rel="preconnect" href="https://fonts.googleapis.com">
        
        <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>

        <link href="https://fonts.googleapis.com/css2?family=Montserrat:wght@500;600;700&family=Open+Sans&display=swap" rel="stylesheet">
                        
        <link href="{{ asset('student/css/bootstrap.min.css')}}" rel="stylesheet">

        <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

        <link href="{{ asset('student/css/bootstrap-icons.css')}}" rel="stylesheet">
        <link href="{{ asset('student/css/templatemo-topic-listing.css')}}" rel="stylesheet">      

        <style>
            :root {
                --primary-color: #4e73df;
                --secondary-color: #858796;
                --success-color: #1cc88a;
                --info-color: #36b9cc;
                --warning-color: #f6c23e;
                --danger-color: #e74a3b;
            }

            body {
                background: #f8f9fc;
            }

            .profile-form-container {
                background: #fff;
                border-radius: 20px;
                box-shadow: 0 0.15rem 1.75rem 0 rgba(58, 59, 69, 0.15);
                padding: 2rem;
                margin-top: 2rem;
                margin-bottom: 2rem;
                transition: all 0.3s ease;
            }

            .profile-form-container:hover {
                box-shadow: 0 0.15rem 1.75rem 0 rgba(58, 59, 69, 0.25);
            }

            .profile-section {
                background: linear-gradient(135deg, var(--primary-color), #224abe);
                border-radius: 15px;
                padding: 1.5rem;
                color: white;
                height: 100%;
                display: flex;
                flex-direction: column;
                align-items: center;
                justify-content: flex-start;
                position: relative;
                overflow: hidden;
                min-height: 300px;
            }

            .profile-section::before {
                content: '';
                position: absolute;
                top: 0;
                left: 0;
                right: 0;
                bottom: 0;
                background: url('data:image/svg+xml,<svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 1440 320"><path fill="%23ffffff" fill-opacity="0.1" d="M0,96L48,112C96,128,192,160,288,160C384,160,480,128,576,112C672,96,768,96,864,112C960,128,1056,160,1152,160C1248,160,1344,128,1392,112L1440,96L1440,320L1392,320C1344,320,1248,320,1152,320C1056,320,960,320,864,320C768,320,672,320,576,320C480,320,384,320,288,320C192,320,96,320,48,320L0,320Z"></path></svg>');
                background-size: cover;
                opacity: 0.1;
            }

            .profile-picture-container {
                position: relative;
                width: 250px;
                height: 250px;
                margin: 0 auto 1.5rem;
                z-index: 1;
            }

            .profile-picture-preview {
                width: 100%;
                height: 100%;
                border-radius: 10px;
                object-fit: cover;
                border: 3px solid rgba(255, 255, 255, 0.3);
                box-shadow: 0 0 20px rgba(0,0,0,0.2);
                transition: all 0.3s ease;
            }

            .profile-picture-preview:hover {
                transform: scale(1.05);
                border-color: rgba(255, 255, 255, 0.5);
            }

            .custom-file-upload {
                position: absolute;
                bottom: 5px;
                right: 5px;
                background: white;
                color: var(--primary-color);
                width: 35px;
                height: 35px;
                border-radius: 8px;
                display: flex;
                align-items: center;
                justify-content: center;
                cursor: pointer;
                transition: all 0.3s ease;
                box-shadow: 0 2px 5px rgba(0,0,0,0.2);
                z-index: 2;
            }

            .custom-file-upload:hover {
                transform: scale(1.1);
                background: var(--primary-color);
                color: white;
            }

            .form-section {
                background: #fff;
                border-radius: 15px;
                padding: 1.5rem;
                margin-bottom: 1.5rem;
                border: 1px solid #e3e6f0;
                transition: all 0.3s ease;
                height: 100%;
                min-height: 300px;
            }

            .form-section:hover {
                border-color: var(--primary-color);
            }

            .section-title {
                color: var(--primary-color);
                font-size: 1.1rem;
                font-weight: 700;
                margin-bottom: 1.5rem;
                display: flex;
                align-items: center;
                gap: 0.5rem;
            }

            .form-control, .form-select {
                border-radius: 10px;
                padding: 0.75rem 1rem;
                border: 1px solid #e3e6f0;
                transition: all 0.3s ease;
            }

            .form-control:focus, .form-select:focus {
                border-color: var(--primary-color);
                box-shadow: 0 0 0 0.2rem rgba(78, 115, 223, 0.25);
            }

            .input-group-text {
                border-radius: 10px;
                background: #f8f9fc;
                border: 1px solid #e3e6f0;
            }

            .btn-update-profile {
                background: var(--primary-color);
                border: none;
                padding: 0.75rem 2rem;
                font-weight: 600;
                border-radius: 10px;
                transition: all 0.3s ease;
            }

            .btn-update-profile:hover {
                background: #2e59d9;
                transform: translateY(-2px);
                box-shadow: 0 5px 15px rgba(78, 115, 223, 0.3);
            }

            .form-label {
                font-weight: 600;
                color: var(--secondary-color);
                margin-bottom: 0.5rem;
            }

            .form-text {
                color: var(--secondary-color);
                font-size: 0.85rem;
            }

            .input-group {
                box-shadow: 0 2px 5px rgba(0,0,0,0.05);
                border-radius: 10px;
            }

            .input-group .form-control {
                border: none;
            }

            .input-group .input-group-text {
                border: none;
            }

            .profile-name {
                color: white;
                font-size: 1.2rem;
                font-weight: 700;
                margin-bottom: 0.25rem;
                text-align: center;
                z-index: 1;
            }

            .profile-role {
                color: rgba(255, 255, 255, 0.8);
                font-size: 0.9rem;
                margin-bottom: 0.5rem;
                text-align: center;
                z-index: 1;
            }

            .section-content {
                z-index: 1;
            }

            @media (max-width: 768px) {
                .profile-form-container {
                    padding: 1rem;
                }
                
                .profile-picture-container {
                    width: 150px;
                    height: 150px;
                }

                .profile-section, .form-section {
                    min-height: auto;
                    margin-bottom: 1rem;
                }
            }
        </style>

    </head>
    
    <body id="top">
        <main>
            @include('user.components.navbar')

            <section class="hero-section" id="section_1" style="margin-top: -150px">
                <div class="container">
                    <div class="row justify-content-center">
                        <div class="col-12 col-lg-10">
                            <div class="profile-form-container">
                                <h2 class="text-center mb-4" style="color: var(--primary-color); font-weight: 700;">Edit Your Profile</h2>
                                
                                <form action="{{ route('student.update', ['enrollment_no' => $student->enrollment_no]) }}" method="POST" enctype="multipart/form-data">
                                    @csrf
                                    @method('PUT')

                                    <div class="row">
                                        <!-- Top Left - Profile Picture -->
                                        <div class="col-md-6 mb-4">
                                            <div class="profile-section">
                                                <div class="profile-picture-container">
                                                    @if($student->profile_picture)
                                                        <img src="{{ asset( $student->profile_picture) }}" alt="Current Profile Picture" class="profile-picture-preview" id="profilePreview">
                                                    @else
                                                        <img src="{{ asset('images/default-avatar.png') }}" alt="Default Profile Picture" class="profile-picture-preview" id="profilePreview">
                                                    @endif
                                                    <label class="custom-file-upload" title="Change Profile Picture">
                                                        <input type="file" class="form-control" id="profile_picture" name="profile_picture" style="display: none;" onchange="previewImage(this)">
                                                        <i class="bi bi-camera"></i>
                                                    </label>
                                                </div>
                                                <h3 class="profile-name">{{ $student->first_name }} {{ $student->last_name }}</h3>
                                                <p class="profile-role">{{ $student->department->name }} Student</p>
                                            </div>
                                        </div>

                                        <!-- Top Right - Personal Information -->
                                        <div class="col-md-6 mb-4">
                                            <div class="form-section">
                                                <div class="section-title">
                                                    <i class="bi bi-person"></i>
                                                    Personal Information
                                                </div>
                                                <div class="section-content">
                                                    <div class="row">
                                                        <div class="col-md-6 mb-3">
                                                            <label for="first_name" class="form-label">First Name</label>
                                                            <input type="text" class="form-control" id="first_name" name="first_name" value="{{ $student->first_name }}" required>
                                                        </div>
                                                        <div class="col-md-6 mb-3">
                                                            <label for="last_name" class="form-label">Last Name</label>
                                                            <input type="text" class="form-control" id="last_name" name="last_name" value="{{ $student->last_name }}" required>
                                                        </div>
                                                    </div>
                                                    <div class="mb-3">
                                                        <label for="phone_number" class="form-label">Phone Number</label>
                                                        <div class="input-group">
                                                            <span class="input-group-text"><i class="bi bi-phone"></i></span>
                                                            <input type="text" class="form-control" id="phone_number" name="phone_number" value="{{ $student->phone_number }}" required>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>

                                        <!-- Bottom Left - Academic Information -->
                                        <div class="col-md-6 mb-4">
                                            <div class="form-section">
                                                <div class="section-title">
                                                    <i class="bi bi-mortarboard"></i>
                                                    Academic Information
                                                </div>
                                                <div class="section-content">
                                                    <div class="mb-3">
                                                        <label for="dept_id" class="form-label">Department & Batch</label>
                                                        <select name="batch_dept_id" required class="form-select" onchange="updateFields(this)">
                                                            @php
                                                                $uniqueBatches = $batches->unique(function($batch) {
                                                                    return $batch->batch_id . '_' . $batch->department->dept_id;
                                                                });
                                                            @endphp
                                                            <option value="{{ $student->dept_id }}_{{ $student->batch_id }}" selected>
                                                                {{ $student->department->name }} {{ $student->batch->start_year }} - {{ $student->batch->end_year }}
                                                            </option>
                                                            @foreach($uniqueBatches as $batch)
                                                                <option value="{{ $batch->batch_id }}_{{ $batch->department->dept_id }}">
                                                                    {{ $batch->department->name }} {{ $batch->start_year }} - {{ $batch->end_year }}
                                                                </option>
                                                            @endforeach
                                                        </select>
                                                    </div>
                                                    <div class="mb-3">
                                                        <label for="division" class="form-label">Division</label>
                                                        <select name="division" class="form-select">
                                                            @foreach(['A', 'B', 'C', 'D', 'E'] as $div)
                                                                <option value="{{ $div }}" {{ $student->division === $div ? 'selected' : '' }}>
                                                                    Division {{ $div }}
                                                                </option>
                                                            @endforeach
                                                        </select>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>

                                        <!-- Bottom Right - Security -->
                                        <div class="col-md-6 mb-4">
                                            <div class="form-section">
                                                <div class="section-title">
                                                    <i class="bi bi-shield-lock"></i>
                                                    Security
                                                </div>
                                                <div class="section-content">
                                                    <div class="mb-3">
                                                        <label for="password" class="form-label">E-mail</label>
                                                        <div class="input-group">
                                                            <span class="input-group-text"><i class="bi bi-envelope"></i></span>
                                                            <input type="email" class="form-control" id="password" name="password" value="{{ $student->email }}" placeholder="" disabled>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="section-content">
                                                    <div class="mb-3">
                                                        <label for="password" class="form-label">Change Password</label>
                                                        <div class="input-group">
                                                            <span class="input-group-text"><i class="bi bi-lock"></i></span>
                                                            <input type="password" class="form-control" id="password" name="password" placeholder="Leave blank to keep current password">
                                                        </div>
                                                        <div class="form-text">Only fill this if you want to change your password</div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>

                                    <input type="hidden" id="batch_id" name="batch_id">
                                    <input type="hidden" id="dept_id" name="dept_id">

                                    <div class="text-center mt-4">
                                        <button type="submit" class="btn btn-update-profile">
                                            <i class="bi bi-check-circle me-2"></i>Update Profile
                                        </button>
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
            </section>
        </main>

        <script>
            function updateFields(selectElement) {
                var selectedValue = selectElement.value.split('_');
                document.getElementById('batch_id').value = selectedValue[0];
                document.getElementById('dept_id').value = selectedValue[1];
            }

            function previewImage(input) {
                if (input.files && input.files[0]) {
                    var reader = new FileReader();
                    reader.onload = function(e) {
                        document.getElementById('profilePreview').src = e.target.result;
                    }
                    reader.readAsDataURL(input.files[0]);
                }
            }

            // Initialize the fields on page load
            updateFields(document.querySelector('select[name="batch_dept_id"]'));
        </script>
    </body>
</html>
<!doctype html>
<html lang="en">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">

        <meta name="description" content="">
        <meta name="author" content="">

        <title>Student Profile</title>

        <!-- CSS FILES -->        
        <link rel="preconnect" href="https://fonts.googleapis.com">
        
        <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>

        <link href="https://fonts.googleapis.com/css2?family=Montserrat:wght@500;600;700&family=Open+Sans&display=swap" rel="stylesheet">
        <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet">
                        
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

            .profile-header {
                background: linear-gradient(135deg, var(--primary-color), #224abe);
                padding: 3rem 0;
                margin-bottom: 2rem;
                position: relative;
                overflow: hidden;
            }

            .profile-header::before {
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

            .profile-picture {
                width: 180px;
                height: 180px;
                border-radius: 15px;
                border: 4px solid rgba(255, 255, 255, 0.3);
                box-shadow: 0 0 20px rgba(0,0,0,0.2);
                transition: all 0.3s ease;
                object-fit: cover;
            }

            .profile-picture:hover {
                transform: scale(1.05);
                border-color: rgba(255, 255, 255, 0.5);
            }

            .profile-name {
                color: white;
                font-size: 2rem;
                font-weight: 700;
                margin: 1rem 0 0.5rem;
                text-shadow: 0 2px 4px rgba(0,0,0,0.1);
            }

            .profile-role {
                color: rgba(255, 255, 255, 0.9);
                font-size: 1.1rem;
                margin-bottom: 0;
            }

            .info-card {
                background: white;
                border-radius: 15px;
                padding: 1.5rem;
                margin-bottom: 1.5rem;
                box-shadow: 0 0.15rem 1.75rem 0 rgba(58, 59, 69, 0.15);
                transition: all 0.3s ease;
                height: 100%;
            }

            .info-card:hover {
                transform: translateY(-5px);
                box-shadow: 0 0.15rem 1.75rem 0 rgba(58, 59, 69, 0.25);
            }

            .info-label {
                color: var(--secondary-color);
                font-size: 0.9rem;
                font-weight: 600;
                margin-bottom: 0.5rem;
            }

            .info-value {
                color: #2e3a4e;
                font-size: 1.1rem;
                font-weight: 600;
                margin-bottom: 0;
            }

            .edit-profile-btn {
                background: var(--primary-color);
                color: white;
                padding: 0.75rem 2rem;
                border-radius: 10px;
                font-weight: 600;
                transition: all 0.3s ease;
                border: none;
                text-decoration: none;
                display: inline-block;
            }

            .edit-profile-btn:hover {
                background: #2e59d9;
                transform: translateY(-2px);
                box-shadow: 0 5px 15px rgba(78, 115, 223, 0.3);
                color: white;
            }

            .info-icon {
                color: var(--primary-color);
                font-size: 1.5rem;
                margin-bottom: 1rem;
            }

            @media (max-width: 768px) {
                .profile-picture {
                    width: 150px;
                    height: 150px;
                }

                .profile-name {
                    font-size: 1.5rem;
                }

                .profile-role {
                    font-size: 1rem;
                }
            }
        </style>
    </head>
    
    <body id="top">
        <main>
            @include('user.components.navbar')

            <!-- Profile Header -->
            <div class="profile-header">
                <div class="container">
                    <div class="row align-items-center">
                        <div class="col-md-3 text-center">
                            @if($student->profile_picture && $student->profile_picture !== 'profile_pictures/default.png')
                                <img src="{{ asset($student->profile_picture) }}" 
                                     alt="Profile Picture" class="profile-picture">
                            @else
                                <img src="{{ asset('profile_pictures/default.png') }}" 
                                     alt="Default Profile Picture" class="profile-picture">
                            @endif
                        </div>
                        <div class="col-md-9" style="z-index: 10">
                            <h1 class="profile-name">{{ $student->first_name }} {{ $student->last_name }}</h1>
                            <p class="profile-role">{{ $departments->name }} Student</p>
                            <a href="{{ route('student.edit', ['enrollment_no' => $student->enrollment_no]) }}" 
                               class="edit-profile-btn mt-3">
                                <i class="bi bi-pencil-square me-2"></i>Edit Profile
                            </a>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Profile Information -->
            <div class="container">
                <div class="row">
                    <!-- Academic Information -->
                    <div class="col-md-6 mb-4">
                        <div class="info-card">
                            <i class="bi bi-mortarboard info-icon"></i>
                            <h3 class="h5 mb-4">Academic Information</h3>
                            <div class="row g-3">
                                <div class="col-6">
                                    <div class="info-label">Enrollment Number</div>
                                    <div class="info-value">{{ $student->enrollment_no }}</div>
                                </div>
                                <div class="col-6">
                                    <div class="info-label">Semester & Division</div>
                                    <div class="info-value">{{ $semesters }} - {{ $student->division }}</div>
                                </div>
                                <div class="col-12">
                                    <div class="info-label">Batch & Department</div>
                                    <div class="info-value">{{ $departments->name }} [ {{ $batches->start_year }} - {{ $batches->end_year }} ]</div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Contact Information -->
                    <div class="col-md-6 mb-4">
                        <div class="info-card">
                            <i class="bi bi-person-circle info-icon"></i>
                            <h3 class="h5 mb-4">Contact Information</h3>
                            <div class="row g-3">
                                <div class="col-12">
                                    <div class="info-label">Email Address</div>
                                    <div class="info-value">{{ $student->email }}</div>
                                </div>
                                <div class="col-12">
                                    <div class="info-label">Phone Number</div>
                                    <div class="info-value">{{ $student->phone_number }}</div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </main>

        <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js"></script>
    </body>
</html>
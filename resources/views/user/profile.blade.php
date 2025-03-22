<!doctype html>
<html lang="en">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">

        <meta name="description" content="">
        <meta name="author" content="">

        <title>Topic Listing Bootstrap 5 Template</title>

        <!-- CSS FILES -->        
        <link rel="preconnect" href="https://fonts.googleapis.com">
        
        <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>

        <link href="https://fonts.googleapis.com/css2?family=Montserrat:wght@500;600;700&family=Open+Sans&display=swap" rel="stylesheet">
        <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet">
                        
        <link href="{{ asset('student/css/bootstrap.min.css')}}" rel="stylesheet">

        <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

        <link href="{{ asset('student/css/bootstrap-icons.css')}}" rel="stylesheet">
        <link href="{{ asset('student/css/templatemo-topic-listing.css')}}" rel="stylesheet">      

    </head>
    
    <body id="top">
        <main>
            @include('user.components.navbar')
            <div class="container mt-5 d-flex justify-content-center">
                <div class="card shadow-lg p-4" style="max-width: 800px; width: 100%;">
                    <div class="card-header text-center">
                        <h2 class="mb-0">Profile Details</h2>
                    </div>
            
                    <div class="card-body text-center">
                        <!-- Profile Picture -->
                        <div class="mb-4">
                            <label class="form-label fw-bold">Profile Picture</label>
                            <div>
                                @if($student->profile_picture && $student->profile_picture !== 'profile_pictures/default.png')
                                    <img src="{{  asset($student->profile_picture) }}" 
                                         alt="Profile Picture" class="rounded-circle img-fluid"
                                         style="width: 150px; height: 150px; object-fit: cover;">
                                @else
                                    <img src="{{ asset('profile_pictures/default.png') }}" 
                                         alt="Default Profile Picture" class="rounded-circle img-fluid"
                                         style="width: 150px; height: 150px; object-fit: cover;">
                                @endif
                            </div>
                        </div>
            
                        <!-- Two Column Layout -->
                        <div class="row row-cols-1 row-cols-md-2 g-3">
                            <!-- Name -->
                            <div class="col">
                                <label class="fw-bold">Name</label>
                                <p>{{ $student->first_name }} {{ $student->last_name }}</p>
                            </div>
            
                            <!-- Enrollment Number -->
                            <div class="col">
                                <label class="fw-bold">Enrollment Number</label>
                                <p>{{ $student->enrollment_no }}</p>
                            </div>
            
                            <!-- Email -->
                            <div class="col">
                                <label class="fw-bold">Email</label>
                                <p>{{ $student->email }}</p>
                            </div>
            
                            <!-- Phone Number -->
                            <div class="col">
                                <label class="fw-bold">Phone Number</label>
                                <p>{{ $student->phone_number }}</p>
                            </div>
            
                            <!-- Semester & Division -->
                            <div class="col">
                                <label class="fw-bold">Semester & Division</label>
                                <p>{{ $semesters }} - {{ $student->division }}</p>
                            </div>
            
                            <!-- Batch & Department -->
                            <div class="col">
                                <label class="fw-bold">Batch & Department</label>
                                <p>{{ $departments->name }} [ {{ $batches->start_year }} - {{ $batches->end_year }} ]</p>
                            </div>
                        </div>
            
                        <!-- Edit Profile Button -->
                        <div class="d-grid mt-4">
                            
                            <a href="{{ route('student.edit', ['enrollment_no' => $student->enrollment_no]) }}" class="btn btn-primary">Edit Profile</a>

                        </div>
                    </div>
                </div>
            </div>
            

</main>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js"></script>

    </body>
</html>
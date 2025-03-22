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
                        
        <link href="{{ asset('student/css/bootstrap.min.css')}}" rel="stylesheet">

        <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

        <link href="{{ asset('student/css/bootstrap-icons.css')}}" rel="stylesheet">
        <link href="{{ asset('student/css/templatemo-topic-listing.css')}}" rel="stylesheet">      

    </head>
    
    <body id="top">
        <main>
            @include('user.components.navbar')

            <section class="hero-section d-flex justify-content-center align-items-center" id="section_1">
                <form action="{{ route('student.update', ['enrollment_no' => $student->enrollment_no]) }}" method="POST" enctype="multipart/form-data">
                    @csrf
                    @method('PUT')
                
                    <!-- First Name -->
                    <div class="mb-3">
                        <label for="first_name" class="form-label">First Name</label>
                        <input type="text" class="form-control" id="first_name" name="first_name" value="{{ $student->first_name }}" required>
                    </div>
                
                    <!-- Last Name -->
                    <div class="mb-3">
                        <label for="last_name" class="form-label">Last Name</label>
                        <input type="text" class="form-control" id="last_name" name="last_name" value="{{ $student->last_name }}" required>
                    </div>
                
                    <!-- Phone Number -->
                    <div class="mb-3">
                        <label for="phone_number" class="form-label">Phone Number</label>
                        <input type="text" class="form-control" id="phone_number" name="phone_number" value="{{ $student->phone_number }}" required>
                    </div>
                
                    <!-- Department ID -->
                    <div class="mb-3">
                        <label for="dept_id" class="form-label">Department</label>
                        <select name="batch_dept_id" required class="login__input form-control" onchange="updateFields(this)">
                            @php
                                // Combine batch_id and department_id to create unique options
                                $uniqueBatches = $batches->unique(function($batch) {
                                    return $batch->batch_id . '_' . $batch->department->dept_id;
                                });
                            @endphp

                            <!-- Selected Batch -->
                            <option value="{{ $student->dept_id }}_{{ $student->batch_id }}" selected>
                                {{ $student->department->name }} {{ $student->batch->start_year }} - {{ $student->batch->end_year }}
                            </option>

                            <!-- Loop through unique batches -->
                            @foreach($uniqueBatches as $batch)
                                <option value="{{ $batch->batch_id }}_{{ $batch->department->dept_id }}">
                                    {{ $batch->department->name }} {{ $batch->start_year }} - {{ $batch->end_year }}
                                </option>
                            @endforeach
                        </select>
                        <input type="hidden" id="batch_id" name="batch_id">
                        <input type="hidden" id="dept_id" name="dept_id">
                    </div>
                
                    <!-- Profile Picture -->
                    <div class="mb-3">
                        <label for="profile_picture" class="form-label">Profile Picture</label>
                        <input type="file" class="form-control" id="profile_picture" name="profile_picture">
                    </div>
                
                    <!-- Password -->
                    <div class="mb-3">
                        <label for="password" class="form-label">Password (Leave blank to keep current password)</label>
                        <input type="password" class="form-control" id="password" name="password">
                    </div>
                
                    <!-- Division -->
                    <div class="mb-3">
                        <label for="division" class="form-label">Division</label>
                        <select name="division" class="form-control">
                            <option value="A" {{ $student->division === 'A' ? 'selected' : '' }}>A</option>
                            <option value="B" {{ $student->division === 'B' ? 'selected' : '' }}>B</option>
                            <option value="C" {{ $student->division === 'C' ? 'selected' : '' }}>C</option>
                            <option value="D" {{ $student->division === 'D' ? 'selected' : '' }}>D</option>
                            <option value="E" {{ $student->division === 'E' ? 'selected' : '' }}>E</option>
                        </select>
                    </div>
                
                    <button type="submit" class="btn btn-primary">Update Profile</button>
                </form>
                 
            </section>

         

        </main>
    </body>
    <script>
        // Update hidden input fields based on the selected batch-department option
        function updateFields(selectElement) {
            var selectedValue = selectElement.value.split('_');
            
            // Update the hidden inputs with the batch_id and dept_id
            document.getElementById('batch_id').value = selectedValue[0];
            document.getElementById('dept_id').value = selectedValue[1];
        }
    
        // Call the function to set initial values
        updateFields(document.querySelector('select[name="batch_dept_id"]'));
    </script>
</html>
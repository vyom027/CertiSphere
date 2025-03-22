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

    <body>
        <main>

            @include('user.components.navbar')
    
            <div class="container mt-4">
                <h1 class="text-center">Course Gallery</h1>
                <div class="row">
                    @foreach($courses as $course)
                        <div class="col-md-4">
                            <div class="card mb-4">
                                <img src="https://via.placeholder.com/300x200?text={{ urlencode($course['name']) }}" class="card-img-top" alt="{{ $course['name'] }}">
                                <div class="card-body">
                                    <h5 class="card-title">{{ $course['name'] }}</h5>
                                    <a href="https://www.coursera.org/learn/{{ $course['slug'] ?? '#' }}" target="_blank" class="btn btn-primary">View Course</a>
                                </div>
                            </div>
                        </div>
                    @endforeach
                </div>
            </div>
        </main>

    </body>
</html>
<!doctype html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Coursera Course Search</title>

    <!-- Google Fonts -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Montserrat:wght@500;600;700&family=Open+Sans&display=swap" rel="stylesheet">

    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="{{ asset('student/css/bootstrap.min.css')}}" rel="stylesheet">
    <link href="{{ asset('student/css/bootstrap-icons.css')}}" rel="stylesheet">
    <link href="{{ asset('student/css/templatemo-topic-listing.css')}}" rel="stylesheet">
</head>

<body id="top">
<main>
    @include('user.components.navbar')

    <div class="container mt-5">
        <!-- Search Form -->
        <div class="row justify-content-center">
            <div class="col-md-8">
                <form method="GET" action="{{ route('coursesNew.search') }}" class="d-flex gap-2">
                    <input name="keyword" type="search" class="form-control" id="keyword" placeholder="Search Coursera courses..." value="{{ old('keyword', $query ?? '') }}">
                    <button type="submit" class="btn btn-primary">Search</button>
                </form>
            </div>
        </div>

        <!-- Results -->
        @if(isset($courses))
        <div class="row justify-content-center mt-4">
            <div class="col-md-10">
                <div class="card shadow p-4">
                    <div class="card-header text-center mb-3">
                        <h4>Search Results for: <span class="text-primary">{{ $query }}</span></h4>
                    </div>
                    <ul class="list-group list-group-flush">
                        @forelse($courses as $course)
                            <li class="list-group-item d-flex justify-content-between align-items-center">
                                <div>
                                    <h6 class="mb-0">{{ $course['name'] }}</h6>
                                    <small class="text-muted">Course ID: {{ $course['id'] }}</small>
                                </div>
                                <a href="{{ $course['link'] }}" target="_blank" class="btn btn-outline-primary btn-sm">View Course</a>
                            </li>
                        @empty
                            <li class="list-group-item text-center">No courses found for your search.</li>
                        @endforelse
                    </ul>
                </div>
            </div>
        </div>
        @endif
    </div>
</main>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>

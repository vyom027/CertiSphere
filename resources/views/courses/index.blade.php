<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Coursera Courses</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <!-- Your existing styling with some enhancements -->
    <style>
        .course-list {
            list-style: none;
            padding: 0;
            display: grid;
            grid-template-columns: repeat(auto-fill, minmax(300px, 1fr));
            gap: 20px;
        }
        .course-item {
            margin-bottom: 20px;
            padding: 15px;
            border: 1px solid #ddd;
            border-radius: 8px;
            transition: all 0.3s ease;
            background-color: #fff;
            height: 100%;
            display: flex;
            flex-direction: column;
        }
        .course-item:hover {
            transform: translateY(-5px);
            box-shadow: 0 10px 20px rgba(0,0,0,0.1);
            border-color: #0056D2;
        }
        .course-image {
            width: 100%;
            height: 180px;
            object-fit: cover;
            border-radius: 6px;
            margin-bottom: 15px;
            border: 1px solid #eee;
        }
        .course-link {
            display: inline-block;
            padding: 8px 15px;
            background-color: #0056D2; /* Coursera blue */
            color: white;
            text-decoration: none;
            border-radius: 4px;
            margin-top: auto;
            transition: all 0.3s;
            text-align: center;
            font-weight: 500;
        }
        .course-link:hover {
            background-color: #003d94;
            transform: scale(1.05);
        }
        .course-title {
            font-size: 1.2rem;
            margin: 10px 0;
            color: #333;
            font-weight: 600;
            line-height: 1.4;
        }
        .course-description {
            color: #666;
            font-size: 0.9rem;
            margin-bottom: 20px;
            display: -webkit-box;
            -webkit-line-clamp: 3;
            -webkit-box-orient: vertical;
            overflow: hidden;
        }
        .page-header {
            background-color: #0056D2;
            color: white;
            padding: 20px 0;
            margin-bottom: 30px;
            text-align: center;
            border-radius: 0 0 10px 10px;
        }
        .container {
            max-width: 1200px;
            margin: 0 auto;
            padding: 0 15px;
        }
        .course-provider {
            font-size: 0.8rem;
            color: #0056D2;
            margin-bottom: 10px;
            display: flex;
            align-items: center;
        }
        .course-provider img {
            height: 20px;
            margin-right: 5px;
        }
        .empty-state {
            text-align: center;
            padding: 50px 20px;
            background-color: #f9f9f9;
            border-radius: 8px;
            margin: 30px auto;
            max-width: 600px;
        }
        .empty-state i {
            font-size: 3rem;
            color: #ccc;
            margin-bottom: 20px;
            display: block;
        }
    </style>
</head>
<body class="bg-light">
    <div class="page-header">
        <div class="container">
            <h1>Coursera Courses</h1>
            <p>Explore top courses from Coursera and enhance your skills</p>
        </div>
    </div>

    <div class="container">
        @if(isset($courses['elements']) && count($courses['elements']) > 0)
            <div class="row mb-4">
                <div class="col-12">
                    <p class="text-muted">Showing {{ count($courses['elements']) }} courses from Coursera</p>
                </div>
            </div>

            <ul class="course-list">
                @foreach($courses['elements'] as $course)
                    <li class="course-item">
                        <img 
                            src="https://ui-avatars.com/api/?name={{ urlencode($course['name']) }}&background=random&size=300&length=2&bold=true&format=svg"
                            alt="{{ $course['name'] }}" 
                            class="course-image"
                            onerror="this.src='https://placehold.co/600x400?text=Course+Image'"
                        >
                        <div class="course-provider">
                            <img src="https://d3njjcbhbojbot.cloudfront.net/web/images/logos/logo-coursera-dark.svg" alt="Coursera">
                            Coursera
                        </div>
                        <h2 class="course-title">{{ $course['name'] }}</h2>
                        @if(isset($course['description']))
                            <p class="course-description">{{ $course['description'] }}</p>
                        @else
                            <p class="course-description">Learn more about this course by visiting Coursera.</p>
                        @endif
                        <a href="https://www.coursera.org/learn/{{ $course['slug'] }}" 
                           target="_blank" 
                           class="course-link">
                            View Course on Coursera
                        </a>
                    </li>
                @endforeach
            </ul>
        @else
            <div class="empty-state">
                <i class="bi bi-search"></i>
                <h3>No Courses Found</h3>
                <p>We couldn't find any courses from Coursera at the moment. Please try again later.</p>
            </div>
        @endif
    </div>

    <footer class="mt-5 py-4 bg-dark text-white text-center">
        <div class="container">
            <p class="mb-0">© 2023 Your Educational CMS. All courses are provided through Coursera.</p>
        </div>
    </footer>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>

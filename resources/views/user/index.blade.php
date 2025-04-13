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
<style>
/* Add styles for the scrollable container */
.tab-scroll-container {
    overflow-x: auto;  /* Allows horizontal scrolling */
    white-space: nowrap;  /* Prevents the tabs from wrapping to a new line */
    padding-bottom: 10px; /* Adds some space below the tabs */
}

/* Center the tabs horizontally */
.navs-tabs {
    display: flex; /* Ensures the tabs are laid out in a row */
    justify-content: center; /* Centers the tabs in the container */
    align-items: center; /* Vertically aligns the tabs */
    width: 100%;
}

/* Keep each nav-item from wrapping */
.navs-item {
    white-space: nowrap;  /* Prevents the tab name from wrapping */
    margin: 0 15px;  /* Adds some spacing between tabs */
}

/* Add space between the active tab and other tabs */
.navs-link {
    text-align: center; /* Centers the text inside each tab */
}


</style>

    </head>
    
    <body id="top">
        @if(session('welcome_student'))
        <script>
            Swal.fire({
                title: "{{ session('welcome_student') }}",
                text: "You have successfully logged in.",
                icon: "success",
                toast: true,
                position: "top-end",
                showConfirmButton: true,
                confirmButtonText: "Close",
                timer: 3000,
                timerProgressBar: false,

                didOpen: (toast) => {
                    toast.addEventListener('mouseenter', Swal.stopTimer)
                    toast.addEventListener('mouseleave', Swal.resumeTimer)
                }
            });
        </script>
        @endif
        <main>

                @include('user.components.navbar')
            

            <section class="hero-section d-flex justify-content-center align-items-center" id="section_1">
                <div class="container">
                    <div class="row">

                        <div class="col-lg-8 col-12 mx-auto">
                            <h1 class="text-white text-center">Discover. Learn. Enjoy</h1>

                            <h6 class="text-center">platform for creatives around the world</h6>

                            <form method="GET" action="{{ route('coursesNew.search') }}" class="custom-form mt-4 pt-2 mb-lg-0 mb-5" role="search">
                                <div class="input-group input-group-lg">
                                    <span class="input-group-text bi-search" id="basic-addon1"></span>
                            
                                    <input name="keyword" type="search" class="form-control" id="keyword" placeholder="Search">
                            
                                    <button type="submit" class="btn btn-primary">Search</button>
                                </div>
                            </form>
                            
                        </div>

                    </div>
                </div>
            </section>


            <section class="featured-section">
                <div class="container">
                    <div class="row justify-content-center">

                        <div class="col-lg-4 col-12 mb-4 mb-lg-0">
                            <div class="custom-block bg-white shadow-lg">
                                <a href="{{ route('coursesNew.search', ['keyword' => 'Web Design']) }}">
                                    <div class="d-flex">
                                        <div>
                                            <h5 class="mb-2">Web Design</h5>

                                            <p class="mb-0">Web design is the art of creating visually appealing and user-friendly websites. It combines creativity with technical skills to deliver engaging digital experiences.</p>
                                        </div>

                                    </div>

                                    <img src="{{ asset('student/images/topics/undraw_Remote_design_team_re_urdx.png')}}" class="custom-block-image img-fluid" alt="">
                                </a>
                            </div>
                        </div>

                        <div class="col-lg-6 col-12">
                            <a href="{{ route('coursesNew.search', ['keyword' => 'API']) }}">
                            <div class="custom-block custom-block-overlay">
                                <div class="d-flex flex-column h-100">
                                    <img src="{{ asset('student/images/businesswoman-using-tablet-analysis.jpg')}}" class="custom-block-image img-fluid" alt="">

                                    <div class="custom-block-overlay-text d-flex">
                                        <div>
                                            <h5 class="text-white mb-2">API</h5>
                                            <p class="text-white">APIs (Application Programming Interfaces) allow different software applications to communicate with each other. They enable developers to integrate functionalities, access data, and build innovative solutions efficiently.</p>

                                            
                                        </div>

                                    </div>
                                    
                                    <div class="section-overlay"></div>
                                </div>
                            </div>
                        </a>
                        </div>

                    </div>
                </div>
            </section>
        @if(session('student_logged_in'))
            <div class="container" style="margin-top:40px">
                <div class="row">
                    <div class="col-12 text-center">
                        <h2 class="mb-4">College Courses</h2>
                    </div>
                </div>
            </div>

            <div class="container" >
                @if($clgCourses->isEmpty())
                    <div class="row">
                        <div class="col-12 text-center">
                            <p>No courses available for this semester.</p>
                        </div>
                    </div>
                @else
                    <div class="position-relative">
                        <!-- Left Arrow -->
                        <button 
                            class="btn btn-dark position-absolute top-50 start-0 translate-middle-y z-3 px-3"
                            onclick="scrollLeft('college-courses-container')">
                            <i class="bi bi-chevron-left"></i> {{-- Or use &#10094; --}}
                        </button>
            
                        <!-- Scrollable Courses -->
                        <div class="d-flex flex-nowrap overflow-auto px-5" id="college-courses-container" style="margin-left: 20px">
                            @foreach($clgCourses as $course)
                                <div class="col-lg-4 col-md-6 col-12 mb-4 flex-shrink-0">
                                    <div class="custom-block bg-white shadow-lg">
                                        <a href="https://www.coursera.org/learn/{{ $course->slug }}" target="_blank" class="text-decoration-none">
                                            <div class="d-flex">
                                                <div>
                                                    <h5 class="mb-2">{{ $course->name ?? 'Default Name' }}</h5>
                                                </div>
                                                <span class="badge bg-design rounded-pill ms-auto">{{ $loop->index + 1 }}</span>
                                            </div>
                                            <img src="{{ $course->image ?? asset('student/images/topics/default.png') }}" 
                                                 class="custom-block-image img-fluid" 
                                                 alt="{{ $course->name }}">
                                        </a>
                                    </div>
                                </div>
                            @endforeach
                        </div>
            
                        <!-- Right Arrow -->
                        <button 
                            class="btn btn-dark position-absolute top-50 end-0 translate-middle-y z-3 px-3"
                            onclick="scrollRight('college-courses-container')">
                            <i class="bi bi-chevron-right"></i> {{-- Or use &#10095; --}}
                        </button>
                    </div>
                @endif
            </div>
            
            @endif
          <!-- Browse Topics Section -->
          <section class="explore-section section-padding" id="section_2">
            <div class="container">
                <div class="row">
                    <div class="col-12 text-center">
                        <h2 class="mb-4">Browse Courses</h2>
                    </div>
                </div>
            </div>
        
            <div class="container-fluid">
                <div class="row">
                    <div class="col-12">
                        <!-- Make this div scrollable -->
                        <div class="tab-scroll-container">
                            <ul class="nav navs-tabs nav-tabs" id="myTabBrowse" role="tablist">
                                @foreach($courseCategories as $category)
                                    <li class="nav-item" role="presentation">
                                        <button class="navs-link nav-link {{ $loop->first ? 'active' : '' }}" 
                                                id="browse-{{ strtolower($category->name) }}-tab" 
                                                data-bs-toggle="tab" 
                                                data-bs-target="#browse-{{ strtolower($category->name) }}-tab-pane" 
                                                type="button" 
                                                role="tab" 
                                                aria-controls="browse-{{ strtolower($category->name) }}-tab-pane" 
                                                aria-selected="false">
                                            {{ $category->name }}
                                        </button>
                                    </li>
                                @endforeach
                            </ul>
                        </div>
                    </div>
                </div>
            </div>
        
            <div class="container">
                <div class="row">
                    <div class="col-12">
                        <div class="tab-content" id="myTabBrowseContent">
                            @foreach($courseCategories as $category)
                                <div class="tab-pane fade {{ $loop->first ? 'show active' : '' }}" 
                                     id="browse-{{ strtolower($category->name) }}-tab-pane" 
                                     role="tabpanel" 
                                     aria-labelledby="browse-{{ strtolower($category->name) }}-tab">
                                    <div class="position-relative">
                                        <!-- Left Scroll Button -->
                                        <button class="scroll-btn left-btn position-absolute start-0 top-50 translate-middle-y"
                                                onclick="scrollLeft('browse-{{ strtolower($category->name) }}')">
                                            &#10094;
                                        </button>
        
                                        <!-- Scrollable Container -->
                                        <div class="row flex-nowrap overflow-auto custom-scroll-container px-5" id="scroll-container-browse-{{ strtolower($category->name) }}">
                                            @forelse($category->topCourses['elements'] as $course)
                                            <div class="col-lg-4 col-md-6 col-12 mb-4">
                                                <div class="custom-block bg-white shadow-lg">
                                                        <a href="https://www.coursera.org/learn/{{ $course['slug'] }}" target="_blank" class="text-decoration-none">
                                                        <div class="d-flex">
                                                            <div>
                                                                <h5 class="mb-2">{{ $course['name'] ?? 'Default Name' }}</h5>
                                                            </div>
                                                            <span class="badge bg-design rounded-pill ms-auto">{{ $loop->index + 1 }}</span>
                                                        </div>
                                                        <img src="{{ $course['image'] ?? asset('student/images/topics/default.png') }}" 
                                                             class="custom-block-image img-fluid" 
                                                             alt="{{ $course['name'] }}">
                                                            </a>
                                                    </div>
                                                </div>
                                            @empty
                                                <p class="text-center">No courses available for this category.</p>
                                            @endforelse
                                        </div>
        
                                        <!-- Right Scroll Button -->
                                        <button class="scroll-btn right-btn position-absolute end-0 top-50 translate-middle-y"
                                                onclick="scrollRight('browse-{{ strtolower($category->name) }}')">
                                            &#10095;
                                        </button>
                                    </div>
                                </div>
                            @endforeach
                        </div>
                    </div>
                </div>
            </div>
        </section>
        
        <!-- University Recommended Courses Section -->
        <section class="explore-section section-padding" id="section_2">
            <div class="container">
                <div class="row">
                    <div class="col-12 text-center">
                        <h2 class="mb-4">University Recommended Courses</h2>
                    </div>
                </div>
            </div>
        
            <div class="container-fluid">
                <div class="row">
                    <div class="col-12">
                        <!-- Make this div scrollable -->
                        <div class="tab-scroll-container">
                            <ul class="nav nav-tabs" id="myTabUniversity" role="tablist">
                                @foreach($courseCategories as $category)
                                    <li class="nav-item" role="presentation">
                                        <button class="nav-link {{ $loop->first ? 'active' : '' }}" 
                                                id="university-{{ strtolower($category->name) }}-tab" 
                                                data-bs-toggle="tab" 
                                                data-bs-target="#university-{{ strtolower($category->name) }}-tab-pane" 
                                                type="button" 
                                                role="tab" 
                                                aria-controls="university-{{ strtolower($category->name) }}-tab-pane" 
                                                aria-selected="{{ $loop->first ? 'true' : 'false' }}">
                                            {{ $category->name }}
                                        </button>
                                    </li>
                                @endforeach
                            </ul>
                        </div>
                    </div>
                </div>
            </div>
        
            <!-- Tab Content: Courses for Each Category -->
            <div class="container">
                <div class="row">
                    <div class="col-12">
                        <div class="tab-content" id="myTabUniversityContent">
                            @foreach($courseCategories as $category)
                                <div class="tab-pane fade {{ $loop->first ? 'show active' : '' }}" 
                                     id="university-{{ strtolower($category->name) }}-tab-pane" 
                                     role="tabpanel" 
                                     aria-labelledby="university-{{ strtolower($category->name) }}-tab">
        
                                    <div class="position-relative">
                                        <!-- Left Scroll Button -->
                                        <button class="scroll-btn left-btn position-absolute start-0 top-50 translate-middle-y"
                                                onclick="scrollLeft('university-{{ strtolower($category->name) }}')">
                                            &#10094;
                                        </button>
        
                                        <div class="row flex-nowrap overflow-auto custom-scroll-container px-5" 
                                             id="scroll-container-university-{{ strtolower($category->name) }}">
                                            @forelse($category->courses as $course)
                                                <div class="col-lg-4 col-md-6 col-12 mb-4">
                                                    <div class="custom-block bg-white shadow-lg">
                                                        <div class="d-flex">
                                                            <div>
                                                                <h5 class="mb-2">{{ $course->name }}</h5>
                                                            </div>
                                                            <span class="badge bg-design rounded-pill ms-auto">{{ $loop->index + 1 }}</span>
                                                        </div>
                                                        <img src="{{ $course->image ?? asset('student/images/topics/default.png') }}" 
                                                             class="custom-block-image img-fluid" 
                                                             alt="{{ $course->name }}">
                                                    </div>
                                                </div>
                                            @empty
                                                <p class="text-center">No courses available in this category.</p>
                                            @endforelse
                                        </div>
        
                                        <!-- Right Scroll Button -->
                                        <button class="scroll-btn right-btn position-absolute end-0 top-50 translate-middle-y" 
                                                onclick="scrollRight('university-{{ strtolower($category->name) }}')">
                                            &#10095;
                                        </button>
                                    </div>
                                </div>
                            @endforeach
                        </div>
                    </div>
                </div>
            </div>
        </section>

            <section class="timeline-section section-padding" id="section_3">
                <div class="section-overlay"></div>

                <div class="container">
                    <div class="row">

                        <div class="col-12 text-center">
                            <h2 class="text-white mb-4">How to Get Started?</h2>
                        </div>

                        <div class="col-lg-10 col-12 mx-auto">
                            <div class="timeline-container">
                                <ul class="vertical-scrollable-timeline" id="vertical-scrollable-timeline">
                                    <div class="list-progress">
                                        <div class="inner"></div>
                                    </div>

                                    <li>
                                        <h4 class="text-white mb-3">Sign Up for an Account</h4>

                                        <p class="text-white">Create a free account to access a wide range of courses and resources tailored to your interests.</p>

                                        <div class="icon-holder">
                                          <i class="bi-person-plus"></i>
                                        </div>
                                    </li>
                                    
                                    <li>
                                        <h4 class="text-white mb-3">Explore Categories</h4>

                                        <p class="text-white">Browse through various categories to find courses that match your learning goals and preferences.</p>

                                        <div class="icon-holder">
                                          <i class="bi-grid"></i>
                                        </div>
                                    </li>

                                    <li>
                                        <h4 class="text-white mb-3">Enroll and Learn</h4>

                                        <p class="text-white">Enroll in your chosen courses and start learning at your own pace with expert guidance and resources.</p>

                                        <div class="icon-holder">
                                          <i class="bi-play-circle"></i>
                                        </div>
                                    </li>
                                </ul>
                            </div>
                        </div>

                        <div class="col-12 text-center mt-5">
                            <p class="text-white">
                                Ready to begin your journey?
                                <a href="{{ route('student.signup') }}" class="btn custom-btn custom-border-btn ms-3">Sign Up Now</a>
                            </p>
                        </div>
                    </div>
                </div>
            </section>


            <section class="faq-section section-padding" id="section_4">
                <div class="container">
                    <div class="row">

                        <div class="col-lg-6 col-12">
                            <h2 class="mb-4">Frequently Asked Questions</h2>
                        </div>

                        <div class="clearfix"></div>

                        <div class="col-lg-5 col-12">
                            <img src="{{ asset('student/images/faq_graphic.jpg')}}" class="img-fluid" alt="FAQs">
                        </div>

                        <div class="col-lg-6 col-12 m-auto">
                            <div class="accordion" id="accordionExample">
                                <div class="accordion-item">
                                    <h2 class="accordion-header" id="headingOne">
                                        <button class="accordion-button" type="button" data-bs-toggle="collapse" data-bs-target="#collapseOne" aria-expanded="true" aria-controls="collapseOne">
                                        How do I enroll in a course?
                                        </button>
                                    </h2>

                                    <div id="collapseOne" class="accordion-collapse collapse show" aria-labelledby="headingOne" data-bs-parent="#accordionExample">
                                        <div class="accordion-body">
                                            To enroll in a course, simply search for the course you are interested in, click on it, and follow the enrollment instructions provided on the course page.
                                        </div>
                                    </div>
                                </div>

                                <div class="accordion-item">
                                    <h2 class="accordion-header" id="headingTwo">
                                        <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#collapseTwo" aria-expanded="false" aria-controls="collapseTwo">
                                        Do I get a certificate after completing a course?
                                    </button>
                                    </h2>

                                    <div id="collapseTwo" class="accordion-collapse collapse" aria-labelledby="headingTwo" data-bs-parent="#accordionExample">
                                        <div class="accordion-body">
                                            Yes, certificates are available upon course completion. Please note that all certificates are issued by Coursera and may require a fee. Check the course details on Coursera for specific pricing information.
                                        </div>
                                    </div>
                                </div>

                                <div class="accordion-item">
                                    <h2 class="accordion-header" id="headingThree">
                                        <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#collapseThree" aria-expanded="false" aria-controls="collapseThree">
                                        Can I access courses on mobile devices?
                                    </button>
                                    </h2>

                                    <div id="collapseThree" class="accordion-collapse collapse" aria-labelledby="headingThree" data-bs-parent="#accordionExample">
                                        <div class="accordion-body">
                                            Yes, our platform is mobile-friendly, and you can access courses on any device with an internet connection, including smartphones and tablets.
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                    </div>
                </div>
            </section>


            <section class="contact-section section-padding section-bg" id="section_5">
                <div class="container">
                    <div class="row">

                        <div class="col-lg-12 col-12 text-center">
                            <h2 class="mb-5">Get in touch</h2>
                        </div>

                        <div class="col-lg-5 col-12 mb-4 mb-lg-0">
                            <iframe src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d24321.373667048047!2d72.50485809824511!3d22.99643994747892!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x395e9aee6c89a621%3A0x872df2d55fbb0008!2sLJ%20University!5e0!3m2!1sen!2sin!4v1744536431346!5m2!1sen!2sin" width="140%" height="350" style="border:0;" allowfullscreen="" loading="lazy" referrerpolicy="no-referrer-when-downgrade"></iframe>
                        </div>

                        <div class="col-lg-3 col-md-6 col-12 mb-3 mb-lg- mb-md-0 ms-auto">
                            <h4 class="mb-3">Address</h4>

                            <p>LOK JAGRUTI UNIVERSITY</p>
                            <p>
                                LJ Campus, off Sarkhej - Gandhinagar Highway, Makarba, Ahmedabad,Sarkhej-Okaf, Gujarat 382210
                            </p>
                            
                            <hr>

                            <p class="d-flex align-items-center mb-1">
                                <span class="me-2">Phone</span>

                                <a href="tel: 9099063417" class="site-footer-link">
                                    9099063417
                                </a>
                            </p>

                            <p class="d-flex align-items-center">
                                <span class="me-2">Email</span>

                                <a href="mailto:info_ica@ljku.edu.in" class="site-footer-link">
                                    info_ica@ljku.edu.in
                                </a>
                            </p>
                        </div>
                    </div>
                </div>
            </section>
        </main>

@include('user.components.footer')
        <script>
            function scrollLeft(category) {
    let container = document.getElementById(`scroll-container-${category}`);
    if (container) {
        container.scrollLeft -= 300; // Moves left by 300px
    }
}

function scrollRight(category) {
    let container = document.getElementById(`scroll-container-${category}`);
    if (container) {
        container.scrollLeft += 300; // Moves right by 300px
    }
}

        </script>
        <script>
            // Scroll left by 300 pixels
            function scrollLeft(containerId) {
                const container = document.getElementById(containerId);
                container.scrollBy({
                    left: -300,
                    behavior: 'smooth'
                });
            }
        
            // Scroll right by 300 pixels
            function scrollRight(containerId) {
                const container = document.getElementById(containerId);
                container.scrollBy({
                    left: 300,
                    behavior: 'smooth'
                });
            }
        </script>
        
    </body>
</html>

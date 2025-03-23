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

                            <form method="get" class="custom-form mt-4 pt-2 mb-lg-0 mb-5" role="search">
                                <div class="input-group input-group-lg">
                                    <span class="input-group-text bi-search" id="basic-addon1">
                                        
                                    </span>

                                    <input name="keyword" type="search" class="form-control" id="keyword" placeholder="Design, Code, Marketing, Finance ..." aria-label="Search">

                                    <button type="submit" class="form-control">Search</button>
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
                                <a href="topics-detail.html">
                                    <div class="d-flex">
                                        <div>
                                            <h5 class="mb-2">Web Design</h5>

                                            <p class="mb-0">When you search for free CSS templates, you will notice that TemplateMo is one of the best websites.</p>
                                        </div>

                                        <span class="badge bg-design rounded-pill ms-auto">14</span>
                                    </div>

                                    <img src="{{ asset('student/images/topics/undraw_Remote_design_team_re_urdx.png')}}" class="custom-block-image img-fluid" alt="">
                                </a>
                            </div>
                        </div>

                        <div class="col-lg-6 col-12">
                            <div class="custom-block custom-block-overlay">
                                <div class="d-flex flex-column h-100">
                                    <img src="{{ asset('student/images/businesswoman-using-tablet-analysis.jpg')}}" class="custom-block-image img-fluid" alt="">

                                    <div class="custom-block-overlay-text d-flex">
                                        <div>
                                            <h5 class="text-white mb-2">Finance</h5>

                                            <p class="text-white">Topic Listing Template includes homepage, listing page, detail page, and contact page. You can feel free to edit and adapt for your CMS requirements.</p>

                                            <a href="topics-detail.html" class="btn custom-btn mt-2 mt-lg-3">Learn More</a>
                                        </div>

                                        <span class="badge bg-finance rounded-pill ms-auto">25</span>
                                    </div>

                                    <div class="social-share d-flex">
                                        <p class="text-white me-4">Share:</p>

                                        <ul class="social-icon">
                                            <li class="social-icon-item">
                                                <a href="#" class="social-icon-link bi-twitter"></a>
                                            </li>

                                            <li class="social-icon-item">
                                                <a href="#" class="social-icon-link bi-facebook"></a>
                                            </li>

                                            <li class="social-icon-item">
                                                <a href="#" class="social-icon-link bi-pinterest"></a>
                                            </li>
                                        </ul>

                                        <a href="#" class="custom-icon bi-bookmark ms-auto"></a>
                                    </div>

                                    <div class="section-overlay"></div>
                                </div>
                            </div>
                        </div>

                    </div>
                </div>
            </section>


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
                                                        <div class="d-flex">
                                                            <div>
                                                                <h5 class="mb-2">{{ $course['name'] ?? 'Default Name' }}</h5>
                                                            </div>
                                                            <span class="badge bg-design rounded-pill ms-auto">{{ $loop->index + 1 }}</span>
                                                        </div>
                                                        <img src="{{ $course['image'] ?? asset('student/images/topics/default.png') }}" 
                                                             class="custom-block-image img-fluid" 
                                                             alt="{{ $course['name'] }}">
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
                            <h2 class="text-white mb-4">How does it work?</h1>
                        </div>

                        <div class="col-lg-10 col-12 mx-auto">
                            <div class="timeline-container">
                                <ul class="vertical-scrollable-timeline" id="vertical-scrollable-timeline">
                                    <div class="list-progress">
                                        <div class="inner"></div>
                                    </div>

                                    <li>
                                        <h4 class="text-white mb-3">Search your favourite topic</h4>

                                        <p class="text-white">Lorem ipsum dolor sit amet consectetur adipisicing elit. Reiciendis, cumque magnam? Sequi, cupiditate quibusdam alias illum sed esse ad dignissimos libero sunt, quisquam numquam aliquam? Voluptas, accusamus omnis?</p>

                                        <div class="icon-holder">
                                          <i class="bi-search"></i>
                                        </div>
                                    </li>
                                    
                                    <li>
                                        <h4 class="text-white mb-3">Bookmark &amp; Keep it for yourself</h4>

                                        <p class="text-white">Lorem ipsum dolor, sit amet consectetur adipisicing elit. Sint animi necessitatibus aperiam repudiandae nam omnis est vel quo, nihil repellat quia velit error modi earum similique odit labore. Doloremque, repudiandae?</p>

                                        <div class="icon-holder">
                                          <i class="bi-bookmark"></i>
                                        </div>
                                    </li>

                                    <li>
                                        <h4 class="text-white mb-3">Read &amp; Enjoy</h4>

                                        <p class="text-white">Lorem, ipsum dolor sit amet consectetur adipisicing elit. Animi vero quisquam, rem assumenda similique voluptas distinctio, iste est hic eveniet debitis ut ducimus beatae id? Quam culpa deleniti officiis autem?</p>

                                        <div class="icon-holder">
                                          <i class="bi-book"></i>
                                        </div>
                                    </li>
                                </ul>
                            </div>
                        </div>

                        <div class="col-12 text-center mt-5">
                            <p class="text-white">
                                Want to learn more?
                                <a href="#" class="btn custom-btn custom-border-btn ms-3">Check out Youtube</a>
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
                                        What is Topic Listing?
                                        </button>
                                    </h2>

                                    <div id="collapseOne" class="accordion-collapse collapse show" aria-labelledby="headingOne" data-bs-parent="#accordionExample">
                                        <div class="accordion-body">
                                            Topic Listing is free Bootstrap 5 CSS template. <strong>You are not allowed to redistribute this template</strong> on any other template collection website without our permission. Please contact TemplateMo for more detail. Thank you.
                                        </div>
                                    </div>
                                </div>

                                <div class="accordion-item">
                                    <h2 class="accordion-header" id="headingTwo">
                                        <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#collapseTwo" aria-expanded="false" aria-controls="collapseTwo">
                                        How to find a topic?
                                    </button>
                                    </h2>

                                    <div id="collapseTwo" class="accordion-collapse collapse" aria-labelledby="headingTwo" data-bs-parent="#accordionExample">
                                        <div class="accordion-body">
                                            You can search on Google with <strong>keywords</strong> such as templatemo portfolio, templatemo one-page layouts, photography, digital marketing, etc.
                                        </div>
                                    </div>
                                </div>

                                <div class="accordion-item">
                                    <h2 class="accordion-header" id="headingThree">
                                        <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#collapseThree" aria-expanded="false" aria-controls="collapseThree">
                                        Does it need to paid?
                                    </button>
                                    </h2>

                                    <div id="collapseThree" class="accordion-collapse collapse" aria-labelledby="headingThree" data-bs-parent="#accordionExample">
                                        <div class="accordion-body">
                                            You can modify any of this with custom CSS or overriding our default variables. It's also worth noting that just about any HTML can go within the <code>.accordion-body</code>, though the transition does limit overflow.
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
                            <iframe class="google-map" src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d2595.065641062665!2d-122.4230416990949!3d37.80335401520422!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x80858127459fabad%3A0x808ba520e5e9edb7!2sFrancisco%20Park!5e1!3m2!1sen!2sth!4v1684340239744!5m2!1sen!2sth" width="100%" height="250" style="border:0;" allowfullscreen="" loading="lazy" referrerpolicy="no-referrer-when-downgrade"></iframe>
                        </div>

                        <div class="col-lg-3 col-md-6 col-12 mb-3 mb-lg- mb-md-0 ms-auto">
                            <h4 class="mb-3">Head office</h4>

                            <p>Bay St &amp;, Larkin St, San Francisco, CA 94109, United States</p>

                            <hr>

                            <p class="d-flex align-items-center mb-1">
                                <span class="me-2">Phone</span>

                                <a href="tel: 305-240-9671" class="site-footer-link">
                                    305-240-9671
                                </a>
                            </p>

                            <p class="d-flex align-items-center">
                                <span class="me-2">Email</span>

                                <a href="mailto:info@company.com" class="site-footer-link">
                                    info@company.com
                                </a>
                            </p>
                        </div>

                        <div class="col-lg-3 col-md-6 col-12 mx-auto">
                            <h4 class="mb-3">Dubai office</h4>

                            <p>Burj Park, Downtown Dubai, United Arab Emirates</p>

                            <hr>

                            <p class="d-flex align-items-center mb-1">
                                <span class="me-2">Phone</span>

                                <a href="tel: 110-220-3400" class="site-footer-link">
                                    110-220-3400
                                </a>
                            </p>

                            <p class="d-flex align-items-center">
                                <span class="me-2">Email</span>

                                <a href="mailto:info@company.com" class="site-footer-link">
                                    info@company.com
                                </a>
                            </p>
                        </div>

                    </div>
                </div>
            </section>
        </main>

<footer class="site-footer section-padding">
            <div class="container">
                <div class="row">

                    <div class="col-lg-3 col-12 mb-4 pb-2">
                        <a class="navbar-brand mb-2" href="index.html">
                            <i class="bi-back"></i>
                            <span>Topic</span>
                        </a>
                    </div>

                    <div class="col-lg-3 col-md-4 col-6">
                        <h6 class="site-footer-title mb-3">Resources</h6>

                        <ul class="site-footer-links">
                            <li class="site-footer-link-item">
                                <a href="#" class="site-footer-link">Home</a>
                            </li>

                            <li class="site-footer-link-item">
                                <a href="#" class="site-footer-link">How it works</a>
                            </li>

                            <li class="site-footer-link-item">
                                <a href="#" class="site-footer-link">FAQs</a>
                            </li>

                            <li class="site-footer-link-item">
                                <a href="#" class="site-footer-link">Contact</a>
                            </li>
                        </ul>
                    </div>

                    <div class="col-lg-3 col-md-4 col-6 mb-4 mb-lg-0">
                        <h6 class="site-footer-title mb-3">Information</h6>

                        <p class="text-white d-flex mb-1">
                            <a href="tel: 305-240-9671" class="site-footer-link">
                                305-240-9671
                            </a>
                        </p>

                        <p class="text-white d-flex">
                            <a href="mailto:info@company.com" class="site-footer-link">
                                info@company.com
                            </a>
                        </p>
                    </div>

                    <div class="col-lg-3 col-md-4 col-12 mt-4 mt-lg-0 ms-auto">
                        <div class="dropdown">
                            <button class="btn btn-secondary dropdown-toggle" type="button" data-bs-toggle="dropdown" aria-expanded="false">
                            English</button>

                            <ul class="dropdown-menu">
                                <li><button class="dropdown-item" type="button">Thai</button></li>

                                <li><button class="dropdown-item" type="button">Myanmar</button></li>

                                <li><button class="dropdown-item" type="button">Arabic</button></li>
                            </ul>
                        </div>

                        <p class="copyright-text mt-lg-5 mt-4">Copyright © 2048 Topic Listing Center. All rights reserved.
                        <br><br>Design: <a rel="nofollow" href="https://templatemo.com" target="_blank">TemplateMo</a></p>
                        
                    </div>

                </div>
            </div>
        </footer>


        <!-- JAVASCRIPT FILES -->
        <script src="{{ asset('student/js/jquery.min.js')}}"></script>
        <script src="{{ asset('student/js/bootstrap.bundle.min.js')}}"></script>
        <script src="{{ asset('student/js/jquery.sticky.js')}}"></script>
        <script src="{{ asset('student/js/click-scroll.js')}}"></script>
        <script src="{{ asset('student/js/custom.js')}}"></script>

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
    </body>
</html>

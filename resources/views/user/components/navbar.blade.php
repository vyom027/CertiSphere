@php
    use Illuminate\Support\Str;
@endphp

<nav class="navbar navbar-expand-lg" style="background-color: rgb(128, 208, 199);">
    <div class="container">
        <a class="navbar-brand" href="{{route('student.index')}}">
            <i class="bi-back"></i>
            <span>Certisphere</span>
        </a>
        
            <div class="d-lg-none ms-auto me-4">
                <a href="#top" class="navbar-icon bi-person smoothscroll"></a>
            </div>
        
        <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
        </button>

        <div class="collapse navbar-collapse" id="navbarNav">
            <ul class="navbar-nav ms-lg-5 me-lg-auto">
                <li class="nav-item">
                    <a class="nav-link click-scroll" href="{{route('student.index')}}">Home</a>
                </li>

                <li class="nav-item">
                    <a class="nav-link click-scroll" href="{{route('student.index')}}#section_2">Browse Courses</a>
                </li>

                <li class="nav-item">
                    <a class="nav-link" href="{{ route('certificate-requests.index') }}">Certificate</a>
                </li>

                <li class="nav-item">
                    <a class="nav-link click-scroll" href="#section_5">Notifications</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link click-scroll" href="#section_5">Help</a>
                </li>


                <li class="nav-item dropdown">
                    <a class="nav-link dropdown-toggle" href="#" id="navbarLightDropdownMenuLink" role="button" data-bs-toggle="dropdown" aria-expanded="false">Pages</a>

                    <ul class="dropdown-menu dropdown-menu-light" aria-labelledby="navbarLightDropdownMenuLink">
                        <li><a class="dropdown-item" href="topics-listing.html">Topics Listing</a></li>

                        <li><a class="dropdown-item" href="contact.html">Contact Form</a></li>
                    </ul>
                </li>
            </ul>

            @if(Session::get('student_logged_in'))
                @if (session('student_profile') && session('student_profile') != 'profile_pictures/default.png')
                    <a href="{{ route('student.profile')}}"><img src="{{ asset(session('student_profile')) }}" alt="User Profile Picture" class="rounded-circle " width="40" height="40"></a>
                @else
                    <div class="d-none d-lg-block">
                        <a href="{{ route('student.profile')}}" class="navbar-icon bi-person smoothscroll"></a>
                    </div>
                @endif
                <form action="{{ route('Studentlogout') }}" style="display: inline;">
                    @csrf
                    <button type="submit" class="btn btn-link p-0">
                        <i class="bi bi-box-arrow-right" style="font-size: 1.5rem;margin-left:10px; color: #000;"></i>
                    </button>
                </form>
            @else
                <div class="d-flex">
                    <a href="{{ route('login-student') }}" class="btn btn-outline-none me-2" style="color: white">Login</a>
                    <a href="{{ route('student.signup') }}" class="btn btn-outline-none me-2" style="color: white">Sign Up</a>
                </div>
            @endif

            
        </div>
    </div>
</nav>
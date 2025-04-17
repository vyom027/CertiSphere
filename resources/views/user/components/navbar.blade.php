@php
    use Illuminate\Support\Str;
@endphp

<nav class="navbar navbar-expand-lg" style="background-color: rgb(128, 208, 199);">
    <div class="container">
        <a class="navbar-brand" href="{{route('student.index')}}">
            <i class="bi-back"></i>
            <span>CertiSphere</span>
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
                    <a class="nav-link" href="#" data-bs-toggle="modal" data-bs-target="#mailLoginModal">Mails</a>
                </li>
                
                <li class="nav-item">
                    <a class="nav-link click-scroll" href="#section_5">Help</a>
                </li>


                {{-- <li class="nav-item dropdown">
                    <a class="nav-link dropdown-toggle" href="#" id="navbarLightDropdownMenuLink" role="button" data-bs-toggle="dropdown" aria-expanded="false">Pages</a>

                    <ul class="dropdown-menu dropdown-menu-light" aria-labelledby="navbarLightDropdownMenuLink">
                        <li><a class="dropdown-item" href="topics-listing.html">Topics Listing</a></li>

                        <li><a class="dropdown-item" href="contact.html">Contact Form</a></li>
                    </ul>
                </li> --}}
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

<!-- Mail Password Modal -->
<!-- Link to trigger modal (always visible) -->

<!-- Modal to enter password -->
<div class="modal fade" id="mailLoginModal" tabindex="-1" aria-labelledby="mailLoginModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <form action="{{ route('mailbox.connect') }}" method="POST">
            @csrf
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="mailLoginModalLabel">Enter Mailbox Password</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <input type="password" name="password" class="form-control" 
                        placeholder="Enter your email password" 
                        value="{{ session('mail_password') ? session('mail_password') : '' }}" required>
                </div>
                <div class="modal-footer">
                    <button type="submit" class="btn btn-primary">Connect</button>
                </div>
            </div>
        </form>
    </div>
</div>

<script>
    document.addEventListener('DOMContentLoaded', function () {
        // Check if password is already stored in session
        const mailPassword = "{{ session('mail_password') }}";

        // Event listener for "Mails" link
        const mailLink = document.getElementById('mailLink');

        if (mailPassword) {
            // If password is in session, redirect to mailbox directly
            mailLink.addEventListener('click', function (event) {
                event.preventDefault();
                window.location.href = "{{ route('mailbox.connect') }}"; // Redirect to the mailbox
            });
        } else {
            // If no password, show the modal on click
            mailLink.addEventListener('click', function (event) {
                event.preventDefault();
                $('#mailLoginModal').modal('show'); // Show the password modal
            });
        }
    });
</script>

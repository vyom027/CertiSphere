<!DOCTYPE html>
   <html lang="en">
   <head>
      <meta charset="UTF-8">
      <meta name="viewport" content="width=device-width, initial-scale=1.0">

      <!--=============== REMIXICONS ===============-->
      <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/remixicon/4.2.0/remixicon.css">
      <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

      <!--=============== CSS ===============-->
      <link rel="stylesheet" href="{{asset('student/css/sign-up.css')}}">
      
          <!-- CSS FILES -->        
          <link rel="preconnect" href="https://fonts.googleapis.com">
        
          <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
  
          <link href="https://fonts.googleapis.com/css2?family=Montserrat:wght@500;600;700&family=Open+Sans&display=swap" rel="stylesheet">
                          
          <link href="{{ asset('student/css/bootstrap.min.css')}}" rel="stylesheet">
  
          <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
  
          <link href="{{ asset('student/css/bootstrap-icons.css')}}" rel="stylesheet">
          <link href="{{ asset('student/css/templatemo-topic-listing.css')}}" rel="stylesheet">      
  
      <title>Log in | LJKU</title>
   </head>
   <body>
      @if (session('email_error'))
      <script>
          document.addEventListener("DOMContentLoaded", function() {
            console.log("Email error script is running!");
              Swal.fire({
                  icon: 'error',
                  title: 'Invalid Email',
                  text: "{{ session('email_error') }}",
              });
          });
      </script>
      @endif
      
  
  <!-- Show Password Error -->
  @if (session('password_error'))
<script>
    document.addEventListener("DOMContentLoaded", function() {
      console.log("Pass error script is running!");  
      Swal.fire({
            icon: 'error',
            title: 'Incorrect Password',
            text: "{{ session('password_error') }}",
        });
    });
</script>
@endif

@include('user.components.navbar')

      <!--=============== LOGIN IMAGE ===============-->
      <svg class="login__blob" viewBox="0 0 566 840" xmlns="http://www.w3.org/2000/svg">
         <mask id="mask0" mask-type="alpha">
            <path d="M342.407 73.6315C388.53 56.4007 394.378 17.3643 391.538 
            0H566V840H0C14.5385 834.991 100.266 804.436 77.2046 707.263C49.6393 
            591.11 115.306 518.927 176.468 488.873C363.385 397.026 156.98 302.824 
            167.945 179.32C173.46 117.209 284.755 95.1699 342.407 73.6315Z"/>
         </mask>
      
         <g mask="url(#mask0)">
            <path d="M342.407 73.6315C388.53 56.4007 394.378 17.3643 391.538 
            0H566V840H0C14.5385 834.991 100.266 804.436 77.2046 707.263C49.6393 
            591.11 115.306 518.927 176.468 488.873C363.385 397.026 156.98 302.824 
            167.945 179.32C173.46 117.209 284.755 95.1699 342.407 73.6315Z" fill="#80d0c7"/>
      
            <!-- Insert your image (recommended size: 1000 x 1200) -->
            <image class="login__img" href="assets/img/bg-img.jpg"/>
         </g>
      </svg>      

      <!--=============== LOGIN ===============-->
      <div class="login container grid" id="loginAccessRegister">
         <!--===== LOGIN ACCESS =====-->
         <div class="login__access">
            <h1 class="login__title">Log in to your account.</h1>
            
            <div class="login__area">
               <form action="{{ route('login-student') }}" method="POST" class="login__form">
                  @csrf
                  <div class="login__content grid">
                     <div class="login__box">
                        <input type="email" id="email" required placeholder=" " name="email" class="login__input">
                        <label for="email" class="login__label">Email</label>
            
                        <i class="ri-mail-fill login__icon"></i>
                     </div>
                     @error('email')
                        <div class="text-danger">{{ $message }}</div>
                     @enderror

                     <div class="login__box">
                        <input type="password" id="password" required placeholder=" " name="password" class="login__input">
                        <label for="password" class="login__label">Password</label>
            
                        <i class="ri-eye-off-fill login__icon login__password" id="loginPassword"></i>
                     </div>
                     
                     @error('password')
                        <div class="text-danger">{{ $message }}</div>
                     @enderror

                  </div>
         
                    <div class="d-flex justify-content-between align-items-center mb-3">
                      <div class="form-check" style="margin-top: 20px;margin-left:10px">
                        <input class="form-check-input" type="checkbox" id="rememberMe" name="remember" checked>
                        <label class="form-check-label" for="rememberMe">
                           Remember Me
                        </label>
                      </div>
                      <a href="{{ route('password.request') }}" class="login__forgot">Forgot your password?</a>
                    </div>

         
                  <button type="submit" class="login__button">Login</button>
               </form>
      
               
               <a href="{{route('student.signup')}}">
                  <p class="login__switch">
                     Don't have an account? 
                     <button id="loginButtonRegister">Create Account</button>
                  </p>
               </a>
            </div>
         </div>
      </div>
      
      <!--=============== MAIN JS ===============-->
      <script src="{{asset('student/js/sign-up.js')}}"></script>

   </body>
</html>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href='https://unpkg.com/boxicons@2.1.4/css/boxicons.min.css' rel='stylesheet'>
    <link rel="stylesheet" href="{{asset('admin/css/login.css')}}">
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

    <title>Login | Admin</title>
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

    <div class="wrapper">
        <div class="form-header">
            <div class="titles">
                <div class="title-login">Login</div>
            </div>
        </div>
        <form action="{{ route('login') }}" class="login-form" method="POST">
            @csrf
            <div class="input-box">
                <input type="text" class="input-field" name="email" id="log-email" required>
                <label for="log-email" class="label">Email</label>
                <i class='bx bx-envelope icon'></i>
            </div>
            <div class="input-box">
                <input type="password" class="input-field" name="password" id="log-pass" required>
                <label for="log-pass" class="label">Password</label>
                <i class='bx bx-lock-alt icon'></i>
            </div>
            <div class="form-cols">
                <div class="col-1"></div>
                <div class="col-2">
                    <a href="#">Forgot password?</a>
                </div>
            </div>
            <div class="input-box">
                <button class="btn-submit" id="SignInBtn">Log In <i class='bx bx-log-in'></i></button>
            </div>
        </form>        
    </div>

    <script>
        const loginForm = document.querySelector(".login-form");
        const wrapper = document.querySelector(".wrapper");
        const loginTitle = document.querySelector(".title-login");
        const signInBtn = document.querySelector("#SignInBtn");

        function loginFunction(){
            loginForm.style.left = "50%";
            loginForm.style.opacity = 1;
            wrapper.style.height = "500px";
            loginTitle.style.top = "50%";
            loginTitle.style.opacity = 1;
        }
    </script>

</body>
</html>
<!DOCTYPE html>
<html lang="en">
<head>
    <title>Password Reset</title>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <style>
        /* General styles */
        * {
            box-sizing: border-box;
            margin: 0;
            padding: 0;
        }

        body {
			background: linear-gradient(-45deg, #1e3c72, #2a5298, #56ccf2, #2f80ed);
			background-size: 400% 400%;
            animation: gradientAnimation 8s ease infinite;
            font-family: 'Arial', sans-serif;
            color: #333;
        }

        h1 {
            font-size: 26px;
            font-weight: 600;
            color: #333;
            margin-bottom: 10px;
            text-align: center;
        }

        p {
            line-height: 1.6;
            color: #555;
            text-align: center;
            margin-top: 10px;
            font-size: 16px;
        }

        a {
            color: #3498db;
            text-decoration: none;
        }

        /* Gradient animation */
        @keyframes gradientAnimation {
            0% { background-position: 0% 50%; }
            50% { background-position: 100% 50%; }
            100% { background-position: 0% 50%; }
        }

        /* Container */
        .container {
            display: flex;
            justify-content: center;
            align-items: center;
            height: 100vh;
            padding: 20px;
        }

        /* Card Design */
        .card {
            background: rgba(255, 255, 255, 0.9);
            border-radius: 12px;
            box-shadow: 0 10px 30px rgba(0, 0, 0, 0.1);
            display: flex;
            flex-wrap: wrap;
            max-width: 900px;
            width: 100%;
            padding: 40px;
            justify-content: space-between;
            align-items: center;
        }

        .logo {
            flex: 1;
            max-width: 350px;
            margin-right: 30px;
        }

        .logo img {
            width: 100%;
            height: auto;
            border-radius: 8px;
        }

        .form-container {
            flex: 1;
            min-width: 300px;
        }

        /* Input fields */
        .input-field {
            width: 100%;
            padding: 12px;
            margin: 15px 0;
            border: 2px solid #ddd;
            border-radius: 8px;
            font-size: 16px;
            transition: border-color 0.3s ease-in-out;
        }

        .input-field:focus {
            border-color: #3498db;
            outline: none;
        }

        /* Button */
        .submit-btn {
            width: 100%;
            padding: 15px;
            background-color: #3498db;
            color: white;
            border: none;
            border-radius: 8px;
            font-size: 18px;
            cursor: pointer;
            transition: background-color 0.3s ease;
        }

        .submit-btn:hover {
            background-color: #2980b9;
        }

        /* Cool Session Message Styling */
        .success-message {
            display: none; /* Initially hidden */
            color: white;
            background-color: #27ae60;
            padding: 10px;
            border-radius: 8px;
            margin-bottom: 20px;
            font-size: 16px;
            text-align: center;
            animation: slideIn 1s ease-out forwards, bounceIn 1s ease-out forwards;
            box-shadow: 0px 4px 10px rgba(0, 0, 0, 0.2);
        }

        /* Slide-in animation for session message */
        @keyframes slideIn {
            from {
                transform: translateY(-20px);
                opacity: 0;
            }
            to {
                transform: translateY(0);
                opacity: 1;
            }
        }

        /* Bounce effect */
        @keyframes bounceIn {
            0% {
                transform: scale(0.5);
            }
            50% {
                transform: scale(1.1);
            }
            100% {
                transform: scale(1);
            }
        }

        /* Responsive Design */
        @media (max-width: 700px) {
            .card {
                flex-direction: column;
                align-items: center;
                padding: 20px;
            }

            .logo img {
                width: 80%;
            }

            h1 {
                font-size: 22px;
            }

            .input-field {
                padding: 12px;
            }

            .submit-btn {
                font-size: 16px;
                padding: 12px;
            }
        }
    </style>
</head>
<body>
    @if (session('message'))
		<div class="success-message">{{ session('message') }}</div>
	@endif
    <div class="container">
        <div class="card">
            <div class="logo">
                <img src="https://d1oco4z2z1fhwp.cloudfront.net/templates/default/7631/password_reset.png" alt="Password Reset" title="Password Reset">
            </div>

            <div class="form-container">
                <!-- Session Message -->
                @if (session('message'))
                    <div class="success-message">{{ session('message') }}</div>
                @endif

                <h1><strong>Forgot Your Password?</strong></h1>
                <p>If you have forgotten your password, you can reset it by entering your email below. We'll send you instructions on how to reset your password.</p>

                <form method="POST" action="{{ route('password.email') }}">
                    @csrf
                    <input type="email" class="input-field" name="email" placeholder="Enter your email" required>

                    <button type="submit" class="submit-btn">Send Password Reset Link</button>
                </form>
            </div>
        </div>
    </div>

</body>
</html>
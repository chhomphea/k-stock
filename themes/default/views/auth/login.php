<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>POS System Login</title>
    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
            font-family: -apple-system, BlinkMacSystemFont, 'Segoe UI', Roboto, sans-serif;
        }

        body {
            display: flex;
            justify-content: center;
            align-items: center;
            min-height: 100vh; /* Ensure full viewport height */
            padding: 1rem; /* Add padding for small screens */
        }

        .login-container {
            background: white;
            padding: 3rem 1.5rem;
            border-radius: 8px;
            box-shadow: 0 2px 8px rgba(0, 0, 0, 0.1);
            width: 100%;
            max-width: 360px;
            min-width: 280px; /* Minimum width for small screens */
            display: flex;
            flex-direction: column;
            justify-content: center; /* Vertically center form items */
            min-height: 300px; /* Ensure enough height for centering */
        }

        .login-container h2 {
            text-align: center;
            margin-bottom: 1.5rem;
            color: #333;
            font-size: 1.5rem;
        }

        .form-group {
            margin-bottom: 1rem;
        }

        .form-group label {
            display: block;
            margin-bottom: 0.4rem;
            color: #555;
            font-size: 0.9rem;
            text-align: left; /* Align labels to the left */
        }

        .form-group input {
            width: 100%;
            padding: 0.7rem 2.5rem 0.7rem 0.7rem; /* Extra padding-right for icon */
            border: 1px solid #ddd;
            border-radius: 6px;
            font-size: 0.9rem; /* Small font size for textboxes */
            text-align: left; /* Left-align text for usability */
            height: 2.4rem; /* Fixed height for consistent icon positioning */
            position: relative; /* Make input the positioning context for the icon */
        }

        .form-group input:focus {
            outline: none;
            border-color: #007bff;
        }

        .password-container {
            position: relative;
        }

        .toggle-password {
            position: absolute;
            right: 2px; /* From your provided CSS */
            top: 56%; /* Center smaller icon’s midpoint with input’s midpoint */
            cursor: pointer;
            color: #007bff;
            font-size: 1rem; /* Smaller icon size */
            line-height: 1;
            opacity: 0.7;
            pointer-events: auto;
            z-index: 1;
        }

        .btn {
            width: 100%;
            padding: 0.7rem;
            background: #007bff;
            border: none;
            border-radius: 6px;
            color: white;
            font-size: 1rem;
            cursor: pointer;
            transition: background 0.2s ease;
        }

        .btn:hover {
            background: #0056b3;
        }

        .error {
            color: #ff4d4f;
            font-size: 0.85rem;
            text-align: center;
            margin-top: 0.8rem;
            display: none;
        }
        @media screen and (max-width: 480px) {
            .login-container {
                padding: 2rem 1rem;
                max-width: 90%;
                min-height: 260px;
            }
            .login-container h2 {
                font-size: 1.3rem;
                margin-bottom: 1rem;
            }
            .form-group label {
                font-size: 0.85rem;
            }
            .form-group input {
                padding: 0.6rem 2rem 0.6rem 0.6rem; /* Smaller padding */
                font-size: 0.85rem; /* Smaller font size */
                height: 2.2rem; /* Smaller height */
            }
            .toggle-password {
                font-size: 0.9rem;
                right: 4px;
                top: 56%;
            }
            .btn {
                padding: 0.6rem;
                font-size: 0.9rem;
            }

            .error {
                font-size: 0.8rem;
            }
        }
    </style>
</head>
<body>
    <div class="login-container">
        <?= form_open("auth/login"); ?>
            <h2>POS Login</h2>
            <div class="form-group">
                <label for="username">Username</label>
                <input type="text" id="username" placeholder="Enter username" name="identity" required>
            </div>
            <div class="form-group password-container">
                <label for="password">Password</label>
                <input type="password" id="password" name="password" placeholder="Enter password" required>
                <span class="toggle-password" onclick="togglePassword()">👁️‍🗨️</span>
            </div>
            <button class="btn" onclick="handleLogin()">Sign In</button>
            <p class="error" id="error-message">Invalid username or password</p>
        <?= form_close(); ?>
    </div>
    <script>
        function togglePassword() {
            const passwordInput = document.getElementById('password');
            if (passwordInput.type === 'password') {
                passwordInput.type = 'text';
            } else {
                passwordInput.type = 'password';
            }
        }
        function handleLogin() {
            const username = document.getElementById('username').value;
            const password = document.getElementById('password').value;
            const errorMessage = document.getElementById('error-message');
            if (username === '' || password === '') {
                errorMessage.style.display = 'block'
            } else {
                errorMessage.style.display = 'none';
                console.log('Login attempted with:', { username, password });
            }
        }
    </script>
</body>
</html>
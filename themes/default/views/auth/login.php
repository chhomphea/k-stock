<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>POS System Login</title>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700&display=swap" rel="stylesheet">

    <style>
        :root {
            --primary-color: #1e40af; /* Deep Professional Blue */
            --primary-hover: #1e3a8a;
            --text-main: #1e293b;
            --text-muted: #64748b;
            --border-color: #e2e8f0;
            --radius: 6px;
        }

        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
            font-family: 'Inter', sans-serif;
        }

        body {
            height: 100vh;
            width: 100vw;
            overflow: hidden; /* Prevent scrolling on desktop */
            display: flex;
            background: #fff;
        }

        /* --- LEFT SIDE: IMAGE (Desktop Only) --- */
        .image-section {
            flex: 1.2;
            background-image: 
                linear-gradient(to right, rgba(15, 23, 42, 0.4), rgba(15, 23, 42, 0.8)),
                url('https://images.unsplash.com/photo-1586528116311-ad8dd3c8310d?q=80&w=2070&auto=format&fit=crop');
            background-size: cover;
            background-position: center;
            display: flex;
            flex-direction: column;
            justify-content: flex-end;
            padding: 3rem;
            color: white;
        }
        
        .image-text h1 {
            font-size: 2.5rem;
            font-weight: 700;
            margin-bottom: 0.5rem;
            text-shadow: 0 2px 4px rgba(0,0,0,0.3);
        }
        
        .image-text p {
            font-size: 1rem;
            opacity: 0.9;
            max-width: 500px;
        }

        /* --- RIGHT SIDE: FORM --- */
        .form-section {
            flex: 0.8;
            display: flex;
            flex-direction: column;
            justify-content: center;
            align-items: center;
            background: #ffffff;
            padding: 2rem;
            position: relative;
        }

        .login-wrapper {
            width: 100%;
            max-width: 340px;
        }

        .login-logo {
            height: 45px;
            width: auto;
            margin-bottom: 2rem;
            display: block;
            object-fit: contain;
        }

        .login-header {
            margin-bottom: 2rem;
        }

        .login-header h2 {
            color: var(--text-main);
            font-size: 1.5rem;
            font-weight: 700;
            letter-spacing: -0.5px;
            margin-bottom: 0.25rem;
        }

        .login-header p {
            color: var(--text-muted);
            font-size: 0.85rem;
        }

        .form-group {
            margin-bottom: 1.25rem;
        }

        .form-group label {
            display: block;
            margin-bottom: 0.4rem;
            color: #334155;
            font-size: 0.8rem;
            font-weight: 600;
        }

        .input-wrapper {
            position: relative;
        }

        .form-group input {
            width: 100%;
            height: 40px; /* Desktop Height */
            padding: 0 2.5rem 0 0.75rem;
            border: 1px solid var(--border-color);
            border-radius: var(--radius);
            font-size: 0.85rem;
            color: var(--text-main);
            background: #ffffff;
            transition: all 0.15s ease-in-out;
        }

        .form-group input:focus {
            outline: none;
            border-color: var(--primary-color);
            box-shadow: 0 0 0 3px rgba(30, 64, 175, 0.1);
        }

        .toggle-password {
            position: absolute;
            right: 0;
            top: 0;
            height: 100%;
            width: 36px;
            display: flex;
            align-items: center;
            justify-content: center;
            cursor: pointer;
            color: #94a3b8;
            background: none;
            border: none;
            padding: 0;
        }

        .btn {
            width: 100%;
            height: 40px; /* Desktop Height */
            background: var(--primary-color);
            border: none;
            border-radius: var(--radius);
            color: white;
            font-size: 0.85rem;
            font-weight: 600;
            cursor: pointer;
            transition: background 0.2s;
            margin-top: 0.5rem;
            display: flex;
            align-items: center;
            justify-content: center;
            gap: 8px;
        }

        .btn:hover {
            background: var(--primary-hover);
        }

        .footer {
            margin-top: 2rem;
            text-align: center;
            font-size: 0.75rem;
            color: #94a3b8;
        }

        .spinner {
            display: none;
            width: 14px;
            height: 14px;
            border: 2px solid rgba(255,255,255,0.3);
            border-top: 2px solid #ffffff;
            border-radius: 50%;
            animation: spin 0.8s linear infinite;
        }

        @keyframes spin {
            0% { transform: rotate(0deg); }
            100% { transform: rotate(360deg); }
        }

        .error-message {
            background-color: #fef2f2;
            color: #b91c1c;
            padding: 0.65rem;
            border-radius: var(--radius);
            font-size: 0.8rem;
            margin-top: 1rem;
            border: 1px solid #fecaca;
            display: none;
            align-items: center;
            gap: 8px;
        }
        
        .error-message.show { display: flex; }

        /* --- MOBILE RESPONSIVE UPDATES --- */
        @media screen and (max-width: 900px) {
            body {
                overflow-y: auto; /* Allow scroll on small screens if needed */
            }
            
            .image-section { 
                display: none; /* Hide image */
            }
            
            .form-section { 
                flex: 1; 
                max-width: 100%; 
                background: #ffffff; /* Clean White Background */
                padding: 1.5rem;
                justify-content: center;
                min-height: 100vh;
            }

            .login-wrapper { 
                max-width: 100%; /* Use full width */
                padding: 0 0.5rem;
            }

            .login-logo {
                height: 50px; /* Larger branding */
                margin-bottom: 2.5rem;
            }

            .login-header h2 {
                font-size: 1.75rem; /* Larger title */
            }

            /* Touch-Friendly Sizes */
            .form-group input {
                height: 48px; /* Taller for touch */
                font-size: 16px; /* Prevents iOS zoom */
            }

            .btn {
                height: 48px; /* Taller for touch */
                font-size: 1rem;
            }

            .toggle-password {
                width: 44px; /* Wider touch target */
            }
        }
    </style>
</head>
<body>

    <div class="image-section">
        <div class="image-text">
            <h1>Inventory Management</h1>
            <p>Secure access to your Point of Sale and Inventory system.</p>
        </div>
    </div>

    <div class="form-section">
        <div class="login-wrapper">
            <img src="https://chlatwork.com/assets/chlart-work.png" alt="Company Logo" class="login-logo">

            <?= form_open("auth/login", ['id' => 'loginForm']); ?>
                
                <div class="login-header">
                    <h2>Sign In</h2>
                    <p>Enter your details to proceed</p>
                </div>

                <div class="form-group">
                    <label for="username">Username</label>
                    <div class="input-wrapper">
                        <input type="text" id="username" name="identity" placeholder="Enter your username" autocomplete="off">
                    </div>
                </div>

                <div class="form-group">
                    <label for="password">Password</label>
                    <div class="input-wrapper">
                        <input type="password" id="password" name="password" placeholder="Enter your password">
                        <button type="button" class="toggle-password" onclick="togglePassword()">
                            <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" />
                                <path stroke-linecap="round" stroke-linejoin="round" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z" />
                            </svg>
                        </button>
                    </div>
                </div>

                <button type="submit" class="btn" id="submitBtn">
                    <span class="btn-text">Log In</span>
                    <span class="spinner"></span>
                </button>

                <div id="error-alert" class="error-message">
                    <svg xmlns="http://www.w3.org/2000/svg" width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><circle cx="12" cy="12" r="10"></circle><line x1="12" y1="8" x2="12" y2="12"></line><line x1="12" y1="16" x2="12.01" y2="16"></line></svg>
                    <span id="error-text">Invalid credentials</span>
                </div>

                <div class="footer">
                    &copy; 2026 POS System v1.0
                </div>

            <?= form_close(); ?>
        </div>
    </div>

    <script>
        function togglePassword() {
            const passwordInput = document.getElementById('password');
            const btn = document.querySelector('.toggle-password');
            
            if (passwordInput.type === 'password') {
                passwordInput.type = 'text';
                btn.style.color = '#1e40af';
            } else {
                passwordInput.type = 'password';
                btn.style.color = '#94a3b8';
            }
        }

        document.getElementById('loginForm').addEventListener('submit', function(e) {
            const username = document.getElementById('username').value.trim();
            const password = document.getElementById('password').value.trim();
            const errorAlert = document.getElementById('error-alert');
            const submitBtn = document.getElementById('submitBtn');
            const btnText = submitBtn.querySelector('.btn-text');
            const spinner = submitBtn.querySelector('.spinner');

            errorAlert.classList.remove('show');

            if (username === '' || password === '') {
                e.preventDefault();
                errorAlert.classList.add('show');
                document.getElementById('error-text').textContent = "Username and password are required.";
                return;
            }

            btnText.textContent = "Verifying...";
            spinner.style.display = "block";
            submitBtn.disabled = true;
            submitBtn.style.opacity = "0.9";
        });
    </script>
</body>
</html>
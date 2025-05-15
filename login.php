<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login - Food Trace</title>
    <!-- Bootstrap 5 -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <!-- Material Icons -->
    <link href="https://fonts.googleapis.com/icon?family=Material+Icons" rel="stylesheet">
    <!-- Font Awesome -->
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css" rel="stylesheet">
    <!-- Google Fonts -->
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    <style>
        :root {
            --blur-intensity: 12px;
            --primary-color: #4CAF50;
            --primary-light: #7BC67E;
            --primary-dark: #3B8C3E;
            --accent-color: #FF9800;
            --text-light: #FFFFFF;
            --text-dark: #212121;
            --overlay-color: rgba(0,0,0,0.5);
            --spacing-xs: 0.5rem;
            --spacing-sm: 1rem;
            --spacing-md: 1.5rem;
            --spacing-lg: 3rem;
            --spacing-xl: 5rem;
            --border-radius-sm: 8px;
            --border-radius-md: 16px;
            --border-radius-lg: 24px;
            --transition-speed: 0.3s;
        }

        body {
            background: linear-gradient(rgba(0, 0, 0, 0.7), rgba(0, 0, 0, 0.7)), 
                        url('https://images.unsplash.com/photo-1498837167922-ddd27525d352?ixlib=rb-4.0.3&ixid=M3wxMjA3fDB8MHxwaG90by1wYWdlfHx8fGVufDB8fHx8fA%3D%3D&auto=format&fit=crop&w=2070&q=80');
            background-size: cover;
            background-attachment: fixed;
            min-height: 100vh;
            color: var(--text-light);
            font-family: 'Poppins', sans-serif;
            line-height: 1.6;
            display: flex;
            align-items: center;
            padding: var(--spacing-lg) 0;
        }

        .frosted-glass {
            background: rgba(255, 255, 255, 0.1);
            backdrop-filter: blur(var(--blur-intensity));
            -webkit-backdrop-filter: blur(var(--blur-intensity));
            border-radius: var(--border-radius-md);
            border: 1px solid rgba(255, 255, 255, 0.2);
            box-shadow: 0 8px 32px 0 rgba(0, 0, 0, 0.1);
        }

        .nav-blur {
            background: rgba(0, 0, 0, 0.2) !important;
            backdrop-filter: blur(10px) !important;
            -webkit-backdrop-filter: blur(10px) !important;
            border-bottom: 1px solid rgba(255, 255, 255, 0.1);
        }

        .navbar-brand {
            font-weight: 700;
            display: flex;
            align-items: center;
        }

        .navbar-brand i {
            color: var(--primary-color);
            margin-right: var(--spacing-xs);
        }

        .btn-primary {
            background-color: var(--primary-color);
            border-color: var(--primary-color);
            padding: var(--spacing-xs) var(--spacing-md);
            border-radius: 50px;
            font-weight: 500;
            transition: all var(--transition-speed);
            box-shadow: 0 4px 12px rgba(76, 175, 80, 0.2);
        }

        .btn-primary:hover {
            background-color: var(--primary-dark);
            border-color: var(--primary-dark);
            transform: translateY(-3px);
            box-shadow: 0 6px 15px rgba(76, 175, 80, 0.3);
        }

        .btn-outline-light {
            border-width: 2px;
            font-weight: 500;
            padding: var(--spacing-xs) var(--spacing-md);
            border-radius: 50px;
            transition: all var(--transition-speed);
        }

        .btn-outline-light:hover {
            background-color: rgba(255, 255, 255, 0.1);
            transform: translateY(-3px);
        }

        .form-control {
            background-color: rgba(255, 255, 255, 0.1);
            border: 1px solid rgba(255, 255, 255, 0.2);
            color: var(--text-light);
            padding: var(--spacing-sm);
            border-radius: var(--border-radius-sm);
            margin-bottom: var(--spacing-sm);
            transition: all var(--transition-speed);
        }

        .form-control:focus {
            background-color: rgba(255, 255, 255, 0.15);
            border-color: var(--primary-color);
            color: var(--text-light);
            box-shadow: 0 0 0 0.25rem rgba(76, 175, 80, 0.25);
        }

        .form-control::placeholder {
            color: rgba(255, 255, 255, 0.6);
        }

        .form-label {
            font-weight: 500;
            margin-bottom: var(--spacing-xs);
        }

        .login-container {
            max-width: 500px;
            width: 100%;
            margin: 0 auto;
            padding: var(--spacing-xl) var(--spacing-lg);
        }

        .login-card {
            padding: var(--spacing-xl) var(--spacing-lg);
            position: relative;
            overflow: hidden;
        }

        .login-header {
            text-align: center;
            margin-bottom: var(--spacing-lg);
        }

        .login-title {
            font-weight: 700;
            margin-bottom: var(--spacing-sm);
            display: flex;
            align-items: center;
            justify-content: center;
        }

        .login-title i {
            color: var(--primary-color);
            margin-right: var(--spacing-sm);
            font-size: 2rem;
        }

        .login-subtitle {
            color: rgba(255, 255, 255, 0.8);
            margin-bottom: 0;
        }

        .divider {
            display: flex;
            align-items: center;
            margin: var(--spacing-md) 0;
            color: rgba(255, 255, 255, 0.5);
        }

        .divider::before, .divider::after {
            content: "";
            flex: 1;
            border-bottom: 1px solid rgba(255, 255, 255, 0.2);
        }

        .divider::before {
            margin-right: var(--spacing-sm);
        }

        .divider::after {
            margin-left: var(--spacing-sm);
        }

        .social-login {
            display: flex;
            justify-content: center;
            gap: var(--spacing-sm);
            margin-bottom: var(--spacing-md);
        }

        .social-btn {
            width: 40px;
            height: 40px;
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            background: rgba(255, 255, 255, 0.1);
            color: var(--text-light);
            transition: all var(--transition-speed);
            border: none;
        }

        .social-btn:hover {
            transform: translateY(-3px);
            background: var(--primary-color);
        }

        .login-footer {
            text-align: center;
            margin-top: var(--spacing-lg);
            color: rgba(255, 255, 255, 0.7);
        }

        .login-footer a {
            color: var(--primary-light);
            text-decoration: none;
            transition: all var(--transition-speed);
        }

        .login-footer a:hover {
            color: var(--primary-color);
            text-decoration: underline;
        }

        /* Animation Effects */
        .fade-in {
            opacity: 0;
            transform: translateY(20px);
            transition: opacity 0.6s ease-out, transform 0.6s ease-out;
        }

        .fade-in.visible {
            opacity: 1;
            transform: translateY(0);
        }

        /* Floating animation */
        @keyframes float {
            0% { transform: translateY(0px); }
            50% { transform: translateY(-10px); }
            100% { transform: translateY(0px); }
        }

        .floating {
            animation: float 6s ease-in-out infinite;
        }

        /* Responsive adjustments */
        @media (max-width: 767.98px) {
            .login-container {
                padding: var(--spacing-md);
            }
            
            .login-card {
                padding: var(--spacing-lg) var(--spacing-md);
            }
            
            body {
                padding: var(--spacing-md) 0;
            }
        }

        /* Custom checkbox */
        .form-check-input {
            background-color: rgba(255, 255, 255, 0.1);
            border: 1px solid rgba(255, 255, 255, 0.3);
        }
        
        .form-check-input:checked {
            background-color: var(--primary-color);
            border-color: var(--primary-color);
        }
        
        .form-check-label {
            color: rgba(255, 255, 255, 0.8);
        }
    </style>
</head>
<body>
    <!-- Navigation -->
    <nav class="navbar navbar-expand-lg fixed-top nav-blur py-2">
        <div class="container">
            <a class="navbar-brand text-white" href="index.html">
                <i class="material-icons">grass</i>
                Food Trace
            </a>
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
                <i class="material-icons text-white">menu</i>
            </button>
            <div class="collapse navbar-collapse" id="navbarNav">
                <ul class="navbar-nav ms-auto">
                    <li class="nav-item"><a class="nav-link text-white" href="index.html#features">Features</a></li>
                    <li class="nav-item"><a class="nav-link text-white" href="index.html#how-it-works">How It Works</a></li>
                    <li class="nav-item"><a class="nav-link text-white" href="index.html#demo">Demo</a></li>
                    <li class="nav-item"><a class="nav-link text-white" href="index.html#contact">Contact</a></li>
                    <li class="nav-item ms-2 d-none"><a class="btn btn-sm btn-primary" href="login.php"><i class="material-icons me-1" style="font-size: 1rem; vertical-align: middle;">login</i> Sign In</a></li>
                </ul>
            </div>
        </div>
    </nav>

    <!-- Login Container -->
    <div class="login-container fade-in">
        <div class="frosted-glass login-card">
            <!-- Login Header -->
            <div class="login-header">
                <h2 class="login-title">
                    <i class="material-icons">verified_user</i>
                    Welcome Back
                </h2>
                <p class="login-subtitle">Sign in to access your Food Trace dashboard</p>
            </div>

            <!-- Login Form -->
            <form>
                <div class="mb-3">
                    <label for="email" class="form-label">Email Address</label>
                    <input type="email" class="form-control" id="email" placeholder="Enter your email" required>
                </div>
                <div class="mb-3">
                    <label for="password" class="form-label">Password</label>
                    <input type="password" class="form-control" id="password" placeholder="Enter your password" required>
                </div>
                <div class="mb-3 d-flex justify-content-between align-items-center">
                    <div class="form-check">
                        <input class="form-check-input" type="checkbox" id="rememberMe">
                        <label class="form-check-label" for="rememberMe">Remember me</label>
                    </div>
                    <a href="forgot-password.html" class="text-primary" style="text-decoration: none;">Forgot password?</a>
                </div>
                <button type="submit" class="btn btn-primary w-100 py-2 mb-3">
                    <i class="material-icons align-middle me-2">login</i>
                    Sign In
                </button>

                <!-- Divider -->
                <div class="divider">or continue with</div>

                <!-- Social Login -->
                <div class="social-login">
                    <button type="button" class="social-btn">
                        <i class="fab fa-google"></i>
                    </button>
                    <button type="button" class="social-btn">
                        <i class="fab fa-apple"></i>
                    </button>
                    <button type="button" class="social-btn">
                        <i class="fab fa-facebook-f"></i>
                    </button>
                    <button type="button" class="social-btn">
                        <i class="fab fa-linkedin-in"></i>
                    </button>
                </div>

                <!-- Register Link -->
                <div class="login-footer">
                    Don't have an account? <a href="register.php">Create one</a>
                </div>
            </form>
        </div>
    </div>

    <!-- Floating Elements (Decorative) -->
    <div class="position-absolute top-0 start-0 mt-5 ms-5 floating d-none" style="z-index: -1;">
        <i class="material-icons text-primary" style="font-size: 3rem; opacity: 0.3;">agriculture</i>
    </div>
    <div class="position-absolute bottom-0 end-0 mb-5 me-5 floating d-none" style="z-index: -1; animation-delay: 0.5s;">
        <i class="material-icons text-primary" style="font-size: 3rem; opacity: 0.3;">local_shipping</i>
    </div>

    <!-- Bootstrap JS -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    
    <!-- Animation Script -->
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            // Fade in animation
            const fadeElements = document.querySelectorAll('.fade-in');
            
            const observer = new IntersectionObserver((entries) => {
                entries.forEach(entry => {
                    if (entry.isIntersecting) {
                        entry.target.classList.add('visible');
                    }
                });
            }, {
                threshold: 0.1
            });
            
            fadeElements.forEach(element => {
                observer.observe(element);
            });
            
            // Form submission handling (example)
            const loginForm = document.querySelector('form');
            if (loginForm) {
                loginForm.addEventListener('submit', function(e) {
                    e.preventDefault();
                    // Here you would typically handle the login logic
                    console.log('Form submitted');
                    // You would add your AJAX/fetch login request here
                });
            }
        });
    </script>
</body>
</html>
<?php
// Add this at the top of your register.php (before any HTML output)
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Database connection
    $host = 'localhost';
    $dbname = 'foodtrace';
    $username = 'root'; // Default XAMPP username
    $password = '';     // Default XAMPP password
    
    try {
        $pdo = new PDO("mysql:host=$host;dbname=$dbname;charset=utf8mb4", $username, $password);
        $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        
        // Get form data
        $role = $_POST['userRole'];
        $firstName = $_POST['firstName'];
        $lastName = $_POST['lastName'];
        $email = $_POST['email'];
        $phone = $_POST['phone'];
        $password = $_POST['password'];
        $acceptTerms = isset($_POST['termsAgreement']) ? 1 : 0;
        $marketingConsent = isset($_POST['marketingConsent']) ? 1 : 0;
        
        // Hash password
        $passwordHash = password_hash($password, PASSWORD_DEFAULT);
        
        // Generate verification token
        $verificationToken = bin2hex(random_bytes(50));
        $verificationExpiry = date('Y-m-d H:i:s', strtotime('+24 hours'));
        
        // Prepare SQL based on role
        if ($role === 'consumer') {
            $sql = "INSERT INTO users (role, first_name, last_name, email, phone, password_hash, accept_terms, marketing_consent, verification_token, verification_expiry) 
                    VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?)";
            $stmt = $pdo->prepare($sql);
            $stmt->execute([$role, $firstName, $lastName, $email, $phone, $passwordHash, $acceptTerms, $marketingConsent, $verificationToken, $verificationExpiry]);
        } else {
            $businessName = $_POST['businessName'];
            $businessType = $_POST['businessType'];
            $businessAddress = $_POST['businessAddress'];
            $businessCity = $_POST['businessCity'];
            $businessState = $_POST['businessState'];
            $businessZip = $_POST['businessZip'];
            $businessWebsite = $_POST['businessWebsite'] ?? null;
            
            $sql = "INSERT INTO users (role, first_name, last_name, email, phone, password_hash, business_name, business_type, business_address, business_city, business_state, business_zip, business_website, accept_terms, marketing_consent, verification_token, verification_expiry) 
                    VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)";
            $stmt = $pdo->prepare($sql);
            $stmt->execute([$role, $firstName, $lastName, $email, $phone, $passwordHash, $businessName, $businessType, $businessAddress, $businessCity, $businessState, $businessZip, $businessWebsite, $acceptTerms, $marketingConsent, $verificationToken, $verificationExpiry]);
        }
        
        // Get the new user ID
        $userId = $pdo->lastInsertId();
        
        // Create a basic profile
        $sql = "INSERT INTO user_profiles (user_id) VALUES (?)";
        $stmt = $pdo->prepare($sql);
        $stmt->execute([$userId]);
        
        // Send verification email (pseudo-code)
        // sendVerificationEmail($email, $verificationToken);
        
        // Redirect to success page
        header('Location: registration-success.php');
        exit();
        
    } catch (PDOException $e) {
        $error = "Database error: " . $e->getMessage();
    }
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Register - Food Trace</title>
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

        .register-container {
            max-width: 800px;
            width: 100%;
            margin: 0 auto;
            padding: var(--spacing-xl) var(--spacing-lg);
        }

        .register-card {
            padding: var(--spacing-xl) var(--spacing-lg);
            position: relative;
            overflow: hidden;
        }

        .register-header {
            text-align: center;
            margin-bottom: var(--spacing-lg);
        }

        .register-title {
            font-weight: 700;
            margin-bottom: var(--spacing-sm);
            display: flex;
            align-items: center;
            justify-content: center;
        }

        .register-title i {
            color: var(--primary-color);
            margin-right: var(--spacing-sm);
            font-size: 2rem;
        }

        .register-subtitle {
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

        .role-selection {
            margin-bottom: var(--spacing-lg);
        }

        .role-options {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(120px, 1fr));
            gap: var(--spacing-sm);
            margin-top: var(--spacing-md);
        }

        .role-option {
            position: relative;
            cursor: pointer;
            transition: all var(--transition-speed);
        }

        .role-option input {
            position: absolute;
            opacity: 0;
            height: 0;
            width: 0;
        }

        .role-label {
            display: flex;
            flex-direction: column;
            align-items: center;
            padding: var(--spacing-md);
            border-radius: var(--border-radius-sm);
            background: rgba(255, 255, 255, 0.05);
            border: 2px solid transparent;
            transition: all var(--transition-speed);
            text-align: center;
            height: 100%;
        }

        .role-option input:checked + .role-label {
            background: rgba(76, 175, 80, 0.1);
            border-color: var(--primary-color);
            transform: translateY(-5px);
        }

        .role-icon {
            font-size: 2rem;
            margin-bottom: var(--spacing-xs);
            color: var(--primary-color);
        }

        .role-name {
            font-weight: 500;
            margin-bottom: var(--spacing-xs);
        }

        .role-description {
            font-size: 0.8rem;
            color: rgba(255, 255, 255, 0.7);
        }

        .form-row {
            display: flex;
            flex-wrap: wrap;
            gap: var(--spacing-sm);
        }

        .form-row .form-group {
            flex: 1;
            min-width: 200px;
        }

        .register-footer {
            text-align: center;
            margin-top: var(--spacing-lg);
            color: rgba(255, 255, 255, 0.7);
        }

        .register-footer a {
            color: var(--primary-light);
            text-decoration: none;
            transition: all var(--transition-speed);
        }

        .register-footer a:hover {
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
            .register-container {
                padding: var(--spacing-md);
            }
            
            .register-card {
                padding: var(--spacing-lg) var(--spacing-md);
            }
            
            body {
                padding: var(--spacing-md) 0;
            }
            
            .role-options {
                grid-template-columns: 1fr 1fr;
            }
        }

        @media (max-width: 480px) {
            .role-options {
                grid-template-columns: 1fr;
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
        
        /* Password strength indicator */
        .password-strength {
            height: 4px;
            background: rgba(255, 255, 255, 0.1);
            margin-top: -8px;
            margin-bottom: var(--spacing-sm);
            border-radius: 2px;
            overflow: hidden;
        }
        
        .password-strength-bar {
            height: 100%;
            width: 0;
            background: #f44336;
            transition: width 0.3s, background 0.3s;
        }
        
        /* Business info section (initially hidden) */
        .business-info {
            display: none;
            animation: fadeIn 0.5s ease-out;
        }
        
        @keyframes fadeIn {
            from { opacity: 0; transform: translateY(10px); }
            to { opacity: 1; transform: translateY(0); }
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
                    <li class="nav-item ms-2"><a class="btn btn-sm btn-primary" href="login.php"><i class="material-icons me-1" style="font-size: 1rem; vertical-align: middle;">login</i> Sign In</a></li>
                </ul>
            </div>
        </div>
    </nav>

    <!-- Registration Container -->
    <div class="register-container fade-in">
        <div class="frosted-glass register-card">
            <!-- Registration Header -->
            <div class="register-header">
                <h2 class="register-title">
                    <i class="material-icons">person_add</i>
                    Create Your Account
                </h2>
                <p class="register-subtitle">Join Food Trace as part of our transparent food ecosystem</p>
            </div>

            <!-- Registration Form -->
            <form id="registrationForm" action="includes/registration_handler.php" method="POST">
                <!-- Role Selection -->
                <div class="role-selection">
                    <h5 class="text-center mb-3">I am registering as a:</h5>
                    <div class="role-options">
                        <!-- Consumer -->
                        <label class="role-option">
                            <input type="radio" name="userRole" value="consumer" checked>
                            <div class="role-label">
                                <i class="material-icons role-icon">shopping_basket</i>
                                <span class="role-name">Consumer</span>
                                <span class="role-description">Track food products</span>
                            </div>
                        </label>
                        
                        <!-- Farmer -->
                        <label class="role-option">
                            <input type="radio" name="userRole" value="farmer">
                            <div class="role-label">
                                <i class="material-icons role-icon">agriculture</i>
                                <span class="role-name">Farmer</span>
                                <span class="role-description">Register your produce</span>
                            </div>
                        </label>
                        
                        <!-- Food Processor -->
                        <label class="role-option">
                            <input type="radio" name="userRole" value="processor">
                            <div class="role-label">
                                <i class="material-icons role-icon">factory</i>
                                <span class="role-name">Processor</span>
                                <span class="role-description">Log processing data</span>
                            </div>
                        </label>
                        
                        <!-- Distributor -->
                        <label class="role-option">
                            <input type="radio" name="userRole" value="distributor">
                            <div class="role-label">
                                <i class="material-icons role-icon">local_shipping</i>
                                <span class="role-name">Distributor</span>
                                <span class="role-description">Track shipments</span>
                            </div>
                        </label>
                        
                        <!-- Marketer -->
                        <label class="role-option">
                            <input type="radio" name="userRole" value="marketer">
                            <div class="role-label">
                                <i class="material-icons role-icon">storefront</i>
                                <span class="role-name">Marketer</span>
                                <span class="role-description">Retail & sales data</span>
                            </div>
                        </label>
                    </div>
                </div>

                <!-- Basic Information -->
                <h5 class="mb-3">Basic Information</h5>
                <div class="form-row">
                    <div class="form-group">
                        <label for="firstName" class="form-label">First Name</label>
                        <input type="text" class="form-control" id="firstName" placeholder="Enter your first name" required>
                    </div>
                    <div class="form-group">
                        <label for="lastName" class="form-label">Last Name</label>
                        <input type="text" class="form-control" id="lastName" placeholder="Enter your last name" required>
                    </div>
                </div>
                
                <div class="form-group">
                    <label for="email" class="form-label">Email Address</label>
                    <input type="email" class="form-control" id="email" placeholder="Enter your email" required>
                </div>
                
                <div class="form-group">
                    <label for="phone" class="form-label">Phone Number</label>
                    <input type="tel" class="form-control" id="phone" placeholder="Enter your phone number">
                </div>
                
                <div class="form-row">
                    <div class="form-group">
                        <label for="password" class="form-label">Password</label>
                        <input type="password" class="form-control" id="password" placeholder="Create a password" required>
                        <div class="password-strength">
                            <div class="password-strength-bar" id="passwordStrength"></div>
                        </div>
                    </div>
                    <div class="form-group">
                        <label for="confirmPassword" class="form-label">Confirm Password</label>
                        <input type="password" class="form-control" id="confirmPassword" placeholder="Confirm your password" required>
                    </div>
                </div>
                
                <!-- Business Information (shown for non-consumers) -->
                <div id="businessInfo" class="business-info">
                    <h5 class="mb-3 mt-4">Business Information</h5>
                    <div class="form-group">
                        <label for="businessName" class="form-label">Business Name</label>
                        <input type="text" class="form-control" id="businessName" placeholder="Enter your business name">
                    </div>
                    
                    <div class="form-group">
                        <label for="businessType" class="form-label">Business Type</label>
                        <select class="form-control bg-dark" id="businessType">
                            <option value="">Select business type</option>
                            <option value="individual">Individual/Sole Proprietor</option>
                            <option value="llc">LLC</option>
                            <option value="corporation">Corporation</option>
                            <option value="cooperative">Cooperative</option>
                            <option value="other">Other</option>
                        </select>
                    </div>
                    
                    <div class="form-group">
                        <label for="businessAddress" class="form-label">Business Address</label>
                        <input type="text" class="form-control" id="businessAddress" placeholder="Enter your business address">
                    </div>
                    
                    <div class="form-row">
                        <div class="form-group">
                            <label for="businessCity" class="form-label">City</label>
                            <input type="text" class="form-control" id="businessCity" placeholder="City">
                        </div>
                        <div class="form-group">
                            <label for="businessState" class="form-label">State/Region</label>
                            <input type="text" class="form-control" id="businessState" placeholder="State/Region">
                        </div>
                        <div class="form-group">
                            <label for="businessZip" class="form-label">Postal Code</label>
                            <input type="text" class="form-control" id="businessZip" placeholder="Postal code">
                        </div>
                    </div>
                    
                    <div class="form-group">
                        <label for="businessWebsite" class="form-label">Website (optional)</label>
                        <input type="url" class="form-control" id="businessWebsite" placeholder="https://example.com">
                    </div>
                </div>
                
                <!-- Terms and Conditions -->
                <div class="form-check mt-4">
                    <input class="form-check-input" type="checkbox" id="termsAgreement" required>
                    <label class="form-check-label" for="termsAgreement">
                        I agree to the <a href="#" class="text-primary">Terms of Service</a> and <a href="#" class="text-primary">Privacy Policy</a>
                    </label>
                </div>
                
                <div class="form-check">
                    <input class="form-check-input" type="checkbox" id="marketingConsent">
                    <label class="form-check-label" for="marketingConsent">
                        I want to receive updates and newsletters
                    </label>
                </div>
                
                <!-- Submit Button -->
                <button type="submit" class="btn btn-primary w-100 py-2 mt-4">
                    <i class="material-icons align-middle me-2">how_to_reg</i>
                    Create Account
                </button>

                <!-- Login Link -->
                <div class="register-footer mt-4">
                    Already have an account? <a href="login.php">Sign in here</a>
                </div>
            </action=>
        </div>
    </div>

    <!-- Floating Elements (Decorative) -->
    <div class="position-absolute top-0 start-0 mt-5 ms-5 floating" style="z-index: -1;">
        <i class="material-icons text-primary" style="font-size: 3rem; opacity: 0.3;">agriculture</i>
    </div>
    <div class="position-absolute bottom-0 end-0 mb-5 me-5 floating" style="z-index: -1; animation-delay: 0.5s;">
        <i class="material-icons text-primary" style="font-size: 3rem; opacity: 0.3;">local_shipping</i>
    </div>

    <!-- Bootstrap JS -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    
    <!-- Registration Script -->
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
            
            // Role selection - show/hide business info
            const roleInputs = document.querySelectorAll('input[name="userRole"]');
            const businessInfo = document.getElementById('businessInfo');
            
            roleInputs.forEach(input => {
                input.addEventListener('change', function() {
                    if (this.value !== 'consumer') {
                        businessInfo.style.display = 'block';
                        // Add required to business fields
                        document.querySelectorAll('#businessInfo input').forEach(field => {
                            field.required = true;
                        });
                    } else {
                        businessInfo.style.display = 'none';
                        // Remove required from business fields
                        document.querySelectorAll('#businessInfo input').forEach(field => {
                            field.required = false;
                        });
                    }
                });
            });
            
            // Password strength indicator
            const passwordInput = document.getElementById('password');
            const strengthBar = document.getElementById('passwordStrength');
            
            passwordInput.addEventListener('input', function() {
                const password = this.value;
                let strength = 0;
                
                // Length check
                if (password.length >= 8) strength += 1;
                if (password.length >= 12) strength += 1;
                
                // Complexity checks
                if (/[A-Z]/.test(password)) strength += 1;
                if (/[0-9]/.test(password)) strength += 1;
                if (/[^A-Za-z0-9]/.test(password)) strength += 1;
                
                // Update strength bar
                let width = 0;
                let color = '#f44336'; // Red
                
                if (strength <= 2) {
                    width = 33;
                } else if (strength <= 4) {
                    width = 66;
                    color = '#FF9800'; // Orange
                } else {
                    width = 100;
                    color = '#4CAF50'; // Green
                }
                
                strengthBar.style.width = width + '%';
                strengthBar.style.background = color;
            });
            
            // Form submission handling
            const registrationForm = document.getElementById('registrationForm');
            if (registrationForm) {
                registrationForm.addEventListener('submit', function(e) {
                    e.preventDefault();
                    
                    // Basic validation
                    const password = document.getElementById('password').value;
                    const confirmPassword = document.getElementById('confirmPassword').value;
                    
                    if (password !== confirmPassword) {
                        alert('Passwords do not match!');
                        return;
                    }
                    
                    // Here you would typically handle the registration logic
                    const formData = {
                        role: document.querySelector('input[name="userRole"]:checked').value,
                        firstName: document.getElementById('firstName').value,
                        lastName: document.getElementById('lastName').value,
                        email: document.getElementById('email').value,
                        phone: document.getElementById('phone').value,
                        password: password,
                        // Add business info if not consumer
                        ...(document.querySelector('input[name="userRole"]:checked').value !== 'consumer' ? {
                            businessName: document.getElementById('businessName').value,
                            businessType: document.getElementById('businessType').value,
                            businessAddress: document.getElementById('businessAddress').value,
                            businessCity: document.getElementById('businessCity').value,
                            businessState: document.getElementById('businessState').value,
                            businessZip: document.getElementById('businessZip').value,
                            businessWebsite: document.getElementById('businessWebsite').value
                        } : {})
                    };
                    
                    console.log('Registration data:', formData);
                    // You would add your AJAX/fetch registration request here
                    
                    // Simulate successful registration
                    setTimeout(() => {
                        alert('Registration successful! Redirecting to dashboard...');
                        // window.location.href = 'dashboard.html';
                    }, 1000);
                });
            }
        });
    </script>
</body>
</html>
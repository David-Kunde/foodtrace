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
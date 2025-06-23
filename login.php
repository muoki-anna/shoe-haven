<?php
ini_set('log_errors', 1);
ini_set('error_log', 'php_errors.log');
error_reporting(E_ALL);
ini_set('display_errors', 1);

session_start();

$conn = new mysqli("localhost", "root", "", "shoe-haven");
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

$errors = [];

// Process login form when submitted
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    // Sanitize and validate inputs
    $email = sanitizeInput($_POST['email']);
    $password = $_POST['password'];

    // Validation
    if (empty($email)) {
        $errors['email'] = 'Email is required';
    } elseif (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        $errors['email'] = 'Invalid email format';
    }

    if (empty($password)) {
        $errors['password'] = 'Password is required';
    }

    // If no errors, proceed with login
    if (empty($errors)) {
        // Check if user exists
        $stmt = $conn->prepare("SELECT id, first_name, last_name, password FROM customers WHERE email = ?");
        $stmt->bind_param("s", $email);
        $stmt->execute();
        $result = $stmt->get_result();
        
        if ($result->num_rows == 1) {
            $user = $result->fetch_assoc();
            
            // Verify password (Note: Your registration code stores plain text password, this should be hashed)
            // Currently checking plain text since your registration doesn't hash
            if ($password === $user['password']) {
                // Password is correct, start session
                $_SESSION['user_id'] = $user['id'];
                $_SESSION['first_name'] = $user['first_name'];
                $_SESSION['last_name'] = $user['last_name'];
                $_SESSION['email'] = $email;
                $_SESSION['logged_in'] = true;
                
                // Redirect to dashboard or home page
                header('Location: index.html');
                exit();
            } else {
                $errors['login'] = 'Invalid email or password';
            }
        } else {
            $errors['login'] = 'Invalid email or password';
        }
        $stmt->close();
    }
}

// Function to sanitize input (same as in your registration)
function sanitizeInput($data) {
    return htmlspecialchars(stripslashes(trim($data)));
}

// Close database connection
$conn->close();
?>


<?php
// Include PHPMailer
require 'PHPMailer/src/Exception.php';
require 'PHPMailer/src/PHPMailer.php';
require 'PHPMailer/src/SMTP.php';

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

if ($_SERVER["REQUEST_METHOD"] == "POST") {
   
    // Database connection
    /*
    $servername = "localhost";
    $username = "root";
    $password = "";
    $dbname = "municipal_billing";*/

  
$servername = "sql110.infinityfree.com";
$username = "if0_37164635";
$password = "bd2xR7cX6JRK";
$dbname = "if0_37164635_municipal_billing";

    // Create a connection to the database
$conn = new mysqli($servername, $username, $password, $dbname);

    // Check connection
    if ($conn->connect_error) {
        die("Connection failed: " . $conn->connect_error);
    }

    // Retrieve and sanitize input
    $first_name = $conn->real_escape_string($_POST['first_name']);
    $last_name = $conn->real_escape_string($_POST['last_name']);
    $email = $conn->real_escape_string($_POST['email']);
    $password = password_hash($_POST['password'], PASSWORD_BCRYPT);
    $id_number = $conn->real_escape_string($_POST['id_number']);
    $date_of_birth = $conn->real_escape_string($_POST['date_of_birth']);

    // Insert into database
    $sql = "INSERT INTO users (first_name, last_name, email, password, id_number, date_of_birth) 
            VALUES ('$first_name', '$last_name', '$email', '$password', '$id_number', '$date_of_birth')";

    if ($conn->query($sql) === TRUE) {
        // Send email with user details
        $mail = new PHPMailer(true);

        try {
            //Server settings
            $mail->isSMTP();                                            
            $mail->Host       = 'smtp.gmail.com';  
            $mail->SMTPAuth   = true;                                   
            $mail->Username   = 'smesihlentshangase@gmail.com';  
            $mail->Password   = 'xbmlvarordkdidlc';        
            $mail->SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS;         
            $mail->Port       = 587;                                    

            //Recipients
            $mail->setFrom('smesihlentshangase@gmail.com', 'Billing System');
            $mail->addAddress($email, $first_name . ' ' . $last_name);

            // Content
            $mail->isHTML(true);                                  
            $mail->Subject = 'Welcome to Billing System';
            $mail->Body    = "<h1>Welcome, $first_name!</h1>
                              <p>Thank you for signing up. Here are your details:</p>
                              <p><strong>Email:</strong> $email</p>
                              <p><strong>Password:</strong> $password</p>
                              <p>You can now log in using your email and password.</p>
                              <p>Best regards,<br>Billing System</p>";

            $mail->send();
            echo "<script>alert('Signup successful, and email has been sent.');window.location.href='index.php';</script>";
            exit();
        } catch (Exception $e) {
            echo "Signup successful, but email could not be sent. Mailer Error: {$mail->ErrorInfo}";
        }

        // Redirect to login or another page
        header("Location: index.php");
    } else {
        echo "Error: " . $sql . "<br>" . $conn->error;
    }

    $conn->close();
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Signup</title>
    <link href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css" rel="stylesheet">
     <!-- Bootstrap CSS -->
     <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <!-- FontAwesome Icons -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
    <!-- Custom CSS -->
    <link rel="stylesheet" type="text/css" href="assets/css/login.css">
</head>
<style>
    body {
    font-family: Arial, sans-serif;
    background: #f0f2f5;
    color: #333;
    margin: 0;
    padding: 0;
}

.container {
    max-width: 600px;
    margin: 50px auto;
}

.login-container, .signup-container {
    background: #fff;
    border-radius: 10px;
    box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
    padding: 20px;
}

.login-container h2, .signup-container h2 {
    text-align: center;
    color: #0056b3;
}

.form-group {
    margin-bottom: 15px;
}

.btn-primary {
    background-color: #0056b3;
    border: none;
    margin-top: 10px;
}

.btn-primary:hover {
    background-color: #004494;
}

a {
    color: #0056b3;
}

a:hover {
    color: #004494;
}
.navbar {
    background: rgba(0, 86, 179, 0.7);
    box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
}

.navbar .navbar-brand {
    color: #fff;
    ofnt-weight:bold;
}

.navbar .navbar-nav .nav-link {
    color: #fff;
    font-size : 1.1em;
}

.navbar .navbar-nav .nav-link:hover {
    color: #f8f9fa;
}

.container-fluid {
    padding: 20px;
}
    </style>
<body>
<nav class="navbar navbar-expand-lg navbar-dark">
        <div class="container-fluid">
            <a class="navbar-brand" href="home.php">Municipal Billing System</a>
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse" id="navbarNav">
           

            </div>
             </div>
         </nav>

    <div class="container">
        <div class="signup-container">
            <h2>Signup</h2>
            <form action="signup.php" method="post">
                <div class="form-group">
                    <label for="signupFirstName">First Name</label>
                    <input type="text" class="form-control" id="signupFirstName" name="first_name" placeholder="Enter first name" required>
                </div>
                <div class="form-group">
                    <label for="signupLastName">Last Name</label>
                    <input type="text" class="form-control" id="signupLastName" name="last_name" placeholder="Enter last name" required>
                </div>
                <div class="form-group">
                    <label for="signupEmail">Email address</label>
                    <input type="email" class="form-control" id="signupEmail" name="email" placeholder="Enter email" required>
                </div>
                <div class="form-group">
                    <label for="signupPassword">Password</label>
                    <input type="password" class="form-control" id="signupPassword" name="password" placeholder="Password" required>
                </div>
                <div class="form-group">
                    <label for="signupIdNumber">ID Number</label>
                    <input type="text" class="form-control" id="signupIdNumber" name="id_number" placeholder="Enter ID number" required>
                </div>
                <div class="form-group">
                    <label for="signupMeterNumber">Date Of Birth</label>
                    <input type="date" class="form-control" id="signupMeterNumber" name="date_of_birth" placeholder="Enter Meter number" required>
                </div>
                <button type="submit" class="btn btn-primary">Signup</button>
                <p>Already have an account? <a href="login.php">Login</a></p>
            </form>
        </div>
    </div>
    <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.5.3/dist/umd/popper.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
</body>
</html>

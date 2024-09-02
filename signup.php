<?php
// Include PHPMailer
require 'PHPMailer/src/Exception.php';
require 'PHPMailer/src/PHPMailer.php';
require 'PHPMailer/src/SMTP.php';

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

if ($_SERVER["REQUEST_METHOD"] == "POST") {
   
    // Database connection
    $servername = "localhost";
    $username = "root";
    $password = "";
    $dbname = "municipal_billing";

  /* 
$servername = "sql110.infinityfree.com";
$username = "if0_37164635";
$password = "bd2xR7cX6JRK";
$dbname = "if0_37164635_municipal_billing";
*/
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
    $meter_number = $conn->real_escape_string($_POST['meter_number']);

    // Insert into database
    $sql = "INSERT INTO users (first_name, last_name, email, password, id_number, meter_number) 
            VALUES ('$first_name', '$last_name', '$email', '$password', '$id_number', '$meter_number')";

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
                              <p><strong>ID Number:</strong> $id_number</p>
                              <p><strong>Meter Number:</strong> $meter_number</p>
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

<?php
session_start(); // Start a session to store user information

// Include your database connection file
/*
$servername = "sql110.infinityfree.com";
$username = "if0_37164635";
$password = "bd2xR7cX6JRK";
$dbname = "if0_37164635_municipal_billing";*/

$servername = "localhost";
$username = "root";
$password = "";
$dbname = "municipal_billing";

// Create a connection to the database
$conn = new mysqli($servername, $username, $password, $dbname);

// Check if the connection was successful
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Check if the form was submitted via POST
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Retrieve and sanitize email and password inputs
    $email = trim($_POST['email']);
    $password = trim($_POST['password']);

    // Validate that both fields are filled
    if (empty($email) || empty($password)) {
        echo "<script>alert('Please fill in both email and password.');</script>";
        exit;
    }

    // Prepare a SQL statement to prevent SQL injection
    $stmt = $conn->prepare("SELECT id, password, role FROM users WHERE email = ?");
    $stmt->bind_param("s", $email);
    $stmt->execute();
    $stmt->store_result();

    // Check if the email exists in the database
    if ($stmt->num_rows > 0) {
        $stmt->bind_result($user_id, $hashed_password, $role);
        $stmt->fetch();

        // Verify the password
        if (password_verify($password, $hashed_password)) {
            // If password is correct, set session variables
            $_SESSION['user_id'] = $user_id;
            $_SESSION['email'] = $email;
            $_SESSION['role'] = $role;

            // Redirect based on the user's role
            if ($role === 'admin') {
                header("Location: admin/admin_dashboard.php");
            } else {
                header("Location: dashboard.php");
            }
            exit;
        } else {
            echo "<script>alert('Incorrect password.');window.location.href='index.php';</script>";
            header("Location: index.php");
        }
    } else {
        echo "<script>alert('No user found with that email.');window.location.href='index.php';</script>";
    }

    // Close the statement and connection
    $stmt->close();
    $conn->close();
}
?>

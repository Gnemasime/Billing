<?php
session_start();
if (!isset($_SESSION['role']) || $_SESSION['role'] != 'admin') {
    header("Location: ../login.php");
    exit();
}

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
// Create connection
$conn = new mysqli($servername, $username, $password, $dbname);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Check if form is submitted
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $resident_id = $conn->real_escape_string($_POST['resident_id']);
    $service_type = $conn->real_escape_string($_POST['service_type']);
    $amount_due = $conn->real_escape_string($_POST['amount_due']);
    $status = $conn->real_escape_string($_POST['status']);
    $due_date = $conn->real_escape_string($_POST['due_date']);
    
    // Prepare the SQL statement
    $sql = "INSERT INTO bills (resident_id, service_type, amount_due, status, due_date)
            VALUES ('$resident_id', '$service_type', '$amount_due', '$status', '$due_date')";
    
    // Execute the SQL statement
    if ($conn->query($sql) === TRUE) {
        $_SESSION['message'] = "Bill added successfully";
        header("Location: ../manager_bills.php"); // Redirect to the main page
    } else {
        $_SESSION['message'] = "Error: " . $sql . "<br>" . $conn->error;
        header("Location: ../admin_dashboard.php"); // Redirect to the main page
    }

    // Close connection
    $conn->close();
} else {
    $_SESSION['message'] = "Invalid request";
    header("Location: ../admin_dashboard.php"); // Redirect to the main page
}
?>

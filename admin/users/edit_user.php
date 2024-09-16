<?php
session_start();
if (!isset($_SESSION['role']) || $_SESSION['role'] != 'admin') {
    header("Location: login.php");
    exit();
}

// Database connection
/*
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "municipal_billing";
*/
$servername = "sql110.infinityfree.com";
$username = "if0_37164635";
$password = "bd2xR7cX6JRK";
$dbname = "if0_37164635_municipal_billing";

// Create a connection to the database
$conn = new mysqli($servername, $username, $password, $dbname);

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Edit user
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $id = $_POST['id'];
    $first_name = $_POST['first_name'];
    $last_name = $_POST['last_name'];
    $email = $_POST['email'];
    $role = $_POST['role'];
    $id_number = $_POST['id_number'];

    $stmt = $conn->prepare("UPDATE users SET first_name = ?, last_name = ?, email = ?, role = ?, id_number = ? WHERE id = ?");
    $stmt->bind_param("sssssi", $first_name, $last_name, $email, $role, $id_number, $id);

    if ($stmt->execute()) {
        echo "<script>alert('User updated successfully.'); window.location.href='../manage_users.php';</script>";
    } else {
        echo "<script>alert('Error updating user. Please try again.'); window.history.back();</script>";
    }

    $stmt->close();
    $conn->close();
}
?>

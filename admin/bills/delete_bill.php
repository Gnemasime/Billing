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

$conn = new mysqli($servername, $username, $password, $dbname);

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Delete bill
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $id = $_POST['id'];

    $stmt = $conn->prepare("DELETE FROM bills WHERE id = ?");
    $stmt->bind_param("i", $id);

    if ($stmt->execute()) {
        echo "<script>alert('Bill deleted successfully.'); window.location.href='../manage_bills.php';</script>";
    } else {
        echo "<script>alert('Error deleting bill. Please try again.'); window.history.back();</script>";
    }

    $stmt->close();
    $conn->close();
}
?>
``

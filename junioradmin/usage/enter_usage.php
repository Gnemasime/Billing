<?php
session_start();
if (!isset($_SESSION['role']) || $_SESSION['role'] != 'admin') {
    header("Location: login.php");
    exit();
}

// Database connection
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "municipal_billing";

$conn = new mysqli($servername, $username, $password, $dbname);

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $user_id = intval($_POST['user_id']);
    $amount_used = floatval($_POST['amount_used']);

    // Insert or update the usage amount in the usage_amount table
    $sql = "INSERT INTO usage_amount (user_id, service_id, amount_used, created_at)
            VALUES (?, (SELECT id FROM bills WHERE name = 'water' LIMIT 1), ?, NOW())
            ON DUPLICATE KEY UPDATE amount_used = amount_used + VALUES(amount_used)";

    $stmt = $conn->prepare($sql);
    $stmt->bind_param("id", $user_id, $amount_used);

    if ($stmt->execute()) {
        $_SESSION['message'] = "Usage amount updated successfully.";
        header("Location: ../manage_users.php");
    } else {
        $_SESSION['error'] = "Error updating usage amount: " . $stmt->error;
        header("Location: ../manage_users.php");
    }

    $stmt->close();
}

$conn->close();
?>

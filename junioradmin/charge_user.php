<?php
session_start();
//include('db_connection.php');

if ($_SESSION['role'] != 'junioradmin') {
    header("Location: ../index.php");
    exit();
}

$conn = new mysqli("localhost", "root", "", "municipal_billing");
if (isset($_GET['bill_id'])) {
    $bill_id = $_GET['bill_id'];

    $sql = "SELECT * FROM bills WHERE id = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("i", $bill_id);
    $stmt->execute();
    $result = $stmt->get_result();
    $bill = $result->fetch_assoc();

    // Fetch user type and calculate the charge
    $sql = "SELECT user_type FROM users WHERE id = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("i", $bill['resident_id']);
    $stmt->execute();
    $result = $stmt->get_result();
    $user = $result->fetch_assoc();

    $charge_multiplier = 1;
    if ($user['user_type'] == 'commercial') {
        $charge_multiplier = 3;
    } elseif ($user['user_type'] == 'industrial') {
        $charge_multiplier = 4;
    }

    $final_amount = $bill['amount_due'] * $charge_multiplier;

    echo "Final Amount to be charged: " . $final_amount;
    
    // Update the bill with the final amount
    $sql = "UPDATE bills SET amount_due = ? WHERE id = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("di", $final_amount, $bill_id);
    $stmt->execute();
    
    echo "<br>Charge applied successfully!";
}

$conn->close();
?>

<?php
session_start();

// Check if the user is logged in
if (!isset($_SESSION['user_id'])) {
    header("Location: index.php");
    exit();
}

// Include PayPal SDK manually
require_once __DIR__ . '/paypal/autoload.php'; // Adjust the path as necessary

// PayPal API credentials (replace these with your live credentials if needed)
$clientId = 'AdXHEP1jTg0J_HDMelGoKzkmXiJqg65ZVFa8ibAfReLDAq0XecE9z0bGuVfNjLFHtIxOkd-0Mr142NJt'; 
$clientSecret = 'EBkxRjpt0YuacBgg5WwX2S6tDSu7xV-gcovLblYrpsTzeBurBqP_3P3CUEfqaNUhREvaZeYzYVhotyn8';

// Create PayPal environment and client
$apiContext = new \PayPal\Rest\ApiContext(
    new \PayPal\Auth\OAuthTokenCredential($clientId, $clientSecret)
);

// Set PayPal environment (sandbox for testing)
$apiContext->setConfig(['mode' => 'sandbox']);

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
$conn = new mysqli($servername, $username, $password, $dbname);
*/
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Get the bill ID from the URL
$bill_id = isset($_GET['bill_id']) ? intval($_GET['bill_id']) : 0;
$user_id = $_SESSION['user_id'];

// Fetch the bill details to get the amount due
$stmt = $conn->prepare("SELECT amount_due FROM bills WHERE id = ? AND resident_id = ?");
$stmt->bind_param("ii", $bill_id, $user_id);
$stmt->execute();
$stmt->bind_result($amount_due);
$stmt->fetch();
$stmt->close();

if (!$amount_due) {
    echo "<script>alert('Invalid bill or unauthorized access.'); window.location.href = 'dashboard.php';</script>";
    exit();
}

// Create payment execution object
$paymentId = isset($_GET['paymentId']) ? $_GET['paymentId'] : null; // Get this from the PayPal payment approval response
$payerId = isset($_GET['PayerID']) ? $_GET['PayerID'] : null;     // Get this from the PayPal payment approval response

if ($paymentId && $payerId) {
    $payment = \PayPal\Api\Payment::get($paymentId, $apiContext);
    $execute = new \PayPal\Api\PaymentExecution();
    $execute->setPayerId($payerId);

    try {
        $result = $payment->execute($execute, $apiContext);
        
        // Update the bill status to "paid" after successful execution
        $stmt = $conn->prepare("UPDATE bills SET status = 'paid' WHERE id = ? AND resident_id = ?");
        $stmt->bind_param("ii", $bill_id, $user_id);

        if ($stmt->execute()) {
            // Insert the transaction into the transactions table
            $stmt = $conn->prepare("INSERT INTO transactions (bill_id, payment_amount) VALUES (?, ?)");
            $stmt->bind_param("id", $bill_id, $amount_due);
            $stmt->execute();

            echo "<script>alert('Payment successful!'); window.location.href = 'dashboard.php';</script>";
        } else {
            echo "<script>alert('Error updating bill status. Please try again.'); window.history.back();</script>";
        }

        $stmt->close();
    } catch (Exception $ex) {
        echo "<script>alert('Payment failed. Please try again.'); window.history.back();</script>";
        exit(1);
    }
} else {
    echo "<script>alert('Invalid payment details.'); window.history.back();</script>";
}

$conn->close();
?>

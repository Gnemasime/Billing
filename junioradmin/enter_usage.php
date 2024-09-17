
<?php
session_start();

// Check if the user is an admin
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

// Handle form submission
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $meter_number = $_POST['meter_number_usage'];
    $service_type = $_POST['service_type'];
    $amount_used = $_POST['amount_used'];

    // Fetch the user ID based on the meter number
    $stmt = $conn->prepare("SELECT id FROM users WHERE meter_number = ?");
    $stmt->bind_param("s", $meter_number);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows > 0) {
        $user = $result->fetch_assoc();
        $user_id = $user['id'];

        // Fetch the service ID based on the selected service type from the `services` table
        $serviceStmt = $conn->prepare("SELECT id FROM services WHERE name = ?");
        $serviceStmt->bind_param("s", $service_type);
        $serviceStmt->execute();
        $serviceResult = $serviceStmt->get_result();

        if ($serviceResult->num_rows > 0) {
            $service = $serviceResult->fetch_assoc();
            $service_id = $service['id'];

            // Insert the usage data into the `usage_amount` table
            $usageStmt = $conn->prepare("INSERT INTO usage_amount (user_id, service_id, amount_used) VALUES (?, ?, ?)");
            $usageStmt->bind_param("iid", $user_id, $service_id, $amount_used);

            if ($usageStmt->execute()) {
                echo "<script>alert('Usage recorded successfully.'); window.location.href='index.php';</script>";
            } else {
                echo "<script>alert('Error recording usage. Please try again.');window.location.href='index.php';</script>";
            }

            $usageStmt->close();
        } else {
            echo "<script>alert('Invalid service type selected. Please ensure services are correctly configured in the database.');window.location.href='index.php';</script>";
        }

        $serviceStmt->close();
    } else {
        echo "<script>alert('Meter number not found. Please check and try again.'); window.location.href='index.php';</script>";
    }

    $stmt->close();
    $conn->close();
}
?>
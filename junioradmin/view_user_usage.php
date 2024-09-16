<?php
session_start();
if ($_SESSION['role'] != 'admin') {
    header("Location: ../index.php");
    exit();
}

$conn = new mysqli("localhost", "root", "", "municipal_billing");

$user_id = $_GET['user_id'];

// Fetch user details
$stmt = $conn->prepare("SELECT email FROM users WHERE id = ?");
$stmt->bind_param("i", $user_id);
$stmt->execute();
$stmt->bind_result($email);
$stmt->fetch();
$stmt->close();

// Fetch usage data for the user
$usage_data = $conn->query("SELECT services.name AS service_name, usage_amount.amount_used, usage_amount.created_at
    FROM usage_amount
    INNER JOIN services ON usage_amount.service_id = services.id
    WHERE usage_amount.user_id = $user_id");

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>View User Usage</title>
    <link rel="stylesheet" href="styles.css">
</head>
<body>
    <h2>Usage Details for: <?php echo htmlspecialchars($email); ?></h2>

    <table>
        <thead>
            <tr>
                <th>Service</th>
                <th>Usage Amount</th>
                <th>Total Cost</th>
            </tr>
        </thead>
        <tbody>
            <?php while ($usage = $usage_data->fetch_assoc()) { ?>
            <tr>
                <td><?php echo htmlspecialchars($usage['name']); ?></td>
                <td><?php echo htmlspecialchars($usage['usage_amount']); ?></td>
                <td>R <?php echo number_format($usage['total'], 2); ?></td>
            </tr>
            <?php } ?>
        </tbody>
    </table>

    <button onclick="window.history.back();">Back to Dashboard</button>
</body>
</html>

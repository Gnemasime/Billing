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
// Create a connection to the database
$conn = new mysqli($servername, $username, $password, $dbname);

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Fetch payments
$result = $conn->query("SELECT transactions.*, bills.service_type, users.first_name, users.last_name FROM transactions JOIN bills ON transactions.bill_id = bills.id JOIN users ON bills.resident_id = users.id");
?>

<?php include 'includes/header.php'; ?>
<?php include 'includes/navbar.php'; ?>

<!-- Main Content -->
<div class="main-content">
    <div class="container mt-4">
        <h2>Manage Payments</h2>
        <table class="table table-bordered">
            <thead>
                <tr>
                    <th>ID</th>
                    <th>User</th>
                    <th>Service Type</th>
                    <th>Payment Amount</th>
                    <th>Payment Date</th>
                </tr>
            </thead>
            <tbody>
                <?php while ($row = $result->fetch_assoc()) { ?>
                    <tr>
                        <td><?php echo $row['id']; ?></td>
                        <td><?php echo $row['first_name'] . ' ' . $row['last_name']; ?></td>
                        <td><?php echo $row['service_type']; ?></td>
                        <td>R <?php echo number_format($row['payment_amount'], 2); ?></td>
                        <td><?php echo $row['payment_date']; ?></td>
                    </tr>
                <?php } ?>
            </tbody>
        </table>
    </div>
</div>

<?php include 'includes/footer.php'; ?>

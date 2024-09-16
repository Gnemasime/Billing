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

// Query to fetch users and their water usage amounts
$sql = "
    SELECT 
        u.id AS user_id,
        u.first_name,
        u.last_name,
        u.meter_number,
        IFNULL(SUM(ua.amount_used), 0) AS total_usage_amount
    FROM users u
    LEFT JOIN bills b ON u.id = b.resident_id AND b.service_type = 'Water'
    LEFT JOIN usage_amount ua ON u.id = ua.user_id
    WHERE u.user_type = 'residential'
    GROUP BY u.id, u.first_name, u.last_name, u.meter_number
";
$result = $conn->query($sql);

if (!$result) {
    die("Error executing query: " . $conn->error);
}
?>

<?php include 'includes/header.php'; ?>
<?php include 'includes/navbar.php'; ?>

<!-- Main Content -->
<div class="main-content">
    <div class="container mt-4">
        <h2>Water Usage for All Users</h2>
        <table class="table table-bordered">
            <thead>
                <tr>
                    <th>User ID</th>
                    <th>First Name</th>
                    <th>Last Name</th>
                    <th>Meter Number</th>
                    <th>Total Usage Amount (L)</th>
                    <th>Actions</th>
                </tr>
            </thead>
            <tbody>
                <?php while ($row = $result->fetch_assoc()) { ?>
                    <tr>
                        <td><?php echo $row['user_id']; ?></td>
                        <td><?php echo $row['first_name']; ?></td>
                        <td><?php echo $row['last_name']; ?></td>
                        <td><?php echo $row['meter_number']; ?></td>
                        <td><?php echo number_format($row['total_usage_amount'], 2); ?></td>
                        <td>
                            <!-- Button to trigger modal -->
                            <button class="btn btn-primary btn-sm" data-bs-toggle="modal" data-bs-target="#editUsageModal<?php echo $row['user_id']; ?>">
                                Enter Usage
                            </button>
                        </td>
                    </tr>

                    <!-- Modal for entering usage amount -->
                    <div class="modal fade" id="editUsageModal<?php echo $row['user_id']; ?>" tabindex="-1" aria-labelledby="editUsageModalLabel<?php echo $row['user_id']; ?>" aria-hidden="true">
                        <div class="modal-dialog">
                            <div class="modal-content">
                                <div class="modal-header">
                                    <h5 class="modal-title" id="editUsageModalLabel<?php echo $row['user_id']; ?>">Enter Usage for <?php echo htmlspecialchars($row['first_name'] . ' ' . $row['last_name']); ?></h5>
                                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                </div>
                                <div class="modal-body">
                                    <form action="usage/enter_usage.php" method="POST">
                                        <input type="hidden" name="user_id" value="<?php echo $row['user_id']; ?>">
                                        <div class="mb-3">
                                            <label for="amount_used" class="form-label">Enter Water Usage (Litres):</label>
                                            <input type="number" class="form-control" id="amount_used" name="amount_used" required>
                                        </div>
                                        <button type="submit" class="btn btn-success">Save</button>
                                    </form>
                                </div>
                            </div>
                        </div>
                    </div>

                <?php } ?>
            </tbody>
        </table>
    </div>
</div>

<?php include 'includes/footer.php'; ?>

<?php
$conn->close();
?>

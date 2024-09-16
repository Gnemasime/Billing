<?php 
session_start();
if (!isset($_SESSION['role']) || $_SESSION['role'] != 'junioradmi') {
    header("Location: login.php");
    exit();
}

// Database connection
$servername = "sql110.infinityfree.com";
$username = "if0_37164635";
$password = "bd2xR7cX6JRK";
$dbname = "if0_37164635_municipal_billing";

// Create connection and check connection
$conn = new mysqli($servername, $username, $password, $dbname);
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Pagination logic
$limit = 10; // Number of records per page
$page = isset($_GET['page']) ? (int)$_GET['page'] : 1; // Get current page number
$offset = ($page - 1) * $limit; // Calculate the offset

// Fetch total number of records
$totalResult = $conn->query("SELECT COUNT(*) as total FROM bills");
$totalRows = $totalResult->fetch_assoc()['total'];
$totalPages = ceil($totalRows / $limit);

// Fetch bills with pagination
$result = $conn->query("
    SELECT bills.*, users.first_name, users.last_name 
    FROM bills 
    JOIN users ON bills.resident_id = users.id 
    LIMIT $limit OFFSET $offset
");
?>

<?php include 'includes/header.php'; ?>
<?php include 'includes/navbar.php'; ?>

<!-- Main Content -->
<div class="main-content">
    <div class="container mt-4">
        <h2>Manage Bills</h2>

        <!-- Button to trigger Add Bill page -->
        <a href="usage/add_bill.php" class="btn btn-primary mb-3"><i class="fa fa-money-bill-wave"></i> Add Bill</a>

        <table class="table table-bordered">
            <thead>
                <tr>
                    <th>ID</th>
                    <th>User</th>
                    <th>Service Type</th>
                    <th>Amount Due</th>
                    <th>Status</th>
                    <th>Due Date</th>
                    <th>Actions</th>
                </tr>
            </thead>
            <tbody>
                <?php while ($row = $result->fetch_assoc()) { ?>
                    <tr>
                        <td><?php echo htmlspecialchars($row['id']); ?></td>
                        <td><?php echo htmlspecialchars($row['first_name'] . ' ' . $row['last_name']); ?></td>
                        <td><?php echo htmlspecialchars($row['service_type']); ?></td>
                        <td>R <?php echo number_format($row['amount_due'], 2); ?></td>
                        <td><?php echo ucfirst(htmlspecialchars($row['status'])); ?></td>
                        <td><?php echo htmlspecialchars($row['due_date']); ?></td>
                        <td>
                            <a href="usage/edit_bill.php?id=<?php echo htmlspecialchars($row['id']); ?>" class="btn btn-sm btn-warning"><i class="fa fa-pencil-alt" aria-hidden="true"></i></a>
                            <a href="usage/delete_bill.php?id=<?php echo htmlspecialchars($row['id']); ?>" class="btn btn-sm btn-danger"><i class="fa fa-trash" aria-hidden="true"></i></a>
                        </td>
                    </tr>
                <?php } ?>
            </tbody>
        </table>

        <!-- Pagination Controls -->
        <nav aria-label="Page navigation">
            <ul class="pagination">
                <li class="page-item <?php if ($page <= 1) echo 'disabled'; ?>">
                    <a class="page-link" href="?page=<?php echo $page - 1; ?>">Previous</a>
                </li>
                <?php for ($i = 1; $i <= $totalPages; $i++) { ?>
                    <li class="page-item <?php if ($i == $page) echo 'active'; ?>">
                        <a class="page-link" href="?page=<?php echo $i; ?>"><?php echo $i; ?></a>
                    </li>
                <?php } ?>
                <li class="page-item <?php if ($page >= $totalPages) echo 'disabled'; ?>">
                    <a class="page-link" href="?page=<?php echo $page + 1; ?>">Next</a>
                </li>
            </ul>
        </nav>
    </div>
</div>

<?php include 'includes/footer.php'; ?>

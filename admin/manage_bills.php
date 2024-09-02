<?php
session_start();
if (!isset($_SESSION['role']) || $_SESSION['role'] != 'admin') {
    header("Location: ../login.php");
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

        <!-- Button to trigger Add Bill modal -->
        <button class="btn btn-primary mb-3" data-bs-toggle="modal" data-bs-target="#addBillModal"> <i class="fa fa-money-bill-wave"></i> Add Bill</button>

        <!-- Add Bill Modal -->
        <div class="modal fade" id="addBillModal" tabindex="-1" aria-labelledby="addBillModalLabel" aria-hidden="true">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="addBillModalLabel">Add New Bill</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        <form action="bills/add_bill.php" method="POST">
                            <div class="form-group">
                                <label for="resident_id">Resident:</label>
                                <select class="form-control" id="resident_id" name="resident_id" required>
                                    <?php
                                    // Fetch users for the dropdown
                                    $usersResult = $conn->query("SELECT id, CONCAT(first_name, ' ', last_name) AS name FROM users");
                                    while ($user = $usersResult->fetch_assoc()) {
                                        echo "<option value='" . $user['id'] . "'>" . $user['name'] . "</option>";
                                    }
                                    ?>
                                </select>
                            </div>
                            <div class="form-group">
                                <label for="service_type">Service Type:</label>
                                <select class="form-control" id="service_type" name="service_type" required>
                                    <option value="electricity">Electricity</option>
                                    <option value="water">Water</option>
                                </select>
                            </div>
                            <div class="form-group">
                                <label for="amount_due">Amount Due:</label>
                                <input type="number" step="0.01" class="form-control" id="amount_due" name="amount_due" required>
                            </div>
                            <div class="form-group">
                                <label for="status">Status:</label>
                                <select class="form-control" id="status" name="status" required>
                                    <option value="paid">Paid</option>
                                    <option value="unpaid">Unpaid</option>
                                    <option value="overdue">Overdue</option>
                                </select>
                            </div>
                            <div class="form-group">
                                <label for="due_date">Due Date:</label>
                                <input type="date" class="form-control" id="due_date" name="due_date" required>
                            </div>
                            <button type="submit" class="btn btn-primary"><i class="fa fa-file-invoice-dollar"></i> Add Bill</button>
                        </form>
                    </div>
                </div>
            </div>
        </div>

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
                        <td><?php echo $row['id']; ?></td>
                        <td><?php echo $row['first_name'] . ' ' . $row['last_name']; ?></td>
                        <td><?php echo $row['service_type']; ?></td>
                        <td>R <?php echo number_format($row['amount_due'], 2); ?></td>
                        <td><?php echo ucfirst($row['status']); ?></td>
                        <td><?php echo $row['due_date']; ?></td>
                        <td>
                            <button class="btn btn-sm btn-warning" data-bs-toggle="modal" data-bs-target="#editBillModal<?php echo $row['id']; ?>">Edit</button>
                            <button class="btn btn-sm btn-danger" data-bs-toggle="modal" data-bs-target="#deleteBillModal<?php echo $row['id']; ?>">Delete</button>
                        </td>
                    </tr>

                    <!-- Edit Bill Modal -->
                    <div class="modal fade" id="editBillModal<?php echo $row['id']; ?>" tabindex="-1" aria-labelledby="editBillModalLabel" aria-hidden="true">
                        <div class="modal-dialog">
                            <div class="modal-content">
                                <div class="modal-header">
                                    <h5 class="modal-title" id="editBillModalLabel">Edit Bill</h5>
                                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                </div>
                                <div class="modal-body">
                                    <form action="bills/edit_bill.php" method="POST">
                                        <input type="hidden" name="id" value="<?php echo $row['id']; ?>">
                                        <div class="form-group">
                                            <label for="service_type">Service Type:</label>
                                            <select class="form-control" id="service_type" name="service_type" required>
                                                <option value="electricity" <?php echo ($row['service_type'] == 'electricity') ? 'selected' : ''; ?>>Electricity</option>
                                                <option value="water" <?php echo ($row['service_type'] == 'water') ? 'selected' : ''; ?>>Water</option>
                                                <option value="sanitation" <?php echo ($row['service_type'] == 'sanitation') ? 'selected' : ''; ?>>Sanitation</option>
                                            </select>
                                        </div>
                                        <div class="form-group">
                                            <label for="amount_due">Amount Due:</label>
                                            <input type="number" step="0.01" class="form-control" id="amount_due" name="amount_due" value="<?php echo $row['amount_due']; ?>" required>
                                        </div>
                                        <div class="form-group">
                                            <label for="status">Status:</label>
                                            <select class="form-control" id="status" name="status" required>
                                                <option value="paid" <?php echo ($row['status'] == 'paid') ? 'selected' : ''; ?>>Paid</option>
                                                <option value="unpaid" <?php echo ($row['status'] == 'unpaid') ? 'selected' : ''; ?>>Unpaid</option>
                                                <option value="overdue" <?php echo ($row['status'] == 'overdue') ? 'selected' : ''; ?>>Overdue</option>
                                            </select>
                                        </div>
                                        <div class="form-group">
                                            <label for="due_date">Due Date:</label>
                                            <input type="date" class="form-control" id="due_date" name="due_date" value="<?php echo $row['due_date']; ?>" required>
                                        </div>
                                        <button type="submit" class="btn btn-primary">Save Changes</button>
                                    </form>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Delete Bill Modal -->
                    <div class="modal fade" id="deleteBillModal<?php echo $row['id']; ?>" tabindex="-1" aria-labelledby="deleteBillModalLabel" aria-hidden="true">
                        <div class="modal-dialog">
                            <div class="modal-content">
                                <div class="modal-header">
                                    <h5 class="modal-title" id="deleteBillModalLabel">Delete Bill</h5>
                                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                </div>
                                <div class="modal-body">
                                    <p>Are you sure you want to delete this bill?</p>
                                    <form action="bills/delete_bill.php" method="POST">
                                        <input type="hidden" name="id" value="<?php echo $row['id']; ?>">
                                        <button type="submit" class="btn btn-danger">Yes, Delete</button>
                                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                                    </form>
                                </div>
                            </div>
                        </div>
                    </div>
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

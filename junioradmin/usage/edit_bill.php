<?php
session_start();
if (!isset($_SESSION['role']) || $_SESSION['role'] != 'junioradmi') {
    header("Location: ../login.php");
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

$id = $_GET['id'];

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $service_type = $_POST['service_type'];
    $amount_due = $_POST['amount_due'];
    $status = $_POST['status'];
    $due_date = $_POST['due_date'];

    $stmt = $conn->prepare("UPDATE bills SET service_type = ?, amount_due = ?, status = ?, due_date = ? WHERE id = ?");
    $stmt->bind_param('ssssi', $service_type, $amount_due, $status, $due_date, $id);
    $stmt->execute();
    $stmt->close();

    header("Location: ../admin_dashboard.php"); // Redirect back to the main page
    exit();
}

$result = $conn->query("SELECT * FROM bills WHERE id = $id");
$row = $result->fetch_assoc();
?>

<?php include 'includes/header.php'; ?>
<?php include 'includes/navbar.php'; ?>

<!-- Main Content -->
<div class="main-content">
    <div class="container mt-4">
        <h2>Edit Bill</h2>
        <form action="edit_bill.php?id=<?php echo htmlspecialchars($row['id']); ?>" method="POST">
            <div class="form-group">
                <label for="service_type">Service Type:</label>
                <select class="form-control" id="service_type" name="service_type" required>
                    <option value="electricity" <?php echo ($row['service_type'] == 'electricity') ? 'selected' : ''; ?>>Electricity</option>
                    <option value="water" <?php echo ($row['service_type'] == 'water') ? 'selected' : ''; ?>>Water</option>
                </select>
            </div>
            <div class="form-group">
                <label for="amount_due">Amount Due:</label>
                <input type="number" step="0.01" class="form-control" id="amount_due" name="amount_due" value="<?php echo htmlspecialchars($row['amount_due']); ?>" required>
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
                <input type="date" class="form-control" id="due_date" name="due_date" value="<?php echo htmlspecialchars($row['due_date']); ?>" required>
            </div>
            <button type="submit" class="btn btn-primary">Save Changes</button>
        </form>
    </div>
</div>

<?php include 'includes/footer.php'; ?>

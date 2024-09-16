<?php
session_start();
if (!isset($_SESSION['role']) || $_SESSION['role'] != 'admin') {
    header("Location: ../admin_dashabord.php");
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

// Handle form submission
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $resident_id = $_POST['resident_id'];
    $service_type = $_POST['service_type'];
    $amount_due = $_POST['amount_due'];
    $status = $_POST['status'];
    $due_date = $_POST['due_date'];

    $stmt = $conn->prepare("INSERT INTO bills (resident_id, service_type, amount_due, status, due_date) VALUES (?, ?, ?, ?, ?)");
    $stmt->bind_param('sssss', $resident_id, $service_type, $amount_due, $status, $due_date);
    $stmt->execute();
    $stmt->close();

    header("Location: ../admin_dashboard.php"); // Redirect back to the main page
    exit();
}
?>

<?php include 'includes/header.php'; ?>
<?php include 'includes/navbar.php'; ?>

<!-- Main Content -->
<div class="main-content">
    <div class="container mt-4">
        <h2>Add New Bill</h2>
        <form action="" method="POST">
            <div class="form-group">
                <label for="resident_id">Resident:</label>
                <select class="form-control" id="resident_id" name="resident_id" required>
                    <?php
                    $usersResult = $conn->query("SELECT id, CONCAT(first_name, ' ', last_name) AS name FROM users");
                    while ($user = $usersResult->fetch_assoc()) {
                        echo "<option value='" . htmlspecialchars($user['id']) . "'>" . htmlspecialchars($user['name']) . "</option>";
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

<?php include 'includes/footer.php'; ?>

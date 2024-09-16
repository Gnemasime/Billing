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

// Create connection
$conn = new mysqli($servername, $username, $password, $dbname);
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

$id = $_GET['id'];
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $service_type = $_POST['service_type'];
    $usage_amount = $_POST['usage_amount'];
    $due_date = $_POST['due_date'];

    $stmt = $conn->prepare("UPDATE bills SET service_type = ?, usage_amount = ?, due_date = ? WHERE id = ?");
    $stmt->bind_param('sssi', $service_type, $usage_amount, $due_date, $id);
    $stmt->execute();
    $stmt->close();

    header("Location: index.php"); // Redirect back to the main page
    exit();
}

$result = $conn->query("SELECT * FROM bills WHERE id = $id");
$row = $result->fetch_assoc();
?>

<?php include '../includes/header.php'; ?>
<?php include '../includes/navbar.php'; ?>

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
                <label for="usage_amount">Usage Amount:</label>
                <input type="number" step="0.01" class="form-control" id="usage_amount" name="usage_amount" value="<?php echo htmlspecialchars($row['usage_amount']); ?>" required>
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

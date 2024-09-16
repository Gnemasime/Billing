<?php
session_start();
if (!isset($_SESSION['role']) || $_SESSION['role'] != 'junioradmi') {
    header("Location: login.php");
    exit();
}

// Database connection
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "municipal_billing";

// Create connection
$conn = new mysqli($servername, $username, $password, $dbname);
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

$id = $_GET['id'];
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $stmt = $conn->prepare("DELETE FROM bills WHERE id = ?");
    $stmt->bind_param('i', $id);
    $stmt->execute();
    $stmt->close();

    header("Location: ../manage_usage.php"); // Redirect back to the main page
    exit();
}
?>

<?php include 'includes/header.php'; ?>
<?php include 'includes/navbar.php'; ?>

<div class="main-content">
    <div class="container mt-4">
        <h2>Delete Usage</h2>
        <p>Are you sure you want to delete this usage record?</p>
        <form action="delete_bill.php?id=<?php echo htmlspecialchars($id); ?>" method="POST">
            <button type="submit" class="btn btn-danger">Yes, Delete</button>
            <a href="index.php" class="btn btn-secondary">Cancel</a>
        </form>
    </div>
</div>

<?php include 'includes/footer.php'; ?>

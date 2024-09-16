<?php
session_start();
if (!isset($_SESSION['role']) || $_SESSION['role'] != 'admin') {
    header("Location: login.php");
    exit();
}

// Settings logic can be added here.
?>

<?php include 'includes/header.php'; ?>
<?php include 'includes/navbar.php'; ?>

<!-- Main Content -->
<div class="main-content">
    <div class="container mt-4">
        <h2>Settings</h2>
        <p>Settings management feature coming soon!</p>
    </div>
</div>

<?php include 'includes/footer.php'; ?>

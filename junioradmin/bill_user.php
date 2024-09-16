<?php
// bill_user.php

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $user_id = $_POST['user_id'];
    $service_id = $_POST['service_type'];
    $amount_used = $_POST['amount_used'];

    // Fetch tariff rate
    $conn = new mysqli('localhost', 'username', 'password', 'municipal_billing');
    if ($conn->connect_error) {
        die("Connection failed: " . $conn->connect_error);
    }

    $result = $conn->query("SELECT rate FROM tariffs WHERE service_id = $service_id");
    $row = $result->fetch_assoc();
    $rate = $row['rate'];

    $amount_due = ($amount_used / $rate) * 100; // Adjust the formula as needed

    // Insert into bills
    $stmt = $conn->prepare("INSERT INTO bills (resident_id, service_type, amount_due, due_date) VALUES (?, ?, ?, ?)");
    $due_date = date('Y-m-d', strtotime('+1 month')); // Example due date
    $stmt->bind_param('isds', $user_id, $service_id, $amount_due, $due_date);

    if ($stmt->execute()) {
        $_SESSION['message'] = 'Bill created successfully!';
    } else {
        $error = 'Error creating bill: ' . $stmt->error;
    }

    $stmt->close();
    $conn->close();
    
    header('Location: bill_user.php');
    exit();
}
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="description" content="Bill User - Municipal Billing System">
    <meta name="author" content="Municipal Billing System">
    <title>Bill User</title>
    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <!-- Font Awesome CSS for Icons -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.1.1/css/all.min.css">
</head>

<body>

<?php include 'includes/header.php'; ?>
<?php include 'includes/navbar.php'; ?>

<!-- Main Content -->
<div class="container mt-4">
    <h2>Create a Bill <i class="fa fa-money-bill-wave"></i></h2> <!-- Added money icon next to the title -->

    <!-- Display Success or Error Message -->
    <?php if (isset($error)) { ?>
        <div class="alert alert-danger"><?php echo $error; ?></div>
    <?php } elseif (isset($_SESSION['message'])) { ?>
        <div class="alert alert-success"><?php echo $_SESSION['message']; unset($_SESSION['message']); ?></div>
    <?php } ?>

    <!-- Billing Form -->
    <form method="POST" action="bill_user.php">
        <div class="mb-3">
            <label for="user_id" class="form-label">Select User:</label>
            <select class="form-control" id="user_id" name="user_id" required>
                <option value="">-- Select User --</option>
                <?php
                // Fetch users from the database
                $conn = new mysqli('localhost', 'username', 'password', 'municipal_billing');
                if ($conn->connect_error) {
                    die("Connection failed: " . $conn->connect_error);
                }

                $result = $conn->query("SELECT id, CONCAT(first_name, ' ', last_name) AS name FROM users");
                while ($row = $result->fetch_assoc()) {
                    echo "<option value='" . $row['id'] . "'>" . $row['name'] . "</option>";
                }

                $conn->close();
                ?>
            </select>
        </div>

        <div class="mb-3">
            <label for="service_type" class="form-label">Service Type:</label>
            <select class="form-control" id="service_type" name="service_type" required>
                <?php
                // Fetch services from the database
                $conn = new mysqli('localhost', 'username', 'password', 'municipal_billing');
                if ($conn->connect_error) {
                    die("Connection failed: " . $conn->connect_error);
                }

                $result = $conn->query("SELECT id, name FROM services");
                while ($row = $result->fetch_assoc()) {
                    echo "<option value='" . $row['id'] . "'>" . $row['name'] . "</option>";
                }

                $conn->close();
                ?>
            </select>
        </div>

        <div class="mb-3">
            <label for="amount_used" class="form-label">
                <i class="fa fa-tint"></i> Amount Used (Litres/Units):
            </label>
            <input type="number" class="form-control" id="amount_used" name="amount_used" min="0" step="0.01" required>
        </div>

        <button type="submit" class="btn btn-primary">
            <i class="fa fa-file-invoice-dollar"></i> Create Bill
        </button> <!-- Added icon to button -->
    </form>
</div>

<?php include 'includes/footer.php'; ?>

<!-- Bootstrap JS and dependencies -->
<script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.11.6/dist/umd/popper.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>

</html>

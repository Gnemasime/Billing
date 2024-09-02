<?php
session_start();

// Check if the user is logged in
if (!isset($_SESSION['user_id'])) {
    header("Location: index.php");
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
$dbname = "if0_37164635_municipal_billing";*/
$conn = new mysqli($servername, $username, $password, $dbname);

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Fetch bills for the logged-in user
$user_id = $_SESSION['user_id'];
$email = $_SESSION['email'];

// Use prepared statements to prevent SQL injection
$sql = "SELECT id, service_type, amount_due, due_date, status FROM bills WHERE resident_id = ?";
$stmt = $conn->prepare($sql);
$stmt->bind_param("i", $user_id);
$stmt->execute();
$result = $stmt->get_result();
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="description" content="Municipal Billing System">
    <meta name="author" content="Your Name">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Roboto:wght@400;500;700&display=swap" rel="stylesheet">
    <title>Pay Your Bills</title>
    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <!-- FontAwesome Icons -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
    <!-- Custom CSS -->
    <style>
        body {
            font-family: 'Roboto', sans-serif;
            background: linear-gradient(135deg, #00c6ff, #0072ff);
            color: #333;
            padding: 0;
            margin: 0;
        }

        .navbar {
            background: rgba(0, 86, 179, 0.7);
            box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
        }

        .navbar .navbar-brand {
            color: #fff;
        }

        .navbar .navbar-nav .nav-link {
            color: #fff;
        }

        .navbar .navbar-nav .nav-link:hover {
            color: #f8f9fa;
        }

        .container-fluid {
            padding: 20px;
        }

        .profile-container {
            max-width: 700px;
            margin: 0 auto;
            background: rgba(255, 255, 255, 0.1);
            border-radius: 10px;
            backdrop-filter: blur(10px);
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
            padding: 20px;
            text-align: center;
            margin-top: 20px;
        }

        .profile-container h2 {
            margin-bottom: 50px;
            color: #0056b3;
        }
    </style>
</head>

<body>
    <!-- Header -->
    <nav class="navbar navbar-expand-lg navbar-dark">
        <div class="container-fluid">
            <a class="navbar-brand" href="#">Municipal Billing System</a>
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse" id="navbarNav">
                <ul class="navbar-nav ms-auto">
                    <li class="nav-item">
                        <a class="nav-link" href="dashboard.php">Dashboard</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link active" href="profile.php">Profile</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="logout.php">Logout</a>
                    </li>
                </ul>
            </div>
        </div>
    </nav>

    <!-- Main Content -->
    <div class="container profile-container">
        <h2>Welcome, <?= htmlspecialchars($email) ?></h2>
        <p>Pay your bills, track your payments, and view your account details.</p>

        <?php if ($result->num_rows > 0) : ?>
            <h3>Your Bills</h3>
            <table class="table table-striped">
                <thead>
                    <tr>
                        <th>Service Type</th>
                        <th>Amount Due</th>
                        <th>Due Date</th>
                        <th>Status</th>
                        <th>Action</th>
                    </tr>
                </thead>
                <tbody>
                    <?php while ($row = $result->fetch_assoc()) : ?>
                        <tr>
                            <td><?= htmlspecialchars($row['service_type']) ?></td>
                            <td>R <?= htmlspecialchars($row['amount_due']) ?></td>
                            <td><?= htmlspecialchars($row['due_date']) ?></td>
                            <td><?= ucfirst(htmlspecialchars($row['status'])) ?></td>
                            <td>
                                <?php if ($row['status'] == 'unpaid') : ?>
                                    <!-- Redirect to the pay_bill.php page with bill details -->
                                    <a href="pay_bill.php?bill_id=<?= $row['id'] ?>" class="btn btn-sm btn-success">Pay Now</a>
                                <?php else : ?>
                                    <span class="text-muted">Paid</span>
                                <?php endif; ?>
                            </td>
                        </tr>
                    <?php endwhile; ?>
                </tbody>
            </table>
        <?php else : ?>
            <p class="text-center">No bills found for your account.</p>
        <?php endif; ?>

        <?php
        $stmt->close();
        $conn->close();
        ?>
    </div>

    <!-- Bootstrap JS and dependencies -->
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.11.6/dist/umd/popper.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>

</html>

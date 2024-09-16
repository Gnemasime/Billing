<?php
session_start();

// Check if the user is logged in
if (!isset($_SESSION['user_id'])) {
    header("Location: login.php");
    exit();
}

// Database connection
$servername = "sql110.infinityfree.com";
$username = "if0_37164635";
$password = "bd2xR7cX6JRK";
$dbname = "if0_37164635_municipal_billing";

// Create a connection to the database
$conn = new mysqli($servername, $username, $password, $dbname);
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

$user_id = $_SESSION['user_id'];

// Fetch user details
$stmt = $conn->prepare("SELECT email, id_number, first_name, last_name, role, date_of_birth, city, postcode, state FROM users WHERE id = ?");
$stmt->bind_param("i", $user_id);
$stmt->execute();
$stmt->bind_result($email, $id_number, $first_name, $last_name, $role, $date_of_birth, $city, $postcode, $state);
$stmt->fetch();
$stmt->close();
$conn->close();
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="description" content="Profile - Municipal Billing System">
    <meta name="author" content="Municipal Billing System">
    <title>Profile</title>
    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <!-- Font Awesome -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.1.1/css/all.min.css">
    <!-- Custom CSS -->
    <style>
        body {
            font-family: Arial, sans-serif;
            background: linear-gradient(135deg, #003366, #000000);
            color: #fff;
            padding: 0;
            margin: 0;
        }

        .navbar {
            background: rgba(0, 86, 179, 0.7);
            backdrop-filter: blur(10px);
            box-shadow: 0 4px 6px rgba(0, 0, 0, 0.2);
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
            background: #1a1a1a;
            border-radius: 10px;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.3);
            padding: 20px;
            text-align: center;
            margin-top: 20px;
        }

        .profile-container h2 {
            margin-bottom: 20px;
            color: #007bff;
        }

        .profile-container .profile-image {
            margin-bottom: 20px;
        }

        .profile-container img {
            border-radius: 50%;
            width: 100px;
            height: 100px;
            border: 3px solid #007bff;
        }

        .profile-container .info {
            margin-bottom: 10px;
            text-align: left;
            padding: 0 10px;
        }

        .profile-container .info strong {
            display: inline-block;
            width: 150px;
            color: #007bff;
        }

        .profile-container .btn-primary {
            background-color: #007bff;
            border: none;
            margin: 5px;
            transition: background 0.3s;
        }

        .profile-container .btn-primary:hover {
            background-color: #0056b3;
        }
    </style>
</head>

<body>
    <!-- Navbar -->
    <nav class="navbar navbar-expand-lg navbar-dark">
        <div class="container-fluid">
            <a class="navbar-brand" href="home.php">Municipal Billing System</a>
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse" id="navbarNav">
                <ul class="navbar-nav ms-auto">
                    <li class="nav-item">
                        <a class="nav-link" href="dashboard.php"><i class="fas fa-home"></i> Dashboard</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link active" href="profile.php"><i class="fas fa-user"></i> Profile</a>
                    </li>
                    <li class="nav-item dropdown">
                        <a class="nav-link dropdown-toggle" href="#" id="navbarDropdown" role="button" data-bs-toggle="dropdown" aria-expanded="false">
                            <i class="fas fa-briefcase"></i> Bills
                        </a>
                        <ul class="dropdown-menu" aria-labelledby="navbarDropdown">
                            <li><a class="dropdown-item" href="electricity_bills.php">Electricity</a></li>
                            <li><a class="dropdown-item" href="water_bills.php">Water</a></li>
                        </ul>
                    </li>
                    <li class="nav-item dropdown">
                        <a class="nav-link dropdown-toggle" href="#" id="navbarDropdown" role="button" data-bs-toggle="dropdown" aria-expanded="false">
                            <i class="fas fa-newspaper"></i> News
                        </a>
                        <ul class="dropdown-menu" aria-labelledby="navbarDropdown">
                            <li><a class="dropdown-item" href="electricity_news.php">Electricity</a></li>
                            <li><a class="dropdown-item" href="water_news.php">Water</a></li>
                            <li><a class="dropdown-item" href="loadshedding.php">Loadshedding</a></li>
                        </ul>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="logout.php"><i class="fas fa-sign-out-alt"></i> Logout</a>
                    </li>
                </ul>
            </div>
        </div>
    </nav>

    <!-- Profile Container -->
    <div class="container-fluid">
        <div class="profile-container">
            <div class="profile-image">
                <img src="https://via.placeholder.com/100" alt="User Image">
            </div>
            <h2><?= htmlspecialchars($first_name) . ' ' . htmlspecialchars($last_name) ?></h2>
            <div class="info">
                <strong>Email:</strong> <?= htmlspecialchars($email) ?>
            </div>
            <div class="info">
                <strong>ID Number:</strong> <?= htmlspecialchars($id_number) ?>
            </div>
            <div class="info">
                <strong>Role:</strong> <?= htmlspecialchars($role) ?>
            </div>
            <div class="info">
                <strong>Date of Birth:</strong> <?= htmlspecialchars($date_of_birth) ?>
            </div>
            <div class="info">
                <strong>City:</strong> <?= htmlspecialchars($city) ?>
            </div>
            <div class="info">
                <strong>Postcode:</strong> <?= htmlspecialchars($postcode) ?>
            </div>
            <div class="info">
                <strong>State:</strong> <?= htmlspecialchars($state) ?>
            </div>
            <a href="edit_profile.php" class="btn btn-primary">Update Profile</a>
        </div>
    </div>

    <!-- Scripts -->
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.11.6/dist/umd/popper.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.min.js"></script>
</body>

</html>

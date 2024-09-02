<?php
session_start();
if (!isset($_SESSION['user_id'])) {
    header("Location: login.php");
    exit();
}

// Database connection
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "municipal_billing";

$conn = new mysqli($servername, $username, $password, $dbname);

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

$user_id = $_SESSION['user_id'];

// Fetch user details
$stmt = $conn->prepare("SELECT email, id_number, first_name, last_name, role, meter_number FROM users WHERE id = ?");
$stmt->bind_param("i", $user_id);
$stmt->execute();
$stmt->bind_result($email, $id_number, $first_name, $last_name, $role, $meter);
$stmt->fetch();
$stmt->close();
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
            background: linear-gradient(135deg, #00c6ff, #0072ff);
            color: #333;
            padding: 0;
            margin: 0;
        }

        .navbar {
            background: rgba(0, 86, 179, 0.7);
            backdrop-filter: blur(10px);
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
            backdrop-filter: blur(15px);
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
            padding: 20px;
            text-align: center;
            margin-top: 20px;
        }

        .profile-container h2 {
            margin-bottom: 20px;
            color: #0056b3;
        }

        .profile-container .profile-image {
            margin-bottom: 20px;
        }

        .profile-container img {
            border-radius: 50%;
            width: 100px;
            height: 100px;
            border: 3px solid #0056b3;
        }

        .profile-container .info {
            margin-bottom: 10px;
            text-align: left;
            padding: 0 10px;
        }

        .profile-container .info strong {
            display: inline-block;
            width: 150px;
            color: #0056b3;
        }

        .profile-container .btn-primary {
            background-color: #0056b3;
            border: none;
            margin: 5px;
            transition: background 0.3s;
        }

        .profile-container .btn-primary:hover {
            background-color: #004494;
        }

        .popup-overlay {
            position: fixed;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            background: rgba(0, 0, 0, 0.7);
            display: none;
            justify-content: center;
            align-items: center;
        }

        .popup {
            background: rgba(255, 255, 255, 0.2);
            backdrop-filter: blur(10px);
            padding: 20px;
            border-radius: 10px;
            width: 90%;
            max-width: 400px;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.2);
        }

        .popup h3 {
            margin-bottom: 15px;
            color: #333;
        }

        .popup .btn-close {
            background: #007bff;
            color: #fff;
            border: none;
            border-radius: 5px;
            padding: 5px 10px;
            cursor: pointer;
            transition: background 0.3s;
        }

        .popup .btn-close:hover {
            background: #0056b3;
        }
    </style>
</head>

<body>

    <!-- Navbar -->
    <nav class="navbar navbar-expand-lg navbar-dark">
        <div class="container-fluid">
            <a class="navbar-brand" href="#">Municipal Billing System</a>
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav"
                aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
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
                <strong>Meter Number:</strong> <?= htmlspecialchars($meter) ?>
            </div>
            <button class="btn btn-primary" id="updateProfileBtn">Update Profile</button>
            <button class="btn btn-primary" id="changePasswordBtn">Change Password</button>
        </div>
    </div>

    <!-- Update Profile Popup -->
    <div class="popup-overlay" id="updateProfilePopup">
        <div class="popup">
            <h3 style="color:white">Update Profile</h3>
            <form action="update_profile.php" method="post" style="color:white">
                <div class="mb-3">
                    <label for="first_name" class="form-label">First Name:</label>
                    <input type="text" class="form-control" id="first_name" name="first_name"
                        value="<?= htmlspecialchars($first_name) ?>" required>
                </div>
                <div class="mb-3">
                    <label for="last_name" class="form-label">Last Name:</label>
                    <input type="text" class="form-control" id="last_name" name="last_name"
                        value="<?= htmlspecialchars($last_name) ?>" required>
                </div>
                <div class="mb-3">
                    <label for="email" class="form-label">Email:</label>
                    <input type="email" class="form-control" id="email" name="email"
                        value="<?= htmlspecialchars($email) ?>" required>
                </div>
                <div class="mb-3">
                    <label for="meter_number" class="form-label">Meter Number:</label>
                    <input type="text" class="form-control" id="meter_number" name="meter_number"
                        value="<?= htmlspecialchars($meter) ?>" required>
                </div>
                <button type="submit" class="btn btn-primary">Save Changes</button>
                <button type="button" class="btn-close" id="closeUpdateProfilePopup">Close</button>
            </form>
        </div>
    </div>

    <!-- Change Password Popup -->
    <div class="popup-overlay" id="changePasswordPopup">
        <div class="popup">
            <h3 style="color:white">Change Password</h3>
            <form action="change_password.php" method="post" style="color:white">
                <div class="mb-3">
                    <label for="currentPassword" class="form-label">Current Password:</label>
                    <input type="password" class="form-control" id="currentPassword" name="current_password" required>
                </div>
                <div class="mb-3">
                    <label for="newPassword" class="form-label">New Password:</label>
                    <input type="password" class="form-control" id="newPassword" name="new_password" required>
                </div>
                <button type="submit" class="btn btn-primary">Change Password</button>
                <button type="button" class="btn-close" id="closeChangePasswordPopup">Close</button>
            </form>
        </div>
    </div>

    <!-- Scripts -->
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.11.6/dist/umd/popper.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.min.js"></script>

    <!-- Custom Script for Popups -->
    <script>
        document.getElementById("updateProfileBtn").addEventListener("click", function () {
            document.getElementById("updateProfilePopup").style.display = "flex";
        });

        document.getElementById("changePasswordBtn").addEventListener("click", function () {
            document.getElementById("changePasswordPopup").style.display = "flex";
        });

        document.getElementById("closeUpdateProfilePopup").addEventListener("click", function () {
            document.getElementById("updateProfilePopup").style.display = "none";
        });

        document.getElementById("closeChangePasswordPopup").addEventListener("click", function () {
            document.getElementById("changePasswordPopup").style.display = "none";
        });
    </script>
</body>

</html>

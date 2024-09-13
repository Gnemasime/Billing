<?php
session_start();
if (!isset($_SESSION['user_id'])) {
    header("Location: login.php");
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
$conn = new mysqli($servername, $username, $password, $dbname);

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

$user_id = $_SESSION['user_id'];

// Fetch user details including new fields
$stmt = $conn->prepare("SELECT email, id_number, first_name, last_name, role, date_of_birth, city, postcode, state FROM users WHERE id = ?");
$stmt->bind_param("i", $user_id);
$stmt->execute();
$stmt->bind_result($email, $id_number, $first_name, $last_name, $role,  $date_of_birth, $city, $postcode, $state);
$stmt->fetch();
$stmt->close();

// Check if the form was submitted
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Collect form data if the form was submitted
    $first_name = isset($_POST['first_name']) ? $_POST['first_name'] : $first_name;
    $last_name = isset($_POST['last_name']) ? $_POST['last_name'] : $last_name;
    $email = isset($_POST['email']) ? $_POST['email'] : $email;
    $id_number = isset($_POST['id_number']) ? $_POST['id_number'] : $id;
    $date_of_birth = isset($_POST['date_of_birth']) ? $_POST['date_of_birth'] : $date_of_birth;
    $city = isset($_POST['city']) ? $_POST['city'] : $city;
    $postcode = isset($_POST['postcode']) ? $_POST['postcode'] : $postcode;
    $state = isset($_POST['state']) ? $_POST['state'] : $state;

    // Update user details
    $stmt = $conn->prepare("UPDATE users SET first_name = ?, last_name = ?, email = ?, meter_number = ?, date_of_birth = ?, city = ?, postcode = ?, state = ? WHERE id = ?");
    $stmt->bind_param("ssssssssi", $first_name, $last_name, $email, $meter_number, $date_of_birth, $city, $postcode, $state, $user_id);
    $stmt->execute();
    $stmt->close();

    header("Location: profile.php");
    exit();
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="description" content="Edit Profile - Municipal Billing System">
    <meta name="author" content="Municipal Billing System">
    <title>Edit Profile</title>
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

        .edit-profile-container {
            max-width: 700px;
            margin: 0 auto;
            background: white;
            border-radius: 10px;
            backdrop-filter: blur(15px);
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
            padding: 20px;
            margin-top: 20px;
        }

        .edit-profile-container h2 {
            margin-bottom: 20px;
            color: #0056b3;
        }

        .form-control {
            width: 100%;
        }

        .btn-primary {
            background-color: #0056b3;
            border: none;
            margin: 5px;
            transition: background 0.3s;
        }

        .btn-primary:hover {
            background-color: #004494;
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
           <i class="fas fa-newspaper"></i>News
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

    <!-- Edit Profile Container -->
    <div class="container-fluid">
        <div class="edit-profile-container">
            <h2>Edit Profile</h2>
            <form action="update_profile.php" method="post">
                <div class="mb-3">
                    <label for="first_name" class="form-label">First Name:</label>
                    <input type="text" class="form-control" id="first_name" name="first_name" value="<?= htmlspecialchars($first_name) ?>" required>
                </div>
                <div class="mb-3">
                    <label for="last_name" class="form-label">Last Name:</label>
                    <input type="text" class="form-control" id="last_name" name="last_name" value="<?= htmlspecialchars($last_name) ?>" required>
                </div>
                <div class="mb-3">
                    <label for="email" class="form-label">Email:</label>
                    <input type="email" class="form-control" id="email" name="email" value="<?= htmlspecialchars($email) ?>" required>
                </div>
                <div class="mb-3">
                    <label for="meter_number" class="form-label">ID Number:</label>
                    <input type="text" class="form-control" id="meter_number" name="id_number" value="<?= htmlspecialchars($id_number) ?>" required>
                </div>
                <div class="mb-3">
                    <label for="date_of_birth" class="form-label">Date of Birth:</label>
                    <input type="date" class="form-control" id="date_of_birth" name="date_of_birth" value="<?= htmlspecialchars($date_of_birth) ?>" required>
                </div>
                <div class="mb-3">
                    <label for="city" class="form-label">City:</label>
                    <input type="text" class="form-control" id="city" name="city" value="<?= htmlspecialchars($city) ?>" required>
                </div>
                <div class="mb-3">
                    <label for="postcode" class="form-label">Postcode:</label>
                    <input type="text" class="form-control" id="postcode" name="postcode" value="<?= htmlspecialchars($postcode) ?>" required>
                </div>
                <div class="mb-3">
                    <label for="state" class="form-label">State:</label>
                    <select class="form-control" id="state" name="state" required>
                        <option value="" disabled>Select State</option>
                        <option value="Gauteng" <?= $state == 'Gauteng' ? 'selected' : '' ?>>Gauteng</option>
                        <option value="KwaZulu-Natal" <?= $state == 'KwaZulu-Natal' ? 'selected' : '' ?>>KwaZulu-Natal</option>
                        <option value="Western Cape" <?= $state == 'Western Cape' ? 'selected' : '' ?>>Western Cape</option>
                        <option value="Eastern Cape" <?= $state == 'Eastern Cape' ? 'selected' : '' ?>>Eastern Cape</option>
                        <option value="Limpopo" <?= $state == 'Limpopo' ? 'selected' : '' ?>>Limpopo</option>
                        <option value="Mpumalanga" <?= $state == 'Mpumalanga' ? 'selected' : '' ?>>Mpumalanga</option>
                        <option value="North West" <?= $state == 'North West' ? 'selected' : '' ?>>North West</option>
                        <option value="Free State" <?= $state == 'Free State' ? 'selected' : '' ?>>Free State</option>
                        <option value="Northern Cape" <?= $state == 'Northern Cape' ? 'selected' : '' ?>>Northern Cape</option>
                    </select>
                </div>
                <button type="submit" class="btn btn-primary">Save Changes</button>
            </form>
        </div>
    </div>

    <!-- Scripts -->
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.11.6/dist/umd/popper.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.min.js"></script>
</body>

</html>

<?php
// Database connection

$servername = '127.0.0.1';
$dbname = 'municipal_billing';
$username = 'root'; // your database username
$password = '';     // your database password

/*
$servername = "sql110.infinityfree.com";
$username = "if0_37164635";
$password = "bd2xR7cX6JRK";
$dbname = "if0_37164635_municipal_billing";

*/
// Create a connection to the database
$conn = new mysqli($servername, $username, $password, $dbname);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Ensure the user is authenticated
session_start();
if (!isset($_SESSION['user_id'])) {
    header("Location: login.php");
    exit();
}

$user_id = $_SESSION['user_id'];
$email = $_SESSION['email'];

// Fetching data
function fetchData($conn, $user_id, $status = null) {
    $query = "SELECT COUNT(*) AS count FROM bills WHERE resident_id = ?";
    if ($status) {
        $query .= " AND status = ?";
    }

    $stmt = $conn->prepare($query);
    if ($status) {
        $stmt->bind_param('is', $user_id, $status);
    } else {
        $stmt->bind_param('i', $user_id);
    }
    $stmt->execute();
    $result = $stmt->get_result();
    $row = $result->fetch_assoc();
    $stmt->close();

    return $row['count'];
}

$unpaidCount = fetchData($conn, $user_id, 'unpaid');
$paidCount = fetchData($conn, $user_id, 'paid');
$overdueCount = fetchData($conn, $user_id, 'overdue');
$transactionsCount = fetchData($conn, $user_id);

$conn->close();

// Colors
$colors = [
    '#FF6347', '#FF4500', '#FFD700', '#32CD32', '#00FA9A', 
    '#00BFFF', '#1E90FF', '#4682B4', '#6A5ACD', '#8A2BE2'
];

// Shuffle colors
shuffle($colors);
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
            font-weight: bold;
        }

        .navbar .navbar-nav .nav-link {
            color: #fff;
            font-size : 1.1em;
        }

        .navbar .navbar-nav .nav-link:hover {
            color: #f8f9fa;
        }

        .container-fluid {
            padding: 20px;
        }

        .profile-container {
            max-width: 1000px;
            margin: 0 auto;
            background: white;
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
        .container {
            width: 60%;
            
            overflow: hidden;
        }
        .card {
            background-color: #E6E6FA; /* Lavender */
            padding: 20px;
            margin: 20px 0;
            border-radius: 5px;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
        }
        .card h2 {
            margin: 0;
        }
        .card p {
            font-size: 1.5em;
            margin: 0;
        }
        .card:nth-child(1) { background-color: <?php echo $colors[0]; ?>; }
        .card:nth-child(2) { background-color: <?php echo $colors[1]; ?>; }
        .card:nth-child(3) { background-color: <?php echo $colors[2]; ?>; }
        .card:nth-child(4) { background-color: <?php echo $colors[3]; ?>; }
        .card:nth-child(5) { background-color: <?php echo $colors[4]; ?>; }
        .card:nth-child(6) { background-color: <?php echo $colors[5]; ?>; }
        .card:nth-child(7) { background-color: <?php echo $colors[6]; ?>; }
        .card:nth-child(8) { background-color: <?php echo $colors[7]; ?>; }
        .card:nth-child(9) { background-color: <?php echo $colors[8]; ?>; }
        .card:nth-child(10) { background-color: <?php echo $colors[9]; ?>; }

    </style>
</head>

<body>
    <!-- Header -->
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

    <!-- Main Content -->
    <div class="container profile-container"><br>
        <h2>Welcome, <?= htmlspecialchars($email) ?></h2>
        <p>Pay your bills, track your payments, and view your account details.</p>
        <hr><br>
     
        <div class="container">
        <div class="card">
            <h2>Unpaid Bills</h2>
            <p><?php echo $unpaidCount; ?></p>
        </div>
        <div class="card">
            <h2>Paid Bills</h2>
            <p><?php echo $paidCount; ?></p>
        </div>
        <div class="card">
            <h2>Overdue Bills</h2>
            <p><?php echo $overdueCount; ?></p>
        </div>
        <div class="card">
            <h2>Transactions</h2>
            <p><?php echo $transactionsCount; ?></p>
        </div>
    </div>
   
   
    <!-- Bootstrap JS and dependencies -->
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.11.6/dist/umd/popper.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    <script src="assets/js/shuffle.js"></script>
</body>

</html>

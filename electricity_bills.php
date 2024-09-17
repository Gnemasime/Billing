<?php
// Start session to retrieve logged-in user data
session_start();

// Check if user is logged in, redirect to login page if not
if (!isset($_SESSION['user_id'])) {
    header("Location: login.php");
    exit();
}

// Database connection details

$servername = "localhost";
$username = "root";
$password = "";
$dbname = "municipal_billing";

/*
$servername = "sql110.infinityfree.com";
$username = "if0_37164635";
$password = "bd2xR7cX6JRK";
$dbname = "if0_37164635_municipal_billing";
*/
// Create connection
$conn = new mysqli($servername, $username, $password, $dbname);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Get the current user ID from the session
$user_id = $_SESSION['user_id'];
$email = $_SESSION['email'];
// Initialize status filter and page number
$status_filter = isset($_GET['status']) ? $_GET['status'] : 'all';
$page = isset($_GET['page']) ? (int)$_GET['page'] : 1;
$records_per_page = 10;
$offset = ($page - 1) * $records_per_page;

// Base query to select electricity bills for the current user with pagination
$sql = "SELECT * FROM bills WHERE resident_id = ? AND service_type = 'electricity'";

// Append status filter if selected
if ($status_filter !== 'all') {
    $sql .= " AND status = ?";
}

// Prepare statement
if ($status_filter !== 'all') {
    $stmt = $conn->prepare($sql . " LIMIT ?, ?");
    $stmt->bind_param("isii", $user_id, $status_filter, $offset, $records_per_page);
} else {
    $stmt = $conn->prepare($sql . " LIMIT ?, ?");
    $stmt->bind_param("iii", $user_id, $offset, $records_per_page);
}

// Execute the query
$stmt->execute();
$result = $stmt->get_result();

// Get the total number of electricity bills for pagination
$sql_total = "SELECT COUNT(*) AS total FROM bills WHERE resident_id = ? AND service_type = 'electricity'";
if ($status_filter !== 'all') {
    $sql_total .= " AND status = ?";
    $stmt_total = $conn->prepare($sql_total);
    $stmt_total->bind_param("is", $user_id, $status_filter);
} else {
    $stmt_total = $conn->prepare($sql_total);
    $stmt_total->bind_param("i", $user_id);
}
$stmt_total->execute();
$total_result = $stmt_total->get_result()->fetch_assoc();
$total_records = $total_result['total'];
$total_pages = ceil($total_records / $records_per_page);

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
            font-weight : bold;
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

        table {
            width: 100%;
            border-collapse: collapse;
            margin: 20px 0;
            font-size: 18px;
            text-align: left;
            
        }
        table th, table td {
            padding: 12px;
            border: 1px solid #ddd;
        }
        table th {
            background-color: #f2f2f2;
        }
        table tr:hover {
            background-color: #f1f1f1;
        }
        .no-bills {
            text-align: center;
            font-size: 20px;
            color: #888;
        }
        select {
            padding: 8px;
            font-size: 16px;
            margin-left: 10px;
        }
        button {
            padding: 8px 12px;
            font-size: 16px;
            cursor: pointer;
        }
        .pagination {
            text-align: center;
            margin-top: 20px;
        }
        .pagination a {
            color: #333;
            text-decoration: none;
            margin: 0 10px;
            padding: 8px 16px;
            border: 1px solid #ddd;
            background-color: #f2f2f2;
        }
        .pagination a:hover {
            background-color: #ddd;
        }
        .pagination .current-page {
            background-color: #333;
            color: white;
        }

        footer {
            background-color: rgba(0, 86, 179, 0.7);
            color: #fff;
            padding: 10px;
            text-align: center;
            position: fixed;
            width: 100%;
            bottom: 0;
            box-shadow: 0 -4px 6px rgba(0, 0, 0, 0.1);
        }
    </style>
</head>

<body>
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
        <div class="filter">
        <form method="GET" action="">
            <label for="status">Filter by Status:</label>
            <select name="status" id="status" onchange="this.form.submit()">
                <option value="all" <?php if($status_filter == 'all') echo 'selected'; ?>>All</option>
                <option value="paid" <?php if($status_filter == 'paid') echo 'selected'; ?>>Paid</option>
                <option value="unpaid" <?php if($status_filter == 'unpaid') echo 'selected'; ?>>Unpaid</option>
                <option value="overdue" <?php if($status_filter == 'overdue') echo 'selected'; ?>>Overdue</option>
            </select>
        </form>
    </div>
    <?php
    if ($result->num_rows > 0) {
        echo "<table>";
        echo "<tr><th>ID</th><th>Service Type</th><th>Amount Due</th><th>Due Date</th><th>Status</th><th>Created At</th><th>Action</th></tr>";
        while ($row = $result->fetch_assoc()) {
            echo "<tr>";
            echo "<td>" . $row['id'] . "</td>";
            echo "<td>" . ucfirst($row['service_type']) . "</td>"; // Capitalize first letter
            echo "<td>R" . number_format($row['amount_due'], 2) . "</td>";
            echo "<td>" . $row['due_date'] . "</td>";
            echo "<td>" . ucfirst($row['status']) . "</td>"; // Capitalize first letter
            echo "<td>" . $row['created_at'] . "</td>";
            // If the bill is unpaid or overdue, show the "Pay" button
            if ($row['status'] === 'unpaid' || $row['status'] === 'overdue') {
                echo "<td><a href='pay_bill.php?bill_id=" . $row['id'] . "' class='btn btn-success'>Pay Now</a></td>";
             } else {
            echo "<td>Paid</td>";
             }
            echo "</tr>";
        }
        echo "</table>";
    } else {
        echo "<p class='no-bills'>No electricity bills found for your account.</p>";
    }
  // Pagination links
  if ($total_pages > 1) {
    echo '<div class="pagination">';
    if ($page > 1) {
        echo '<a href="?status=' . $status_filter . '&page=' . ($page - 1) . '">Previous</a>';
    }
    for ($i = 1; $i <= $total_pages; $i++) {
        if ($i == $page) {
            echo '<a class="current-page">' . $i . '</a>';
        } else {
            echo '<a href="?status=' . $status_filter . '&page=' . $i . '">' . $i . '</a>';
        }
    }
    if ($page < $total_pages) {
        echo '<a href="?status=' . $status_filter . '&page=' . ($page + 1) . '">Next</a>';
    }
    echo '</div>';
}

    // Close the connection
    $conn->close();
    ?>
</div>

 <!-- Bootstrap JS and dependencies -->
 <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.11.6/dist/umd/popper.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>

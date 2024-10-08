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
$dbname = "if0_37164635_municipal_billing";
*/
$conn = new mysqli($servername, $username, $password, $dbname);

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Get the bill details from the URL
$bill_id = isset($_GET['bill_id']) ? intval($_GET['bill_id']) : 0;
$user_id = $_SESSION['user_id'];

// Fetch the bill details using the bill ID and user ID
$stmt = $conn->prepare("SELECT service_type, amount_due, due_date FROM bills WHERE id = ? AND resident_id = ?");
$stmt->bind_param("ii", $bill_id, $user_id);
$stmt->execute();
$stmt->bind_result($service_type, $amount_due, $due_date);
$stmt->fetch();
$stmt->close();

if (!$service_type) {
    // Redirect to profile if the bill is not found or does not belong to the user
    header("Location: dashboard.php");
    exit();
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="description" content="Pay Bill - Municipal Billing System">
    <meta name="author" content="Municipal Billing System">
    <title>Pay Bill</title>
     <!-- FontAwesome Icons -->
     <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
    
    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <!-- PayPal SDK with South African Rand (ZAR) -->
    <script src="https://www.paypal.com/sdk/js?client-id=AdXHEP1jTg0J_HDMelGoKzkmXiJqg65ZVFa8ibAfReLDAq0XecE9z0bGuVfNjLFHtIxOkd-0Mr142NJt&currency=USD"></script>
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

        .payment-container {
            max-width: 600px;
            margin: 50px auto;
            background: white;
            border-radius: 10px;
            backdrop-filter: blur(10px);
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
            padding: 20px;
            text-align: center;
        }

        .payment-container h2 {
            color: #0056b3;
            margin-bottom: 20px;
        }

        .payment-details {
            margin-bottom: 20px;
            color: black;
        }
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

    <!-- Payment Details -->
    <div class="container payment-container">
        <h2>Pay Your Bill</h2>
        <div class="payment-details">
            <p>Service Type: <strong><?= htmlspecialchars($service_type) ?></strong></p>
            <p>Amount Due: <strong>R <?= htmlspecialchars($amount_due) ?></strong></p>
            <p>Due Date: <strong><?= htmlspecialchars($due_date) ?></strong></p>
        </div>
        <div id="paypal-button-container"></div>
        <script>
            document.addEventListener('DOMContentLoaded', function () {
                if (typeof paypal === 'undefined') {
                    console.error('PayPal SDK not loaded.');
                    alert('PayPal could not be loaded. Please try again later.');
                    return;
                }

                paypal.Buttons({
                    createOrder: function (data, actions) {
                        return actions.order.create({
                            purchase_units: [{
                                amount: {
                                    value: '<?= $amount_due ?>', // Pass the bill amount here
                                    //currency_code: 'ZAR' // Set currency to South African Rand
                                }
                            }]
                        });
                    },
                    onApprove: function (data, actions) {
                        return actions.order.capture().then(function (details) {
                            // Handle successful payment, e.g., update bill status in the database
                            window.location.href = "process_payment.php?bill_id=<?= $bill_id ?>";
                        }).catch(function (error) {
                            console.error('Error capturing order:', error);
                            alert('Payment could not be processed. Please try again.');
                        });
                    },
                    onError: function (err) {
                        console.error('PayPal Error:', err);
                        alert('There was an error with PayPal. Please try again later.');
                    }
                }).render('#paypal-button-container');
            });
        </script>
    </div>

    <!-- Bootstrap JS and dependencies -->
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.11.6/dist/umd/popper.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>

</html>

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
$stmt = $conn->prepare("SELECT email, id_number, first_name, last_name, meter_number, role FROM users WHERE id = ?");
$stmt->bind_param("i", $user_id);
$stmt->execute();
$stmt->bind_result($email, $id_number, $first_name, $last_name,$meter, $role);
$stmt->fetch();
$stmt->close();

function isValidIdNumber($id_number) {
    return preg_match('/^\d{13}$/', $id_number);
}

// Update user profile
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $new_email = $_POST['email'];
    $new_id_number = $_POST['id_number'];
    $new_first_name = $_POST['first_name'];
    $new_last_name = $_POST['last_name'];
    $new_meter = $_POST['meter_number'];
    $new_password = $_POST['password'];
    
    if (isValidIdNumber($new_id_number)) {
        $update_stmt = $conn->prepare("UPDATE users SET email = ?, id_number = ?, first_name = ?, last_name = ?, meter_number=? WHERE id = ?");
        $update_stmt->bind_param("sssii", $new_email, $new_id_number, $new_first_name, $new_last_name, $new_meter, $user_id);
        $update_stmt->execute();
        $update_stmt->close();
        
        if (!empty($new_password)) {
            $hashed_password = password_hash($new_password, PASSWORD_BCRYPT);
            $update_password_stmt = $conn->prepare("UPDATE users SET password = ? WHERE id = ?");
            $update_password_stmt->bind_param("si", $hashed_password, $user_id);
            $update_password_stmt->execute();
            $update_password_stmt->close();
        }
        
        header("Location: profile.php");
    } else {
        echo "<p>Invalid ID Number.</p>";
    }
}

$conn->close();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>User Profile</title>
    <link rel="stylesheet" href="styles.css">

      <!-- Additional CSS Files -->
      <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.8.1/css/all.css" integrity="sha384-50oBUHEmvpQ+1lW4y57PTFmhCaXp0ML5d60M1M7uH2+nqUivzIebhndOJK28anvf" crossorigin="anonymous">
    <link rel="stylesheet" href="assets/css/templatemo-chain-app-dev.css">
    <link rel="stylesheet" href="assets/css/animated.css">
    <link rel="stylesheet" href="assets/css/owl.css">

</head>
<style>

    /* General Styles */
body {
    font-family: Arial, sans-serif;
    margin: 0;
    padding: 0;
    background-color: #f4f4f4;
    color: #333;
}

h2 {
    text-align: center;
    color: #555;
    margin-top: 20px;
}

/* Form Container */
form {
    width: 80%;
    max-width: 600px;
    margin: 20px auto;
    padding: 20px;
    background: #fff;
    border-radius: 8px;
    box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
}

label {
    display: block;
    margin: 10px 0 5px;
    font-weight: bold;
    color: #555;
}

input[type="text"],
input[type="email"],
input[type="password"] {
    width: 100%;
    padding: 10px;
    border: 1px solid #ccc;
    border-radius: 4px;
    box-sizing: border-box;
    margin-bottom: 15px;
    font-size: 16px;
}

input[type="submit"] {
    background-color: #4CAF50;
    color: white;
    border: none;
    padding: 15px 20px;
    text-align: center;
    text-decoration: none;
    display: inline-block;
    font-size: 16px;
    margin: 10px 0;
    cursor: pointer;
    border-radius: 4px;
}

input[type="submit"]:hover {
    background-color: #45a049;
}

/* Error Message */
p {
    color: red;
    text-align: center;
    font-weight: bold;
}

/* Small Note */
small {
    display: block;
    margin-top: -10px;
    margin-bottom: 15px;
    font-size: 14px;
    color: #777;
}

    </style>
<body>
     <!-- ***** Preloader Start ***** -->
  <div id="js-preloader" class="js-preloader">
    <div class="preloader-inner">
      <span class="dot"></span>
      <div class="dots">
        <span></span>
        <span></span>
        <span></span>
      </div>
    </div>
  </div>
  <!-- ***** Preloader End ***** -->

  <!-- ***** Header Area Start ***** -->
  <header class="header-area header-sticky wow slideInDown" data-wow-duration="0.75s" data-wow-delay="0s">
    <div class="container">
      <div class="row">
        <div class="col-12">
          <nav class="main-nav">
            <!-- ***** Logo Start ***** -->
            <a href="index.html" class="logo">
              <img src="assets/images/logo.png" alt="Chain App Dev">
            </a>
            <!-- ***** Logo End ***** -->
            <!-- ***** Menu Start ***** -->
            <ul class="nav">
              <li class="scroll-to-section"><a href="profile.php" class="active">Profile</a></li>
              <li class="scroll-to-section"><a href="dashboard.php" class="active">Billing History</a></li>
              <li class="scroll-to-section"><a href="#top" class="active">Water</a></li>
              <li class="scroll-to-section"><a href="#top" class="active">Electricity</a></li>
              <li><div class="gradient-button"><a id="modal_trigger" href="logout.php"><i class="fa fa-sign-in-alt"></i>Logout</a></div></li> 
            </ul>        
            <a class='menu-trigger'>
                <span>Menu</span>
            </a>
            <!-- ***** Menu End ***** -->
          </nav>
        </div>
      </div>
    </div>
  </header>
  <!-- ***** Header Area End ***** -->
  <div class="main-banner wow fadeIn" id="top" data-wow-duration="1s" data-wow-delay="0.5s">
    <div class="container">
      <div class="row">
        <div class="col-lg-12">
          <div class="row">
            <div class="col-lg-6 align-self-center">
              <div class="left-content show-up header-text wow fadeInLeft" data-wow-duration="1s" data-wow-delay="1s">
                <div class="row">
                <div class="col-lg-12">
                <h2>Edit Profile</h2>
    <form  method="post">
        <label for="email">Email:</label>
        <input type="email" id="email" name="email" value="<?php echo htmlspecialchars($email); ?>" required>

        <label for="email">Meter Number:</label>
        <input type="text" id="meter_number" name="meter_number" value="<?php echo htmlspecialchars($meter); ?>" required>
        
        <label for="id_number">ID Number:</label>
        <input type="text" id="id_number" name="id_number" value="<?php echo htmlspecialchars($id_number); ?>" pattern="\d{13}" title="ID Number must be exactly 13 digits" required>
        
        <label for="first_name">First Name:</label>
        <input type="text" id="first_name" name="first_name" value="<?php echo htmlspecialchars($first_name); ?>" required>
        
        <label for="last_name">Last Name:</label>
        <input type="text" id="last_name" name="last_name" value="<?php echo htmlspecialchars($last_name); ?>" required>
        
        <label for="password">New Password:</label>
        <input type="password" id="password" name="password">
        <small>Leave empty if you don't want to change your password.</small>
        
    <div class="button-group">
     <button type="submit" class=" btn  btn-warning"> Update Profile </button>
    </div>
       
</div>

     <!-- Scripts -->
  <script src="vendor/jquery/jquery.min.js"></script>
  <script src="vendor/bootstrap/js/bootstrap.bundle.min.js"></script>
  <script src="assets/js/owl-carousel.js"></script>
  <script src="assets/js/animation.js"></script>
  <script src="assets/js/imagesloaded.js"></script>
  <script src="assets/js/popup.js"></script>
  <script src="assets/js/custom.js"></script>
</body>
</html>

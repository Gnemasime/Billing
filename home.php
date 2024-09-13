
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Municipal Billing System - Home</title>
     <!-- Bootstrap CSS -->
     <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <!-- FontAwesome Icons -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
    <!-- Custom CSS -->
    <style>
        @import url('https://fonts.googleapis.com/css2?family=Roboto:wght@400;700&display=swap');
        
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
            padding: 40px 20px;
            text-align: center;
            margin-top: 40px;
        }

        .profile-container h2 {
            margin-bottom: 30px;
            color: #0056b3;
        }

        .cta {
            margin-top: 30px;
        }

        .cta a {
            padding: 15px 25px;
            background-color: #007bff;
            color: white;
            text-decoration: none;
            font-size: 1.5em;
            border-radius: 8px;
            transition: background-color 0.3s;
        }

        .cta a:hover {
            background-color: #0056b3;
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
    <div class="container-fluid">
        <div class="profile-container">
            <h2>Welcome to the Municipal Billing System</h2>
            <p>Manage your water, electricity, and other service bills with ease. View unpaid bills, transaction history, and more through our streamlined system.</p>
            <div class="cta">
                <a href="dashboard.php">Go to Dashboard</a>
            </div>
        </div>
    </div>

    <footer><br>
        <p>&copy; 2024 Municipal Billing System. All rights reserved.</p>
    </footer>
<!-- Bootstrap JS and dependencies -->
<script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.11.6/dist/umd/popper.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    <script src="assets/js/shuffle.js"></script>
</body>
</html>

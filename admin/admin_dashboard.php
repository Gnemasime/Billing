<?php
session_start();
if (!isset($_SESSION['role']) || $_SESSION['role'] != 'admin') {
    header("Location: ../login.php");
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

// Fetch data for overview
$totalUsers = $conn->query("SELECT COUNT(*) AS count FROM users WHERE role = 'user'")->fetch_assoc()['count'];
$activeBills = $conn->query("SELECT COUNT(*) AS count FROM bills WHERE status = 'unpaid'")->fetch_assoc()['count'];
$totalRevenue = $conn->query("SELECT SUM(payment_amount) AS revenue FROM transactions")->fetch_assoc()['revenue'] ?? 0;

// Fetch data for the pie chart (Water vs Electricity)
$waterTotal = $conn->query("SELECT SUM(amount_due) AS total_water FROM bills WHERE service_type = 'water'")->fetch_assoc()['total_water'] ?? 0;
$electricityTotal = $conn->query("SELECT SUM(amount_due) AS total_electricity FROM bills WHERE service_type = 'electricity'")->fetch_assoc()['total_electricity'] ?? 0;

$conn->close();
?>

<?php include 'includes/header.php'; ?>
<?php include 'includes/navbar.php'; ?>

<!-- Main Content -->
<div class="main-content">
    <div class="container mt-4">
        <!-- Overview Cards -->
        <div class="row">
            <div class="col-md-4">
                <div class="card text-center">
                    <div class="card-body">
                        <h5 class="card-title">Total Users</h5>
                        <p class="card-text display-4"><?php echo $totalUsers; ?></p>
                    </div>
                </div>
            </div>
            <div class="col-md-4">
                <div class="card text-center">
                    <div class="card-body">
                        <h5 class="card-title">Active Bills</h5>
                        <p class="card-text display-4"><?php echo $activeBills; ?></p>
                    </div>
                </div>
            </div>
            <div class="col-md-4">
                <div class="card text-center">
                    <div class="card-body">
                        <h5 class="card-title">Total Revenue</h5>
                        <p class="card-text display-4">R <?php echo number_format($totalRevenue, 2); ?></p>
                    </div>
                </div>
            </div>
        </div>

        <!-- Pie Chart Section -->
        <div class="row mt-5">
            <div class="col-md-12 text-center">
                <div class="card">
                    <div class="card-body">
                        <h5 class="card-title">Water vs Electricity Bills</h5>
                        <!-- Smaller Chart -->
                        <canvas id="billsChart" width="150" height="200"></canvas>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Include Chart.js -->
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script>
// Get PHP data into JavaScript
var waterTotal = <?php echo $waterTotal; ?>;
var electricityTotal = <?php echo $electricityTotal; ?>;

var ctx = document.getElementById('billsChart').getContext('2d');
var myPieChart = new Chart(ctx, {
    type: 'pie',
    data: {
        labels: ['Water Bills', 'Electricity Bills'],
        datasets: [{
            data: [waterTotal, electricityTotal],
            backgroundColor: ['#00c6ff', '#ffcc00'], // Water: Blue, Electricity: Yellow
            hoverBackgroundColor: ['#0072ff', '#ffeb3b']
        }]
    },
    options: {
        responsive: true,
        plugins: {
            legend: {
                position: 'bottom',
            }
        }
    }
});
</script>

<?php include 'includes/footer.php'; ?>

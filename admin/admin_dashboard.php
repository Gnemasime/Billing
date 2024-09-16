<?php
session_start();
if (!isset($_SESSION['role']) || $_SESSION['role'] != 'admin') {
    header("Location: ../login.php");
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

// Create a connection to the database
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

// Fetch data for the line chart (Paid, Overdue, Unpaid)
$paidBills = $conn->query("SELECT COUNT(*) AS count FROM bills WHERE status = 'paid'")->fetch_assoc()['count'];
$unpaidBills = $conn->query("SELECT COUNT(*) AS count FROM bills WHERE status = 'unpaid'")->fetch_assoc()['count'];
$overdueBills = $conn->query("SELECT COUNT(*) AS count FROM bills WHERE status = 'overdue'")->fetch_assoc()['count'];

$conn->close();
?>

<?php include 'includes/header.php'; ?>
<?php include 'includes/navbar.php'; ?>
<style>
    .charts{
        width: 700px; /* Set a fixed width */
         height: 100px; /* Set a fixed height */
         margin: 20px auto; /* Center the cards with some margin */
    }
    
    </style>
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
</div>
        <!-- Pie Chart Section -->
         <div class="charts">
        <div class="row mt-5">
            <div class="col-md-6 text-center">
                <div class="card">
                    <div class="card-body">
                        <h5 class="card-title">Water vs Electricity Bills</h5>
                        <canvas id="billsChart" width="400" height="400"></canvas>
                    </div>
                </div>
            </div>

            <!-- Line Chart for Paid, Overdue, and Unpaid Bills -->
            
            <div class="col-md-6 text-center">
                <div class="card">
                    <div class="card-body">
                        <h5 class="card-title">Paid, Overdue, and Unpaid Bills</h5>
                        <canvas id="billStatusChart" width="400" height="400"></canvas>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
</div>
<!-- Include Chart.js -->
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script>
// Pie Chart for Water vs Electricity Bills
var waterTotal = <?php echo $waterTotal; ?>;
var electricityTotal = <?php echo $electricityTotal; ?>;

var ctxPie = document.getElementById('billsChart').getContext('2d');
var myPieChart = new Chart(ctxPie, {
    type: 'pie',
    data: {
        labels: ['Water Bills', 'Electricity Bills'],
        datasets: [{
            data: [waterTotal, electricityTotal],
            backgroundColor: ['#00c6ff', '#ffcc00'],
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

// Line Chart for Paid, Overdue, and Unpaid Bills
var paidBills = <?php echo $paidBills; ?>;
var unpaidBills = <?php echo $unpaidBills; ?>;
var overdueBills = <?php echo $overdueBills; ?>;

var ctxLine = document.getElementById('billStatusChart').getContext('2d');
var myLineChart = new Chart(ctxLine, {
    type: 'line',
    data: {
        labels: ['Paid Bills', 'Unpaid Bills', 'Overdue Bills'],
        datasets: [{
            label: 'Bill Status',
            data: [paidBills, unpaidBills, overdueBills],
            backgroundColor: 'rgba(0, 198, 255, 0.2)',
            borderColor: 'rgba(0, 198, 255, 1)',
            borderWidth: 2,
            fill: true
        }]
    },
    options: {
        responsive: true,
        scales: {
            y: {
                beginAtZero: true
            }
        },
        plugins: {
            legend: {
                position: 'bottom'
            }
        }
    }
});
</script>

<?php include 'includes/footer.php'; ?>

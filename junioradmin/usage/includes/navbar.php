 <!-- Navbar -->
 <div class="navbar-top">
        <button class="navbar-toggler" type="button" id="sidebarToggle">
            <i class="fas fa-bars"></i>
        </button>
        <span class="user-info">Welcome, <?php echo htmlspecialchars($loggedInUser); ?></span>
    </div>

    <!-- Sidebar -->
    <div class="sidebar" id="sidebar">
        <h2>Admin Panel</h2>
        <ul class="nav flex-column">
            <li class="nav-item">
                <a class="nav-link" href="admin_dashboard.php"><i class="fas fa-tachometer-alt"></i> <span>Dashboard</span></a>
            </li>
            <li class="nav-item">
                <a class="nav-link" href="manage_users.php"><i class="fas fa-users"></i> <span>Users</span></a>
            </li>
            <li class="nav-item">
                <a class="nav-link" href="manage_bills.php"><i class="fas fa-file-invoice-dollar"></i> <span>Bills</span></a>
            </li>
            <li class="nav-item">
                <a class="nav-link" href="manage_payments.php"><i class="fas fa-money-check-alt"></i> <span>Payments</span></a>
            </li>
           
          <!-- <li class="nav-item">
                <a class="nav-link" href="generate_reports.php"><i class="fas fa-chart-line"></i> <span>Reports</span></a>
            </li>
            <li class="nav-item">
                <a class="nav-link" href="settings.php"><i class="fas fa-cogs"></i> <span>Settings</span></a>
            </li>-->
            <li class="nav-item">
                <a class="nav-link" href="logout.php"><i class="fas fa-sign-out-alt"></i> <span>Logout</span></a>
            </li>
        </ul>
    </div>

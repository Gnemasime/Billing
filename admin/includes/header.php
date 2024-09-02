<!-- includes/header.php -->
<?php

// Assuming user's name is stored in session
$loggedInUser = $_SESSION['user_name'] ?? 'Admin'; // Set a default if the name isn't set
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Dashboard</title>
    <!-- Bootstrap CSS -->
    <link href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css" rel="stylesheet">
    <!-- Font Awesome for Icons -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css">
    <!-- Select2 CSS -->
    <link href="https://cdnjs.cloudflare.com/ajax/libs/select2/4.1.0-beta.1/css/select2.min.css" rel="stylesheet" />
    <!-- Custom CSS -->
     <!-- Bootstrap CSS -->
<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
<!-- FontAwesome for Icons (optional but commonly used) -->
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.1.1/css/all.min.css">

    <style>
        /* General Body Styling */
body {
    background-color: #f4f7fa; /* Light gray background */
    display: flex;
    color: #333; /* Dark gray text color for readability */
}

/* Sidebar Styling */
.sidebar {
    width: 250px;
    height: 100vh;
    background-color: #0056b3; /* Changed to a deeper blue */
    position: fixed;
    top: 0;
    left: 0;
    display: flex;
    flex-direction: column;
    align-items: center;
    padding-top: 20px;
    transition: all 0.3s ease;
}

.sidebar.collapsed {
    width: 70px;
}

.sidebar h2 {
    color: #fff; /* White text for the sidebar header */
    text-transform: uppercase;
    margin-bottom: 30px;
    font-size: 18px;
    letter-spacing: 1px;
    transition: opacity 0.3s ease;
}

.sidebar.collapsed h2 {
    opacity: 0;
}

.sidebar .nav-item {
    width: 100%;
}

.sidebar .nav-link {
    color: white; /* White text for links */
    padding: 15px;
    text-align: left;
    width: 100%;
    display: flex;
    align-items: center;
    transition: all 0.3s ease;
    font-size: 16px;
    border-radius: 5px; /* Added rounded corners for better visual */
}

.sidebar .nav-link i {
    margin-right: 10px;
    font-size: 18px;
    transition: margin 0.3s ease;
}

.sidebar.collapsed .nav-link i {
    margin-right: 0;
}

.sidebar.collapsed .nav-link span {
    display: none;
}

.sidebar .nav-link:hover {
    background-color: #003d7a; /* Darker blue for hover effect */
    text-decoration: none;
    box-shadow: 0 4px 6px rgba(0, 0, 0, 0.2); /* Added shadow effect */
}

/* Navbar Styling */
.navbar-top {
    width: 100%;
    background-color: #0056b3; /* Changed to match sidebar */
    height: 60px;
    display: flex;
    align-items: center;
    padding: 0 20px;
    position: fixed;
    top: 0;
    left: 0;
    z-index: 1000;
    justify-content: space-between;
    transition: margin-left 0.3s ease;
}

.navbar-top .navbar-toggler {
    border: none;
    color: white;
    font-size: 20px;
    margin-right: 10px;
}

.navbar-top .user-info {
    color: white;
    font-size: 16px;
}

/* Main Content Styling */
.main-content {
    margin-left: 250px;
    padding: 80px 20px 20px; /* Added top padding to avoid navbar overlap */
    transition: margin-left 0.3s ease;
    width: 100%;
}

.main-content.collapsed {
    margin-left: 70px;
}

/* Card Styling */
.card {
    border: none;
    border-radius: 10px;
    box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
    background-color: #ffffff; /* White background for cards */
    transition: box-shadow 0.3s ease; /* Smooth shadow transition */
}

.card:hover {
    box-shadow: 0 8px 16px rgba(0, 0, 0, 0.2); /* Darker shadow on hover */
}

/* Button Styling */
.btn-animated {
    padding: 10px 20px;
    font-size: 16px;
    color: white;
    background-color: #007bff; /* Bright blue background */
    border: 2px solid #007bff; /* Matching border color */
    border-radius: 50px;
    text-transform: uppercase;
    cursor: pointer;
    overflow: hidden;
    transition: background-color 0.4s, color 0.4s, transform 0.3s ease; /* Added transform effect */
    margin: 10px;
}

.btn-animated:hover {
    background-color: white;
    color: #007bff; /* Text color changes to blue */
    border-color: #007bff; /* Border color remains blue */
    transform: scale(1.05); /* Slightly enlarges button on hover */
}

    </style>
</head>
<body>
   
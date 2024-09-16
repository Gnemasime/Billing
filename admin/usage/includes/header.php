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
    background: linear-gradient(135deg, #e0e5e9, #c2c9d1); /* Light gradient background */
    background-blend-mode: overlay; /* Blends colors for a more dynamic effect */
    display: flex;
    color: #333; /* Dark gray text color for readability */
}

/* Sidebar Styling */
.sidebar {
    width: 250px;
    height: 100vh;
    background: linear-gradient(135deg, #ff6f00, #ff3d00); /* Fiery gradient background */
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
    font-size: 22px; /* Slightly larger font size */
    letter-spacing: 2px; /* Increased letter spacing */
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
    background: rgba(255, 255, 255, 0.1); /* Slightly transparent background for glassy effect */
    backdrop-filter: blur(10px); /* Glassy blur effect */
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
    background: rgba(255, 255, 255, 0.3); /* Lighter glass effect on hover */
    text-decoration: none;
    box-shadow: 0 4px 8px rgba(0, 0, 0, 0.3); /* Enhanced shadow effect */
}

/* Navbar Styling */
.navbar-top {
    width: 100%;
    background: rgba(0, 0, 0, 0.3); /* Semi-transparent background for a glassy look */
    height: 60px;
    display: flex;
    align-items: center;
    padding: 0 20px;
    position: fixed;
    top: 0;
    left: 0;
    z-index: 1000;
    justify-content: space-between;
    backdrop-filter: blur(10px); /* Glassy blur effect */
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
    position: relative;
}

/* Card Styling */
.card {
    border: none;
    border-radius: 10px;
    box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
    background: rgba(255, 255, 255, 0.9); /* Slightly transparent white background for a glassy effect */
    backdrop-filter: blur(8px); /* Glassy blur effect */
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
    background: linear-gradient(135deg, #ff6f00, #ff3d00); /* Fiery gradient background */
    border: 2px solid transparent; /* Transparent border to highlight gradient background */
    border-radius: 50px;
    text-transform: uppercase;
    cursor: pointer;
    overflow: hidden;
    position: relative;
    transition: background-color 0.4s, color 0.4s, transform 0.3s ease; /* Added transform effect */
    margin: 10px;
    z-index: 1;
    font-weight: normal; /* Removed font weight */
}

.btn-animated::before {
    content: '';
    position: absolute;
    top: 50%;
    left: 50%;
    width: 300%;
    height: 300%;
    background: rgba(255, 255, 255, 0.2); /* Glassy shimmer effect */
    transition: transform 0.4s ease;
    transform: translate(-50%, -50%) scale(0);
    border-radius: 50%;
    z-index: -1;
}

.btn-animated:hover::before {
    transform: translate(-50%, -50%) scale(1);
}

.btn-animated:hover {
    background: white;
    color: #ff3d00; /* Text color changes to fiery red */
    border-color: #ff3d00; /* Border color matches the button background */
    transform: scale(1.05); /* Slightly enlarges button on hover */
}

/* Container Styling */
.container {
    max-width: 1200px;
    margin: 0 auto;
    padding: 20px;
    background: rgba(255, 255, 255, 0.8); /* Slightly transparent white background for glassy effect */
    border-radius: 10px;
    box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1); /* Soft shadow for a lifted effect */
    backdrop-filter: blur(10px); /* Glassy blur effect */
    transition: box-shadow 0.3s ease; /* Smooth shadow transition */
}

.container:hover {
    box-shadow: 0 8px 16px rgba(0, 0, 0, 0.2); /* Darker shadow on hover */
}

/* Lighting Effects */
@keyframes lighting {
    0% {
        opacity: 0.5;
        filter: brightness(100%);
    }
    50% {
        opacity: 1;
        filter: brightness(120%);
    }
    100% {
        opacity: 0.5;
        filter: brightness(100%);
    }
}

.main-content::before {
    content: '';
    position: absolute;
    top: 0;
    left: 0;
    width: 100%;
    height: 100%;
    background: rgba(255, 255, 255, 0.1); /* Subtle light overlay */
    opacity: 0.2;
    animation: lighting 2s infinite ease-in-out; /* Lighting animation effect */
    z-index: -1; /* Behind the content */
}

/* Heading Styles */
h1, h2, h3, h4, h5, h6 {
    color: #333; /* Dark gray text for all headings */
    font-family: 'Arial', sans-serif; /* Clean, modern font */
    text-shadow: 0 2px 4px rgba(0, 0, 0, 0.2); /* Subtle shadow for better readability */
    margin-top: 20px;
    margin-bottom: 10px;
    font-weight: normal; /* Removed font weight */
}

h1 {
    font-size: 2.5rem; /* Larger font size for h1 */
}

h2 {
    font-size: 2rem; /* Slightly smaller than h1 */
}

h3 {
    font-size: 1.75rem; /* Smaller than h2 */
}

h4 {
    font-size: 1.5rem; /* Smaller than h3 */
}

h5 {
    font-size: 1.25rem; /* Smaller than h4 */
}

h6 {
    font-size: 1rem; /* Smallest heading size */
}


    </style>
</head>
<body>
   
<?php
    session_start();

    if (!isset($_SESSION["position"])) {
        echo "<script>
        alert('Please login!');
        window.location.href = '../index.php';
        </script>";
        exit();
    }
    $mysqli = require __DIR__ . "/../database.php";

    $sql = "SELECT report_id, rname, plocation, problem, pdescription  FROM reportdetails";
    $result = $mysqli->query($sql);

    if ($result->num_rows > 0) {
        $reports = $result->fetch_all(MYSQLI_ASSOC);
    } else {
        $reports = [];
    }
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>SMART</title>
    <link href="../Style/AdminHome.css" rel="stylesheet">
    <link href="../Style/Sidebar.css" rel="stylesheet">
</head>
<body>

<header class="sticky-header">
    <div class="header-container">
        <div class="logos">
            <img src="../Assets/dots.svg" class="logo" alt="Dots" id="Dots">
            <?php if ($_SESSION["position"] == "Admin" || $_SESSION["position"] == "Maintenance Staff"): ?>

            <a href="AdminHome.php"><img src="../Assets/home.svg" class="logo" alt="Home" id="Home"></a>
            <a href="AdminHistory.php"><img src="../Assets/history.svg" class="logo" alt="History" id="History"></a>

            <?php else: ?>

            <a href="Home.php"><img src="../Assets/home.svg" class="logo" alt="Home" id="Home"></a>
            <a href="History.php"><img src="../Assets/history.svg" class="logo" alt="History" id="History"></a>

            <?php endif ?>
            <a href="Notification.php"><img src="../Assets/notification.svg" class="logo" alt="Notifications" id="Notifications"></a>
            <a href="Settings.php"><img src="../Assets/settings.svg" class="logo" alt="Settings" id="Settings"></a>
        </div>

        <div class="user-info">
            <div class="user-top">
                <span class="username">Leiby Rose M.</span>
                <span class="position">Student</span>
                <select class="dropdown">
                    <option value="">Profile</option>
                    <option value="settings">Settings</option>
                    <option value="logout">Logout</option>
                </select>
            </div>
        </div>
    </div>
</header>

<div class="sidebar" id="sidebar">
    <div class="logo-section">
        <img src="../Assets/companyl.svg" alt="Company Logo" class="logo">
        <div class="company-name">
            <h2>Maintenics</h2>
            <h3>Smart</h3>
        </div>
    </div>
    <div class="separator"></div>
    <div class="company-info">
        <div class="vision">
            <h4>Vision</h4>
            <p>To be the leading provider of innovative maintenance solutions.</p>
        </div>
        <div class="mission">
            <h4>Mission</h4>
            <p>Deliver reliable, sustainable, and effective solutions for our clients.</p>
        </div>
        <div class="color-value">
            <h4>Color Value</h4>
            <p>#00FF00</p> <!-- Replace with your actual color code -->
        </div>
    </div>
</div>

		<div class="dashboard">
        <div class="card">
            <h3>User Management</h3>
            <p>Manage student and staff accounts</p>
            <a href="#" class="view-btn">View all</a>
        </div>
        <div class="card">
            <h3>Total Reports</h3>
            <p>0</p>
        </div>
        <div class="card">
            <h3>Reports In Progress</h3>
            <p>0</p>
        </div>
        <div class="card">
            <h3>Latest Report</h3>
            <p>Broken Heart - Room 103</p>
            <a href="#" class="view-btn">View all</a>
        </div>
    </div>


<script src="../JS/script.js"></script>
<script src="../JS/script4.js"></script>
</body>
</html>
<?php 
session_start();

if (!isset($_SESSION["position"])) {
    echo "<script>
    alert('You are not logged in!');
    window.location.href = '../index.php';
    </script>";
    exit();
}

$Testsql = require __DIR__ . "/../database.php";
$position = $_SESSION["position"];
$rid = $_SESSION["id"];

$fname = $_SESSION["fname"];
$school_id = $_SESSION["id"] ?? null;

$sql = "SELECT full_name, position FROM userinfo WHERE school_id = ?";
$stmt = $Testsql->prepare($sql);
$stmt->bind_param("i", $school_id);
$stmt->execute();
$result = $stmt->get_result();
$user = $result->fetch_assoc();

$sql = "SELECT * FROM userinfo WHERE position = '$position'";
$result = $Testsql->query($sql);

$sql = "SELECT report_id, problem, date_reported, date_resolved, status, rating, feedback, rid 
        FROM reportdetails 
        WHERE status = 'Resolved' 
        ORDER BY date_reported DESC";

$stmt = $Testsql->prepare($sql);
$stmt->execute();
$Report = $stmt->get_result();

$reports = [];

if ($Report->num_rows > 0) {
    while ($row = $Report->fetch_assoc()) { 
        $reports[] = $row;  
    }
}
$feedback="";
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>SMART</title>
    <link href="../Style/AdminHistory.css" rel="stylesheet">
    <link href="../Style/Sidebar.css" rel="stylesheet">
</head>
<body>

<header class="sticky-header">
    <div class="header-container">
    <div class="logos">
            <img src="../Assets/dots.svg" class="logo" alt="Dots" id="Dots">
            <?php
            switch ($position) {
                case "Admin":
                    ?>
                    <a href="AdminHome.php"><img src="../Assets/home.svg" class="logo" alt="Home" id="Home"></a>
                    <a href="AdminHistory.php"><img src="../Assets/history.svg" class="logo" alt="History" id="History"></a>
                    <?php
                    break;

                case "Maintenance Staff":
                    ?>
                    <a href="MaintenanceHome.php"><img src="../Assets/home.svg" class="logo" alt="Home" id="Home"></a>
                    <a href="History.php"><img src="../Assets/history.svg" class="logo" alt="History" id="History"></a>
                    <?php
                    break;
            
                case "Student":
                case "Teacher":
                    ?>
                    <a href="Home.php"><img src="../Assets/home.svg" class="logo" alt="Home" id="Home"></a>
                    <a href="History.php"><img src="../Assets/history.svg" class="logo" alt="History" id="History"></a>
                    <?php
                    break;
            
                default:
                    ?>
                    <a href="Home.php"><img src="../Assets/home.svg" class="logo" alt="Home" id="Home"></a>
                    <a href="History.php"><img src="../Assets/history.svg" class="logo" alt="History" id="History"></a>
                    <?php
                    break;
            }
            ?>

            <a href="Notification.php"><img src="../Assets/notification.svg" class="logo" alt="Notifications" id="Notifications"></a>
            <a href="Settings.php"><img src="../Assets/settings.svg" class="logo" alt="Settings" id="Settings"></a>
        </div>

        <div class="user-info">
            <div class="user-top">
                <?php if (isset($fname) && isset($position)):  ?>

                <span class="username"><?= htmlspecialchars($user["full_name"]) ?></span>
                <span class="position"><?= htmlspecialchars($user["position"]) ?></span>

                <?php else: ?>

                <span class="username">NULL</span>
                <span class="position">NULL</span>

                <?php endif; ?>

                <select class="dropdown" id="profileDropdown" onchange="handleProfileChange(this.value)">
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

		 <div class="container">
        <div class="title">Report History</div>
        <div class="box">
            <div class="heading">Most Common Issue</div>
            <table class="table">
                <tr>
                    <th>Issue</th>
                    <th>Reported Times</th>
                </tr>
                <tr class="highlight">
                    <td>Aircon</td>
                    <td>53</td>
                </tr>
                <tr>
                    <td>TV</td>
                    <td>00</td>
                </tr>
                <tr>
                    <td>Door</td>
                    <td>00</td>
                </tr>
            </table>
        </div>
    </div>

<script src="../JS/script.js"></script>
<script src="../JS/script4.js"></script>
</body>
</html>
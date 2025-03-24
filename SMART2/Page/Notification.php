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

$fname = $_SESSION["fname"];
$school_id = $_SESSION["id"] ?? null;

$sql = "SELECT full_name, position FROM userinfo WHERE school_id = ?";
$stmt = $Testsql->prepare($sql);
$stmt->bind_param("i", $school_id);
$stmt->execute();
$result = $stmt->get_result();
$user = $result->fetch_assoc();

$sql = "SELECT * FROM reportdetails WHERE status IN ('Pending', 'Ongoing', 'Resolved')";
$reports = $Testsql->query($sql);

$pendingReports = [];
$ongoingReports = [];
$resolvedReports = [];

if ($reports->num_rows > 0) {
    while ($row = $reports->fetch_assoc()) { 
        switch ($row['status']) {
            case 'Pending':
                $pendingReports[] = $row;
                break;
            case 'Ongoing':
                $ongoingReports[] = $row;
                break;
            case 'Resolved':
                $resolvedReports[] = $row;
                break;
        }
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>SMART</title>
    <link href="../Style/Notification.css" rel="stylesheet">
    <link href="../Style/Sidebar.css" rel="stylesheet">

</head>
<body>

<header class="sticky-header">
    <div class="header-container">
        <div class="logos">
            <!-- Dots Icon, when clicked will show/hide sidebar -->

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
                
            <?php if (isset($fname) && isset($position)):  ?>

            <span class="username"><?= htmlspecialchars($user["full_name"]) ?></span>
            <span class="position"><?= htmlspecialchars($user["position"]) ?></span>

            <?php else: ?>

            <span class="username">NULL</span>
            <span class="position">NULL</span>

            <?php endif; ?>

                <select class="dropdown">
                    <option value="">Profile</option>
                    <option value="settings">Settings</option>
                    <option value="logout">Logout</option>
                </select>
            </div>
        </div>
    </div>
</header>

<!-- Sidebar -->
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

<h1> Notifications </h1>

	<div class="notifications">
  <button id="mark-all-read" class="mark-all-btn">Mark All as Read</button>
</div>

	<div class="box">
			<span class="overlayt" id="status-text">Report Submitted!</span>
			<span class="timestamp">5 hours ago</span>
	  </div>

	<div class="box1">
			<span class="overlayt1" id="status-text">Report Submitted!</span>
			<span class="timestamp">3 hours ago</span>
	  </div>


  <script src="../JS/script2.js"></script>
  <script src="../JS/script4.js"></script>

  
  </body>
</html>
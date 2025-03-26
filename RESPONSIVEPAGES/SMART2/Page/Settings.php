<?php
session_start();

if (!isset($_SESSION["position"]) || !isset($_SESSION["fname"]) || !isset($_SESSION["id"])) {
    echo "<script>
    alert('You are not logged in!');
    window.location.href = '../index.php';
    </script>";
    exit();
}

$mysqli = require __DIR__ . "/../database.php";

// Escape session variables for security
$fname = $mysqli->real_escape_string($_SESSION["fname"]);
$position = $mysqli->real_escape_string($_SESSION["position"]);
$id = $mysqli->real_escape_string($_SESSION["id"]);

// Fetch user info from `userinfo` table
$sql = "SELECT full_name, position FROM userinfo WHERE full_name = '$fname' AND position = '$position' AND school_id = '$id'";
$result = $mysqli->query($sql);

if ($result->num_rows > 0) {
    $user = $result->fetch_assoc(); // Fetch user details
} else {
    $user = null; // No user found
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>SMART</title>
    <link href="../Style/Settings.css" rel="stylesheet">
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
                <select class="dropdown" id="profileDropdown" onchange="handleProfileChange(this.value)">
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

				<div class="container">
		  <img class="pfp" src="../Assets/profile.png" alt="Profile Picture">
		  <div class="text">
          <?php if (isset($fname) && isset($position)):  ?>

            <h2><?= htmlspecialchars($user["full_name"]) ?></h2>
            <p><?= htmlspecialchars($user["position"]) ?></p>

            <?php else: ?>

            <span class="username">NULL</span>
            <span class="position">NULL</span>

            <?php endif; ?>
		  </div>
		</div>
		
		 
		  <div class="settings">
			<div class="setting-choice">Change Password</div>
			
			<div class="setting-choice">Dark Mode</div>
			
			<div class="setting-choice">Privacy & Policy</div>

			<div class="setting-choice">Contact Us</div>
		  </div>
		</div>

	
  <script src="../JS/script3.js"></script>
  <script src="../JS/script4.js"></script>

  </body>
  </html>

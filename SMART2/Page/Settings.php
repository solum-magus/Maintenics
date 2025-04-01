<?php
session_start();
require_once __DIR__ . "/../Authentication/checknotif.php";

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

$hasUnread = checkUnreadNotifications($mysqli);

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

            <a href="Notification.php"><img src="../Assets/notification<?= $hasUnread ? '1' : '' ?>.svg" class="logo <?= $hasUnread ? 'unread' : '' ?>" alt="Notifications" id="Notifications"></a>
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
                <div class="setting-choice" id="changePasswordBtn">Change Password</div>
                
                <div class="setting-choice">
                    <label for="darkModeToggle">Dark Mode</label>
                    <input type="checkbox" id="darkModeToggle">
                </div>
        
                <div class="setting-choice" id="privacyPolicyBtn">Privacy & Policy</div>

                <div class="setting-choice" id="contactUsBtn">Contact Us</div>
            </div>
		</div>

        <!-- Change Password Modal -->
        <div id="passwordModal" class="modal">
            <div class="modal-content">
                <span class="close">&times;</span>
                <h2>Change Password</h2>

                <!-- Display error/success messages -->
                <?php if (isset($_SESSION["error"])): ?>
                    <p class="error"><?php echo $_SESSION["error"]; unset($_SESSION["error"]); ?></p>
                <?php endif; ?>

                <?php if (isset($_SESSION["success"])): ?>
                    <p class="success"><?php echo $_SESSION["success"]; unset($_SESSION["success"]); ?></p>
                <?php endif; ?>

                <form action="../Authentication/change_pass.php" method="POST">
                    <label for="school_id">School ID:</label>
                    <input type="text" id="school_id" name="school_id" required>

                    <label for="current_password">Current Password:</label>
                    <input type="password" id="current_password" name="current_password" required>

                    <label for="new_password">New Password:</label>
                    <input type="password" id="new_password" name="new_password" required>

                    <label for="confirm_password">Confirm New Password:</label>
                    <input type="password" id="confirm_password" name="confirm_password" required>

                    <button type="submit">Change Password</button>
                </form>
            </div>
        </div>


        <!-- Privacy Policy Modal -->
        <div id="privacyModal" class="modal">
            <div class="modal-content">
                <span class="close">&times;</span>
                <h2>Privacy & Policy</h2>
                <br>
                <h3>Information We Collect</h3>
                <ul>
                    <strong>Personal Information</strong> – Name, email address, school ID, and position (Student, Teacher, Maintenance Staff, Admin).
                    <br>
                    <strong>Usage Data</strong> – Information about how you interact with our platform.
                    <br>
                    <strong>Device Information</strong> – Your device type, browser, and IP address.
                </ul>

                <br><br>
                <h3>How We Use Your Information</h3>
                <ul>
                    Provide and improve our platform’s services.
                    Notify maintenance staff about reported issues.
                    Secure user authentication and access control.
                </ul>
                <br>
                <h3>Data Protection & Security</h3>
                <ul>
                <p>We implement strict security measures to safeguard your personal data against unauthorized access, alteration, or disclosure.</p>
                </ul>

                <br>
                <h3>Sharing of Information</h3>
                <ul>
                    <strong>School Administration & Maintenance Staff</strong> – To process issue reports. <br>
                    <strong>Legal Authorities</strong> – If required by law.
                </ul>

                <br>
                <h3>Cookies & Tracking</h3>
                <ul>
                <p>We use cookies to enhance user experience and track platform performance.</p>
                </ul>

                <br>
                <h3>Your Rights</h3>
                <ul>
                <p>You have the right to access, modify, or delete your personal data by contacting us.</p>
                </ul>
            </div>
        </div>


        <!-- Contact Us Modal -->
        <div id="contactModal" class="modal">
            <div class="modal-content">
                <span class="close">&times;</span>
                <h2>Contact Us</h2>
                <p>If you have any questions, feel free to reach out:</p>
                <ul>
                    <strong>Email:</strong> MaintenicsSmart@gmail.com
                    <br>
                    <strong>Phone:</strong> +63 912 345 6789
                    <br>
                    <strong>Office:</strong> STI College Meycauayan, Bulacan 
                    <br>
                    <img src="../Assets/companyl.svg" alt="Company Logo" class="logo">
                </ul>

            </div>
        </div>


  <script src="../JS/script3.js"></script>
  <script src="../JS/script4.js"></script>

  <script>
    sessionStorage.setItem("darkMode", "<?php echo $_SESSION['dark_mode'] ?? 0; ?>");
  </script>

  </body>
  </html>

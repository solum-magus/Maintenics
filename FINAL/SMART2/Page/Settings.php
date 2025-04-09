<?php
session_start();
require_once __DIR__ . "/../Authentication/checknotif.php";

if (!isset($_SESSION["position"])) {
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

if (isset($_SESSION["fname"]) && isset($_SESSION["position"])) {

    $mysqli = require __DIR__ . "/../database.php";

    $fname = $mysqli->real_escape_string($_SESSION["fname"]);
    $position = $mysqli->real_escape_string($_SESSION["position"]);

    $sql = "SELECT * FROM userinfo
            WHERE full_name = '$fname'
            AND position = '$position'";

    $result = $mysqli->query($sql);

    $user = $result->fetch_assoc();

    $school_id = $user["school_id"] ?? null;

    $full_name = $user["full_name"] ?? "";
    $first_name = explode(" ", trim($full_name))[0];

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
    <link href="../Style/Navigationbar.css" rel="stylesheet">
</head>
<body>

<header class="sticky-header">
    <div class="header-container">
        <div class="logos">
            <!-- Dots Icon, when clicked will show/hide sidebar -->

            <img src="../Assets/companyl.svg" class="logo" alt="Dots" id="Dots">
            <?php
            switch ($position) {
                case "Admin":
                    ?>
                    <a href="AdminHome.php"  class="logo-link"><img src="../Assets/home.svg" class="logo" alt="Home" id="Home"></a>
                    <a href="AdminHistory.php"  class="logo-link"><img src="../Assets/history.svg" class="logo" alt="History" id="History"></a>
                    <?php
                    break;

                case "Maintenance Staff":
                    ?>
                    <a href="MaintenanceHome.php"  class="logo-link"><img src="../Assets/home.svg" class="logo" alt="Home" id="Home"></a>
                    <a href="History.php"  class="logo-link"><img src="../Assets/history.svg" class="logo" alt="History" id="History"></a>
                    <?php
                    break;
            
                case "Student":
                case "Teacher":
                    ?>
                    <a href="Home.php"  class="logo-link"><img src="../Assets/home.svg" class="logo" alt="Home" id="Home"></a>
                    <a href="History.php"  class="logo-link"><img src="../Assets/history.svg" class="logo" alt="History" id="History"></a>
                    <?php
                    break;
            
                default:
                    ?>
                    <a href="Home.php"  class="logo-link"><img src="../Assets/home.svg" class="logo" alt="Home" id="Home"></a>
                    <a href="History.php"  class="logo-link"><img src="../Assets/history.svg" class="logo" alt="History" id="History"></a>
                    <?php
                    break;
            }
            ?>

            <a href="Notification.php" class="logo-link"><img src="../Assets/notification<?= $hasUnread ? '1' : '' ?>.svg" class="logo <?= $hasUnread ? 'unread' : '' ?>" alt="Notifications" id="Notifications"></a>
            <a href="Settings.php" class="logo-link"><img src="../Assets/settings.svg" class="logo" alt="Settings" id="Settings"></a>
        </div>

        <div class="user-info">
            <div class="user-top">
            <div class="position-dropdown">
                <span class="username"><?= htmlspecialchars($first_name ?? "NULL") ?></span>
                <span class="position"><?= htmlspecialchars($user["position"] ?? "NULL") ?></span>
            </div>
                <select class="dropdown" id="profileDropdown" onchange="handleProfileChange(this.value)">
                    <option value="" disabled selected></option>
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
        <div class="contact">
            <h4>Contact Us</h4>
            <p>maintenics@gmail.com</p>
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

                <img src="../Assets/QR.svg" class="qr">
            </div>
		</div>

        <?php
            $showModal = false;
            if (isset($_SESSION["error"]) || isset($_SESSION["success"])) {
                $showModal = true;
            }
        ?>
        <!-- Change Password Modal -->
        <div id="passwordModal" class="modal">
            <div class="modal-content">
                <span class="close">&times;</span>
                <h2>Change Password</h2>



                <form action="../Authentication/change_pass.php" method="POST">
                    <label for="school_id">School ID:</label>
                    <input type="text" id="school_id" name="school_id" value="<?= $id?>" readonly>

                    <label for="current_password">Current Password:</label>
                    <div class="password-wrapper">
                        <input type="password" id="current_password" name="current_password" required
                            onblur="this.placeholder = 'Enter your password'"
                            onfocus="this.placeholder = ''"
                            placeholder="Enter your password">
                        <img src="../Assets/eye-alt.svg" onclick="showpass3()" class="pass-icon3" id="pass-icon3">
                    </div>

                    <label for="new_password">New Password:</label>
                    <div class="password-wrapper">
                        <input type="password" id="new_password" name="new_password" required
                            placeholder="Enter your password"
                            onfocus="this.placeholder = ''"
                            onblur="this.placeholder = 'Enter your new password'">
                        <img src="../Assets/eye-alt.svg" onclick="showpass()" class="pass-icon" id="pass-icon">
                    </div>

                    <label for="confirm_password">Confirm New Password:</label>
                    <div class="password-wrapper">
                        <input type="password" id="confirm_password" name="confirm_password" required
                            placeholder="Re-enter your password"
                            onblur="this.placeholder = 'Re-enter your new password'"
                            onfocus="this.placeholder = ''">
                        <img src="../Assets/eye-alt.svg" onclick="showpass2()" class="pass-icon2" id="pass-icon2">
                    </div>

                                    
                    <?php if (isset($_SESSION["error"])): ?>
                        <div class="error"><?= $_SESSION["error"]; unset($_SESSION["error"]); ?></div>
                    <?php endif; ?>

                    <?php if (isset($_SESSION["success"])): ?>
                        <div class="success"><?= $_SESSION["success"]; unset($_SESSION["success"]); ?></div>
                    <?php endif; ?>
                    
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
                    <strong>Email:</strong> maintenics@gmail.com
                    <br>
                    <strong>Phone:</strong> +63 912 345 6789
                    <br>
                    <strong>Office:</strong> STI College Meycauayan, Bulacan 
                    <br>
                    <img src="../Assets/companyl.svg" alt="Company Logo" class="logo">
                </ul>

            </div>
        </div>


    <script>
        document.addEventListener("DOMContentLoaded", function() {
            <?php if ($showModal): ?>
                const modal = document.getElementById("passwordModal");
                if (modal) {
                    modal.classList.add("show"); // add your modal-open class
                }
            <?php endif; ?>
    });
    
</script>
  <script src="../JS/script3.js"></script>
  <script src="../JS/script4.js"></script>
  <script src="../JS/script6.js"></script>
  <script src="../JS/script7.js"></script>

  <script>
    sessionStorage.setItem("darkMode", "<?php echo $_SESSION['dark_mode'] ?? 0; ?>");
  </script>

  </body>
  </html>

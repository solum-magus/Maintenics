<?php
session_start();
require_once __DIR__ . "/../Authentication/checknotif.php";

$mysqli = require __DIR__ . "/../database.php";
$position = $_SESSION["position"];

$fname = $_SESSION["fname"];
$school_id = $_SESSION["id"] ?? null;

$sql = "SELECT full_name, position FROM userinfo WHERE school_id = ?";
$stmt = $mysqli->prepare($sql);
$stmt->bind_param("i", $school_id);
$stmt->execute();
$result = $stmt->get_result();
$userr = $result->fetch_assoc();

if (!isset($_GET['id'])) {
    echo "No user selected.";
    exit();
}

$id = $mysqli->real_escape_string($_GET['id']);
$sql = "SELECT * FROM userinfo WHERE school_id = '$id'";
$result = $mysqli->query($sql);

if ($result->num_rows === 1) {
    $user = $result->fetch_assoc();
} else {
    echo "User not found.";
    exit();
}

$hasUnread = checkUnreadNotifications($mysqli);

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>SMART</title>
    <link href="../Style/MaintenanceHome.css" rel="stylesheet">
    <link href="../Style/ManageEdit.css" rel="stylesheet">
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

<a href="Notification.php"><img src="../Assets/notification<?= $hasUnread ? '1' : '' ?>.svg" class="logo <?= $hasUnread ? 'unread' : '' ?>" alt="Notifications" id="Notifications"></a>
            <a href="Settings.php"><img src="../Assets/settings.svg" class="logo" alt="Settings" id="Settings"></a>
        </div>

        <div class="user-info">
            <div class="user-top">
            <?php if (isset($fname) && isset($position)):  ?>

            <span class="username"><?= htmlspecialchars($userr["full_name"]) ?></span>
            <span class="position"><?= htmlspecialchars($userr["position"]) ?></span>

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

<div class="set">
<h2><b>Edit User</b></h2>
        <form action="../Authentication/Admin/edit.php" method="post">
            <input type="hidden" name="school_id" value="<?= htmlspecialchars($user['school_id']) ?>">

            <div class="mb-3">
                <label for="full_name" class="form-label">School ID or Phone Number</label> <br>
                <input type="text" name="school_id" class="form-control"
                oninput="this.value = this.value.replace(/[^0-9]/g, '').slice(0, 12);" 
                pattern="[0-9]{11,12}" minlength="11" maxlength="12"
                value="<?= htmlspecialchars($user['school_id']) ?>" required>
            </div>

            <div class="mb-3">
                <label for="full_name" class="form-label">Full Name</label> <br>
                <input type="text" name="full_name" class="form-control" value="<?= htmlspecialchars($user['full_name']) ?>" required>
            </div>

            <div class="mb-3">
                <label for="position" class="form-label">Position</label> <br>
                <select name="position" class="form-control" required>
                    <option value="Admin" <?= $user['position'] == 'Admin' ? 'selected' : '' ?>>Admin</option>
                    <option value="Maintenance Staff" <?= $user['position'] == 'Maintenance Staff' ? 'selected' : '' ?>>Maintenance Staff</option>
                    <option value="Student" <?= $user['position'] == 'Student' ? 'selected' : '' ?>>Student</option>
                    <option value="Teacher" <?= $user['position'] == 'Teacher' ? 'selected' : '' ?>>Teacher</option>
                </select>
            </div>

            <div class="mb-3">
                <label for="userstatus" class="form-label">Status</label> <br>
                <select name="userstatus" class="form-control" required>
                    <option value="Approved" <?= $user['userstatus'] == 'Approved' ? 'selected' : '' ?>>Approved</option>
                    <option value="Pending" <?= $user['userstatus'] == 'Pending' ? 'selected' : '' ?>>Pending</option>
                    <option value="Rejected" <?= $user['userstatus'] == 'Rejected' ? 'selected' : '' ?>>False Report</option>
                </select>
            </div>

            <button type="submit" class="btn" id="final">Update User</button>
            <a href="AdminHome.php" class="btn">Cancel</a>
        </form>
</div>


<script src="../JS/script4.js"></script>
</body>
</html>

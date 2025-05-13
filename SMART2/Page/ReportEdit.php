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

if ($_SESSION["position"] !== "Admin") {
    echo "<script>
    alert('You do not have permission to access this page.');
    window.location.href = '../index.php';
    </script>";
    exit();
}

$Testsql = require __DIR__ . "/../database.php";

$fname = $_SESSION["fname"];
$school_id = $_SESSION["id"] ?? null;

$sql = "SELECT full_name, position FROM userinfo WHERE school_id = ?";
$stmt = $Testsql->prepare($sql);
$stmt->bind_param("s", $school_id);
$stmt->execute();
$result = $stmt->get_result();
$user = $result->fetch_assoc();

$fname = $user["full_name"];
$position = $user["position"];

if (isset($_POST['add_location'])) {
    $newLocation = $_POST['location_name'];
    $addLocationQuery = "INSERT INTO problemlocations (problemloc) VALUES (?)";
    $stmt = $Testsql->prepare($addLocationQuery);
    $stmt->bind_param("s", $newLocation);
    if ($stmt->execute()) {
        echo "<script>
            document.addEventListener('DOMContentLoaded', function() {
                customAlert('Location added successfully!');
            });
            </script>";
    } else {
        echo "<script>
            document.addEventListener('DOMContentLoaded', function() {
                customAlert('Failed to add location.');
            });
            </script>";
    }
} elseif (isset($_POST['add_problem'])) {
    $newProblem = $_POST['problem_name'];
    $addProblemQuery = "INSERT INTO problemtypes (probtype) VALUES (?)";
    $stmt = $Testsql->prepare($addProblemQuery);
    $stmt->bind_param("s", $newProblem);
    if ($stmt->execute()) {
        echo "<script>
            document.addEventListener('DOMContentLoaded', function() {
                customAlert('Problem type added successfully!');
            });
            </script>";
    } else {
        echo "<script>
            document.addEventListener('DOMContentLoaded', function() {
                customAlert('Failed to add problem type.');
            });
            </script>";
    }
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

$hasUnread = checkUnreadNotifications($Testsql);

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>SMART</title>
    <link href="../Style/AdminHome.css" rel="stylesheet">
    <link href="../Style/Sidebar.css" rel="stylesheet">
    <link href="../Style/ReportEdit.css" rel="stylesheet">
    <link href="../Style/Navigationbar.css" rel="stylesheet">
</head>
<body>

<header class="sticky-header">
    <div class="header-container">
        <div class="logos">
        <img src="../Assets/companyl.svg" class="logo" alt="Dots" id="Dots">
            <?php
            switch ($position) {
                case "Admin":
                    ?>
                    <a href="AdminHome.php" class="logo-link"><img src="../Assets/home.svg" class="logo" alt="Home" id="Home"></a>
                    <a href="AdminHistory.php" class="logo-link"><img src="../Assets/history.svg" class="logo" alt="History" id="History"></a>
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
                    <a href="History.php" class="logo-link"><img src="../Assets/history.svg" class="logo" alt="History" id="History"></a>
                    <?php
                    break;
            
                default:
                    ?>
                    <a href="Home.php"><img src="../Assets/home.svg" class="logo" alt="Home" id="Home"></a>
                    <a href="History.php" class="logo-link"><img src="../Assets/history.svg" class="logo" alt="History" id="History"></a>
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
                <img src="../Assets/profile.png" id="proff">
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
            <p>In the coming years, we see ourselves as the global leader in school maintenance solutions, using cutting-edge real-time tracking technology to transform how schools manage their facilities. We are building SMART because we believe every school deserves a safe, well-maintained, and efficient environment for learning, ensuring a brighter future for students and educators everywhere. </p>
        </div>
        <div class="mission">
            <h4>Mission</h4>
            <p>Our mission is to provide schools with an innovative, user-friendly platform that simplifies maintenance management through real-time tracking and data-driven insights. We are committed to delivering reliable, efficient, and sustainable solutions that empower schools to optimize their operations, reduce costs, and create safer, more productive learning environments. What sets us apart is our dedication to use technology to solve real-world challenges, ensuring every school can focus on what matters most—educating future generations.</p>
        </div>
        <div class="contact">
            <h4>Contact Us</h4>
            <p>maintenics@gmail.com</p>
        </div>
    </div>
</div>

<div class="set">
    <h3>Add Location</h3>
    <form method="POST">
        <input type="text" name="location_name" placeholder="Enter Location" required>
        <button type="submit" name="add_location" class="btn" id="final">Add Location</button>
    </form>

    <h3>Add Problem Type</h3>
    <form method="POST">
        <input type="text" name="problem_name" placeholder="Enter Problem Type" required>
        <button type="submit" name="add_problem" class="btn" id="final">Add Problem Type</button>
    </form>

    <a href="AdminHome.php">Back to Dashboard</a>
</div>

    <div id="popup" style="display:none; position:fixed; top:20px; left:50%; transform:translateX(-50%); background: rgb(0, 123, 255); padding:10px 20px; border:1px solid rgb(38, 52, 177); border-radius:8px; z-index:10000; color:white; font-family: Roboto, sans-serif; box-shadow:0 0 10px rgba(0,0,0,0.1);">
        <span id="popup-message"></span>
    </div>

<script src="../JS/script.js"></script>
<script src="../JS/script3.js"></script>
<script src="../JS/script4.js"></script>
<script src="../JS/script6.js"></script>
<script src="../JS/script7.js"></script>
<script src="../JS/script8.js"></script>

</body>
</html>
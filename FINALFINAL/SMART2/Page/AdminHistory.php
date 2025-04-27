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

$sql = "SELECT problem, COUNT(problem) AS count 
        FROM reportdetails 
        GROUP BY problem 
        ORDER BY count DESC 
        LIMIT 3";
$stmt = $Testsql->prepare($sql);
$stmt->execute();
$topIssues = $stmt->get_result();

$sql = "SELECT plocation, COUNT(plocation) AS count 
        FROM reportdetails 
        GROUP BY plocation 
        ORDER BY count DESC 
        LIMIT 3";
$stmt = $Testsql->prepare($sql);
$stmt->execute();
$affectedLocations = $stmt->get_result();

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
$hasUnread = checkUnreadNotifications($mysqli);

$sql = "SELECT sname, 
               COUNT(report_id) AS completed_tasks, 
               AVG(rating) AS average_rating
        FROM reportdetails
        WHERE status = 'Resolved' 
          AND rating IS NOT NULL 
          AND sname <> ''
        GROUP BY sname
        ORDER BY average_rating DESC, completed_tasks DESC
        LIMIT 5";

$stmt = $Testsql->prepare($sql);
$stmt->execute();
$topStaff = $stmt->get_result();

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

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>SMART</title>
    <link rel="apple-touch-icon" sizes="180x180" href="../Assets/apple-touch-icon.png">
    <link rel="icon" type="image/png" sizes="32x32" href="../Assets/favicon-32x32.png">
    <link rel="icon" type="image/png" sizes="16x16" href="../Assets/favicon-16x16.png">
    <link rel="manifest" href="../Assets/site.webmanifest">
    <link href="../Style/AdminHistory.css" rel="stylesheet">
    <link href="../Style/Sidebar.css" rel="stylesheet">
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
                    <a href="MaintenanceHome.php" class="logo-link"><img src="../Assets/home.svg" class="logo" alt="Home" id="Home"></a>
                    <a href="History.php" class="logo-link"><img src="../Assets/history.svg" class="logo" alt="History" id="History"></a>
                    <?php
                    break;
            
                case "Student":
                case "Teacher":
                    ?>
                    <a href="Home.php" class="logo-link"><img src="../Assets/home.svg" class="logo" alt="Home" id="Home"></a>
                    <a href="History.php" class="logo-link"><img src="../Assets/history.svg" class="logo" alt="History" id="History"></a>
                    <?php
                    break;
            
                default:
                    ?>
                    <a href="Home.php" class="logo-link"><img src="../Assets/home.svg" class="logo" alt="Home" id="Home"></a>
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

		 <div class="container">
        <div class="title"><h2>Report History<h2></div>
        <div class="box">
            <div class="heading">Most Common Issues</div>
            <table class="table">
                <tr>
                    <th>Issue</th>
                    <th>Reported Times</th>
                </tr>
                    <?php 
                        $firstRow = true;

                        if ($topIssues->num_rows > 0) {
                            while ($row = $topIssues->fetch_assoc()) {
                                $highlightClass = $firstRow ? 'highlight' : '';
                                echo "<tr class='$highlightClass'>";
                                echo "<td>" . htmlspecialchars($row['problem']) . "</td>";
                                echo "<td>" . htmlspecialchars($row['count']) . "</td>";
                                echo "</tr>";
                                $firstRow = false;
                            }
                        } else {
                            echo "<tr><td colspan='2'>No reports available</td></tr>";
                        }
                    ?>
            </table>
        </div>

        <div class="box">
            <div class="heading">Most Affected Locations</div>
            <table class="table">
                <tr>
                    <th>Location</th>
                    <th>Times Reported</th>
                </tr>
                    <?php 
                        $firstRow = true;

                        if ($affectedLocations->num_rows > 0) {
                            while ($row = $affectedLocations->fetch_assoc()) {
                                $highlightClass = $firstRow ? 'highlight' : '';
                                echo "<tr class='$highlightClass'>";
                                echo "<td>" . htmlspecialchars($row['plocation']) . "</td>";
                                echo "<td>" . htmlspecialchars($row['count']) . "</td>";
                                echo "</tr>";
                                $firstRow = false;
                            }
                        } else {
                            echo "<tr><td colspan='2'>No reports available</td></tr>";
                        }
                    ?>
            </table>
        </div>

        <div class="box">
            <div class="heading">Most Rated Staff</div>
            <table class="table">
                <tr>
                    <th>Name</th>
                    <th>Completed Tasks</th>
                    <th>Average Rating</th>
                </tr>
                    <?php 
                        $firstRow = true;
                        if ($topStaff->num_rows > 0) {
                            while ($row = $topStaff->fetch_assoc()) {
                                $highlightClass = $firstRow ? 'highlight' : '';
                                echo "<tr class='$highlightClass'>";
                                echo "<td>" . htmlspecialchars($row['sname']) . "</td>";
                                echo "<td>" . htmlspecialchars($row['completed_tasks']) . "</td>";
                                echo "<td>" . number_format($row['average_rating'], 2) . "</td>";
                                echo "</tr>";
                                $firstRow = false;
                            }
                        } else {
                            echo "<tr><td colspan='3'>No ratings available</td></tr>";
                        }
                    ?>
            </table>
        </div>

    </div>

<script src="../JS/script.js"></script>
<script src="../JS/script4.js"></script>
<script src="../JS/script7.js"></script>
<script src="../JS/script6.js"></script>


</body>
</html>
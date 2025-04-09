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
if ($_SESSION["position"] !== "Maintenance Staff") {
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

$full_name = $user["full_name"] ?? "";
$first_name = explode(" ", trim($full_name))[0];

$sql = "SELECT report_id, rname, plocation, problem, pdescription, status, date_reported, sid 
        FROM reportdetails 
        ORDER BY 
            CASE 
                WHEN status = 'Ongoing' THEN 1 
                WHEN status = 'Pending' THEN 2 
                ELSE 3 
            END, 
            CASE 
                WHEN status IN ('Ongoing', 'Pending') THEN date_reported 
                ELSE NULL 
            END ASC, 
            CASE 
                WHEN status NOT IN ('Ongoing', 'Pending') THEN date_reported 
                ELSE NULL 
            END DESC";

$result = $Testsql->query($sql);

if ($result->num_rows > 0) {
    $reports = $result->fetch_all(MYSQLI_ASSOC);
} else {
    $reports = [];
}

$totalReports = count($reports);
$pendingReports = 0;
$resolvedReports = 0;

// Count pending and resolved reports
foreach ($reports as $report) {
    if (strtolower($report['status']) === 'pending') {
        $pendingReports++;
    } elseif (strtolower($report['status']) === 'resolved') {
        $resolvedReports++;
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

$hasUnread = checkUnreadNotifications($mysqli);

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['take_action'])) {
    $reportId = $_POST['report_id'];
    $status = 'Ongoing';
    $sid = $_SESSION['id'];
    $sname = $_SESSION['fname'];

    // Update the report's status to "Ongoing" and assign staff member
    $sql = "UPDATE reportdetails SET status = ?, sname = ?, sid = ? WHERE report_id = ?";
    $stmt = $Testsql->prepare($sql);
    $stmt->bind_param("ssii", $status, $sname, $sid, $reportId);
    $stmt->execute();

    echo "<script>
    document.addEventListener('DOMContentLoaded', function() {
        customAlert('Report marked ongoing!');
    });
    setTimeout(function() {
        window.location.href = 'MaintenanceHome.php';
    }, 1000);

    </script>";
}

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['mark_resolved'])) {
    $reportId = $_POST['report_id'];
    $status = 'Resolved'; // Update status to 'Resolved'
    $sid = $_SESSION['id'];
    $sname = $_SESSION['fname'];

    // Update the report's status to "Resolved" and assign staff member (optional)
    $sql = "UPDATE reportdetails SET status = ?, date_resolved = NOW() WHERE report_id = ?";
    $stmt = $Testsql->prepare($sql);
    $stmt->bind_param("si", $status, $reportId);
    
    $stmt->execute();

    echo "<script>
    document.addEventListener('DOMContentLoaded', function() {
        customAlert('Report resolved!');
    });
    setTimeout(function() {
        window.location.href = 'MaintenanceHome.php';
    }, 1000);

    </script>";
}

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['reject_report'])) {
    $reportId = $_POST['report_id'];
    $status = 'Rejected'; // Update status to 'Rejected'

    // Update the report's status to "Rejected"
    $sql = "UPDATE reportdetails SET status = ? WHERE report_id = ?";
    $stmt = $Testsql->prepare($sql);
    $stmt->bind_param("si", $status, $reportId);
    $stmt->execute();

    echo "<script>
    document.addEventListener('DOMContentLoaded', function() {
        customAlert('Report marked as false.');
    });
    setTimeout(function() {
        window.location.href = 'MaintenanceHome.php';
    }, 1000);

    </script>";
}

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>SMART</title>
    <link href="../Style/MaintenanceHome.css" rel="stylesheet">
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
                    <a href="AdminHome.php"><img src="../Assets/home.svg" class="logo" alt="Home" id="Home"></a>
                    <a href="AdminHistory.php"><img src="../Assets/history.svg" class="logo" alt="History" id="History"></a>
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

<p id="greet">Good day, <?= htmlspecialchars($first_name) ?>! Got a problem? Solve it with SMART!</p>

<div class="dashboard">
    <div class="card">
        <h3>Total Reports</h3>
        <p><?= $totalReports; ?></p>
    </div>
    <div class="separator"></div>
    <div class="card">
        <h3>Pending Reports</h3>
        <p><?= $pendingReports; ?></p>
    </div>
    <div class="separator"></div>
    <div class="card">
        <h3>Resolved Reports</h3>
        <p><?= $resolvedReports; ?></p>
    </div>
</div>

<div class="row" id="main1">
    <table style="width: 95%; height: 95%; margin-right: auto; margin-block: 2%;">

        <tr>
            <th class="cth">Report ID</th>
            <th class="cth">Date Reported</th>
            <th class="cth">Location</th>
            <th class="cth">Problem</th>
            <th class="cth">Description</th>
            <th class="cth">Status</th>
            <th class="cth">Action</th>
        </tr>
        <?php foreach ($reports as $report): ?>
        <tr>
            <td><?= $report['report_id']; ?></td>
            <td><?= $report['date_reported']; ?></td>
            <td><?= $report['plocation']; ?></td>
            <td><?= $report['problem']; ?></td>
            <td><?= !empty($report['pdescription']) ? htmlspecialchars($report['pdescription']) : 'No description given.'; ?></td></td>
            <td><?= $report['status']; ?></td>
            <td>
                <?php if ($report['status'] === 'Pending'): ?>
                    <form method="POST" action="">
                        <input type="hidden" name="report_id" value="<?= $report['report_id']; ?>">
                        <button type="submit" name="take_action" class="take-action-btn">Take Action</button>
                    </form>
                <?php elseif ($report['status'] === 'Ongoing' && $report['sid'] == $_SESSION['id']): ?>
                    <form method="POST" action="">
                        <input type="hidden" name="report_id" value="<?= $report['report_id']; ?>">
                        <button type="submit" name="mark_resolved" class="resolved-btn">Mark as Resolved</button>
                        <button type="submit" name="reject_report" class="reject-btn" id="reject_<?= $report['report_id']; ?>">False Report</button>
                    </form>
                <?php endif; ?>
            </td>
        </tr>
        <?php endforeach; ?>

    </table>
</div>

<div id="popup" style="display:none; position:fixed; top:20px; left:50%; transform:translateX(-50%); background: rgb(0, 123, 255); padding:10px 20px; border:1px solid rgb(38, 52, 177); border-radius:8px; z-index:10000; color:white; font-family: Roboto, sans-serif; box-shadow:0 0 10px rgba(0,0,0,0.1);">
        <span id="popup-message"></span>
    </div>

<script src="../JS/script.js"></script>
<script src="../JS/script4.js"></script>
<script src="../JS/script5.js"></script>
<script src="../JS/script6.js"></script>
<script src="../JS/script7.js"></script>
<script src="../JS/script8.js"></script>

</body>
</html>

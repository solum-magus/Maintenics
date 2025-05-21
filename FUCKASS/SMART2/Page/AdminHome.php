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

$userQuery = "SELECT full_name, school_id, position, userstatus FROM userinfo";
$userResult = $Testsql->query($userQuery);

$totalReportsQuery = "SELECT COUNT(*) AS total FROM reportdetails";
$totalReportsResult = $Testsql->query($totalReportsQuery);
$totalReports = $totalReportsResult->fetch_assoc()['total'] ?? 0;

$inProgressQuery = "SELECT COUNT(*) AS in_progress FROM reportdetails WHERE status = 'Ongoing' OR 'Pending'";
$inProgressResult = $Testsql->query($inProgressQuery);
$inProgressReports = $inProgressResult->fetch_assoc()['in_progress'] ?? 0;

$latestReportQuery = "SELECT problem, plocation FROM reportdetails ORDER BY report_id DESC LIMIT 1";
$latestReportResult = $Testsql->query($latestReportQuery);
$latestReport = $latestReportResult->fetch_assoc();

$sql = "SELECT report_id, rname, plocation, problem, date_reported, sid, pdescription, status FROM reportdetails";
$result = $Testsql->query($sql);

if ($result->num_rows > 0) {
    $reports = $result->fetch_all(MYSQLI_ASSOC);
} else {
    $reports = [];
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

    $sql = "UPDATE reportdetails SET status = ?, sname = ?, sid = ? WHERE report_id = ?";
    $stmt = $Testsql->prepare($sql);
    $stmt->bind_param("ssii", $status, $sname, $sid, $reportId);
    $stmt->execute();

    echo "<script>
    document.addEventListener('DOMContentLoaded', function() {
        customAlert('Report marked ongoing!');
    });
    setTimeout(function() {
        window.location.href = 'AdminHome.php';
    }, 1000);

    </script>";
}

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['mark_resolved'])) {
    $reportId = $_POST['report_id'];
    $status = 'Resolved'; 
    $sid = $_SESSION['id'];
    $sname = $_SESSION['fname'];

    $sql = "UPDATE reportdetails SET status = ?, date_resolved = NOW() WHERE report_id = ?";
    $stmt = $Testsql->prepare($sql);
    $stmt->bind_param("si", $status, $reportId);
    
    $stmt->execute();

    echo "<script>
    document.addEventListener('DOMContentLoaded', function() {
        customAlert('Report resolved!');
    });
    setTimeout(function() {
        window.location.href = 'AdminHome.php';
    }, 1000);

    </script>";
}

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['reject_report'])) {
    $reportId = $_POST['report_id'];
    $status = 'Rejected'; 

    $sql = "UPDATE reportdetails SET status = ? WHERE report_id = ?";
    $stmt = $Testsql->prepare($sql);
    $stmt->bind_param("si", $status, $reportId);
    $stmt->execute();

    echo "<script>
    document.addEventListener('DOMContentLoaded', function() {
        customAlert('Report marked as false.');
    });
    setTimeout(function() {
        window.location.href = 'AdminHome.php';
    }, 1000);

    </script>";
}

$problemdetailQuery = "SELECT * FROM problemlocations";
$problemdetailResult = $Testsql->query($problemdetailQuery);

$problemdetail2Query = "SELECT * FROM problemtypes";
$problemdetail2Result = $Testsql->query($problemdetailQuery);

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    if (isset($_POST['delete']) && isset($_POST['id'])) {
        $type = $_POST['delete']; 
        $id = $_POST['id']; 

        if ($type === "location") {
            $deleteQuery = "DELETE FROM problemlocations WHERE problemloc = ?";
        } elseif ($type === "problem") {
            $deleteQuery = "DELETE FROM problemtypes WHERE probtype = ?";
        }

        if (isset($deleteQuery)) {
            $stmt = $Testsql->prepare($deleteQuery);
            $stmt->bind_param("s", $id);
            $stmt->execute();

            if ($stmt->affected_rows > 0) {
                echo "<script>document.addEventListener('DOMContentLoaded', function() {
                        customAlert('Successfully deleted record!');
                    });</script>";
            } else {
                echo "<script>document.addEventListener('DOMContentLoaded', function() {
                        customAlert('Error with deleting record.');
                    });</script>";
            }
        }
    }
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

    <link href="../Style/AdminHome.css" rel="stylesheet">
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

		<div class="dashboard">
        <div class="card">
            <h3>User Management</h3>
            <p>Manage student and staff accounts</p>
            <div class="setting-choice" id="manageUserBtn">View all</div>
        </div>
        <div class="card" id="a">
            <p><b>Total Reports</b></p>
            <p><?= $totalReports ?></p>
        </div>
        <div class="card" id="b">
            <p><b>Reports In Progress</b></p>
            <p><?= $inProgressReports ?></p>
        </div>
        <div class="card">
            <h3>Latest Report</h3>
            <p><?= $latestReport ? htmlspecialchars($latestReport['problem']) . " - " . htmlspecialchars($latestReport['plocation']) : "No reports available" ?></p>
            <div class="setting-choice" id="viewReportBtn">View all</div>
        </div>
        <div class="card">
            <h3>Report Form</h3>
            <p>Set Report Form Options</p>
            <div class="setting-choice" id="setReportBtn">Set Up</div>
        </div>
    </div>

    <div id="manageModal" style= "display: none;" class="modal">
            <div class="modal-content">
                <span class="close">&times;</span>
                <table>
                    <thead>
                        <tr>
                            <th>Actions</th>
                            <th>Full Name</th>
                            <th>School ID</th>
                            <th>Position</th>
                            <th>Status</th>
                        </tr>
                    </thead>
                    <tbody>
                    <?php while ($row = $userResult->fetch_assoc()): ?>
                        <tr>
                            <td>
                                <a href="ManageEdit.php?id=<?= $row['school_id'] ?>" class="button">Edit</a>
                                <a href="../Authentication/Admin/delete.php?id=<?= $row['school_id'] ?>" class="button"
                                    onclick="return confirm('This action is irreversible, are you sure you want to delete this user?');">Delete</a>
                            </td>
                            <td><?= htmlspecialchars($row['full_name']) ?></td>
                            <td><?= htmlspecialchars($row['school_id']) ?></td>
                            <td><?= htmlspecialchars($row['position']) ?></td>
                            <td><?= htmlspecialchars($row['userstatus']) ?></td>
                        </tr>
                    <?php endwhile; ?>
                    </tbody>
                </table>
            </div>
    </div>

    <div id="reportModal" style= "display: none;" class="modal">
            <div class="modal-content">
                <span class="close">&times;</span>
        <?php $selectedStatus = $_GET['problem'] ?? ''; ?>
                <div class="row" id="main1">
    <table style="height: 95%; margin-right: auto; margin-block: 2%;">

        <tr>
            <th class="cth">Action</th>
            <th class="cth">Status</th>
            <th class="cth">Report ID</th>
            <th class="cth">Date Reported</th>
            <th class="cth">Location</th>
            <th class="cth">Problem</th>
            <th class="cth">Description</th>
        </tr>
        <?php foreach ($reports as $report): ?>
        <tr>
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
                        <br>
                        <button type="submit" name="reject_report" class="reject-btn" id="reject_<?= $report['report_id']; ?>">False Report</button>
                    </form>
                <?php endif; ?>
            </td>
            <td class="<?= strtolower($report['status']) ?>"><?= $report['status']; ?></td>
            <td><?= $report['report_id']; ?></td>
            <td><?= $report['date_reported']; ?></td>
            <td><?= $report['plocation']; ?></td>
            <td><?= $report['problem']; ?></td>
            <td><?= !empty($report['pdescription']) ? htmlspecialchars($report['pdescription']) : 'No description given.'; ?></td></td> 
        </tr>
        <?php endforeach; ?>

    </table>
</div>
            </div>
    </div>

    <div id="setupModal" style="display: none;" class="modal">
    <div class="modal-content">
        <span class="close">&times;</span>
        <table>
            <thead>
                <tr>
                    <th>Location List</th>
                    <th>Action</th>
                </tr>
            </thead>
            <tbody>
            <?php
            $locationQuery = "SELECT * FROM problemlocations WHERE problemloc IS NOT NULL";
            $locationResult = $Testsql->query($locationQuery);
            while ($row = $locationResult->fetch_assoc()) {
                echo '<tr>';
                echo '<td>' . htmlspecialchars($row['problemloc']) . '</td>';
                echo '<td><form method="POST" action="AdminHome.php">
                        <input type="hidden" name="delete" value="location">
                        <input type="hidden" name="id" value="' . htmlspecialchars($row['problemloc']) . '">
                        <button type="submit" class="button" onclick="return confirm(\'Are you sure?\')">Delete</button>
                    </form></td>';
                echo '</tr>';
            }
            ?>
                <td colspan="2">
                    <a href="ReportEdit.php" class="button">Add Location</a>
                </td>
            </tbody>
        </table>

        <table>
            <thead>
                <tr>
                    <th>Problem Type</th>
                    <th>Action</th>
                </tr>
            </thead>
            <tbody>
            <?php
                $problemQuery = "SELECT * FROM problemtypes WHERE probtype IS NOT NULL";
                $problemResult = $Testsql->query($problemQuery);
                while ($row = $problemResult->fetch_assoc()) {
                    echo '<tr>';
                    echo '<td>' . htmlspecialchars($row['probtype']) . '</td>';
                    echo '<td><form method="POST" action="AdminHome.php">
                            <input type="hidden" name="delete" value="problem">
                            <input type="hidden" name="id" value="' . htmlspecialchars($row['probtype']) . '">
                            <button type="submit" class="button" onclick="return confirm(\'Are you sure?\')">Delete</button>
                        </form></td>';
                    echo '</tr>';
                }
                ?>
                <td colspan="2">
                    <a href="ReportEdit.php" class="button">Add Problem Type</a>
                </td>
            </tbody>
        </table>
        </div>
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

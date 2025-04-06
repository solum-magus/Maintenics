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

$inProgressQuery = "SELECT COUNT(*) AS in_progress FROM reportdetails WHERE status = 'Pending'";
$inProgressResult = $Testsql->query($inProgressQuery);
$inProgressReports = $inProgressResult->fetch_assoc()['in_progress'] ?? 0;

$latestReportQuery = "SELECT problem, plocation FROM reportdetails ORDER BY report_id DESC LIMIT 1";
$latestReportResult = $Testsql->query($latestReportQuery);
$latestReport = $latestReportResult->fetch_assoc();

$sql = "SELECT report_id, rname, plocation, problem, pdescription, status FROM reportdetails";
$result = $Testsql->query($sql);

if ($result->num_rows > 0) {
    $reports = $result->fetch_all(MYSQLI_ASSOC);
} else {
    $reports = [];
}

$hasUnread = checkUnreadNotifications($mysqli);

$problemdetailQuery = "SELECT * FROM problemlocations";
$problemdetailResult = $Testsql->query($problemdetailQuery);

$problemdetail2Query = "SELECT * FROM problemtypes";
$problemdetail2Result = $Testsql->query($problemdetailQuery);

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    if (isset($_POST['delete']) && isset($_POST['id'])) {
        $type = $_POST['delete']; // location or problem
        $id = $_POST['id']; // location or problem ID

        // Process deletion
        if ($type === "location") {
            $deleteQuery = "DELETE FROM problemlocations WHERE problemloc = ?";
        } elseif ($type === "problem") {
            $deleteQuery = "DELETE FROM problemtypes WHERE probtype = ?";
        }

        if (isset($deleteQuery)) {
            // Prepare and execute the deletion query
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
    <link href="../Style/AdminHome.css" rel="stylesheet">
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
            <?php if (isset($fname) && isset($position)):  ?>

            <span class="username"><?= htmlspecialchars($user["full_name"]) ?></span>
            <span class="position"><?= htmlspecialchars($user["position"]) ?></span>

            <?php else: ?>

            <span class="username">NULL</span>
            <span class="position">NULL</span>

            <?php endif; ?>

            <select class="dropdown" id="profileDropdown" onchange="handleProfileChange(this.value)">
                    <option value="" disabled>Profile</option>
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
                            <th>Full Name</th>
                            <th>School ID</th>
                            <th>Position</th>
                            <th>Status</th>
                            <th>Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                    <?php while ($row = $userResult->fetch_assoc()): ?>
                        <tr>
                            <td><?= htmlspecialchars($row['full_name']) ?></td>
                            <td><?= htmlspecialchars($row['school_id']) ?></td>
                            <td><?= htmlspecialchars($row['position']) ?></td>
                            <td><?= htmlspecialchars($row['userstatus']) ?></td>
                            <td>
                                <a href="ManageEdit.php?id=<?= $row['school_id'] ?>" class="button">Edit</a>
                                <a href="../Authentication/Admin/delete.php?id=<?= $row['school_id'] ?>" class="button"
                                    onclick="return confirm('This action is irreversible, are you sure you want to delete this user?');">Delete</a>
                            </td>
                        </tr>
                    <?php endwhile; ?>
                    </tbody>
                </table>
            </div>
    </div>

    <div id="reportModal" style= "display: none;" class="modal">
            <div class="modal-content">
                <span class="close">&times;</span>
                <table>
                    <thead>
                        <tr>
                            <th>Report ID</th>
                            <th>From</th>
                            <th>Location</th>
                            <th>Problem</th>
                            <th>Description</th>
                            <th>Status</th>
                        </tr>
                    </thead>
                    <tbody>
                    <?php if (!empty($reports)): ?>
                        <?php foreach ($reports as $row): ?>
                        <tr>
                            <td><?= htmlspecialchars($row['report_id']) ?></td>
                            <td><?= htmlspecialchars($row['rname']) ?></td>
                            <td><?= htmlspecialchars($row['plocation']) ?></td>
                            <td><?= htmlspecialchars($row['problem']) ?></td>
                            <td><?= htmlspecialchars($row['pdescription']) ?></td>
                            <td><?= htmlspecialchars($row['status']) ?></td>
                        </tr>
                        <?php endforeach; ?>
                    <?php else: ?>
                        <tr>
                            <td colspan="6">No reports available</td>
                        </tr>
                    <?php endif; ?>
                    </tbody>
                </table>
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

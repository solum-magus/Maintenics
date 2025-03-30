<?php
session_start();

if (!isset($_SESSION["position"]) || !isset($_SESSION["fname"]) || !isset($_SESSION["id"])) {
    echo "<script>
    alert('You are not logged in!');
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

$sql = "SELECT report_id, rname, plocation, problem, pdescription FROM reportdetails";
$result = $Testsql->query($sql);

if ($result->num_rows > 0) {
    $reports = $result->fetch_all(MYSQLI_ASSOC);
} else {
    $reports = [];
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

		<div class="dashboard">
        <div class="card">
            <h3>User Management</h3>
            <p>Manage student and staff accounts</p>
            <div class="setting-choice" id="manageUserBtn">View all</div>
        </div>
        <div class="card">
            <h3>Total Reports</h3>
            <p><?= $totalReports ?></p>
        </div>
        <div class="card">
            <h3>Reports In Progress</h3>
            <p><?= $inProgressReports ?></p>
        </div>
        <div class="card">
            <h3>Latest Report</h3>
            <p><?= $latestReport ? htmlspecialchars($latestReport['problem']) . " - " . htmlspecialchars($latestReport['plocation']) : "No reports available" ?></p>
            <a href="#" class="view-btn">View all</a>
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


<script src="../JS/script.js"></script>
<script src="../JS/script3.js"></script>
<script src="../JS/script4.js"></script>
</body>
</html>

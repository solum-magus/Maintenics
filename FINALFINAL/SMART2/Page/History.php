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

if ($_SESSION["position"] === "Admin") {
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

$selectedProblem = $_GET['problem'] ?? '';
$selectedDate = $_GET['date'] ?? '';

$sql = "SELECT report_id, problem, date_reported, date_resolved, status, rating, feedback 
        FROM reportdetails 
        WHERE status = 'Resolved'";

$conditions = [];
$paramTypes = "";
$params = [];

if ($position !== "Maintenance Staff") {
    $conditions[] = "rid = ?";
    $paramTypes .= "i";
    $params[] = $rid;
}
if (!empty($selectedProblem)) {
    $conditions[] = "problem = ?";
    $paramTypes .= "s";
    $params[] = $selectedProblem;
}
if (!empty($selectedDate)) {
    $conditions[] = "DATE(date_reported) = ?";
    $paramTypes .= "s";
    $params[] = $selectedDate;
}

if (!empty($conditions)) {
    $sql .= " AND " . implode(" AND ", $conditions);
}

$sql .= " ORDER BY report_id DESC";

$stmt = $Testsql->prepare($sql);

if (!empty($params)) {
    $stmt->bind_param($paramTypes, ...$params);
}

$stmt->execute();
$Report = $stmt->get_result();
$reports = $Report->fetch_all(MYSQLI_ASSOC);

$hasUnread = checkUnreadNotifications($Testsql);

$ptype = [];
if ($result) {
    while ($row = $result->fetch_assoc()) {
        $locations[] = $row['probtype'];
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

// Set the active page based on the current page
$current_page = $_SESSION['active_page'] ?? basename($_SERVER['PHP_SELF']);
$_SESSION['active_page'] = $current_page;  // Ensure the active page is updated in session.

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
    <link href="../Style/History.css" rel="stylesheet">
    <link href="../Style/Sidebar.css" rel="stylesheet">
    <link href="../Style/Navigationbar.css" rel="stylesheet">
</head>
<body>

<header class="sticky-header">
    <div class="header-container">
        <div class="logos">
            <img src="../Assets/companyl.svg" class="logo" alt="Dots" id="Dots">

            <?php
            // Set the home page link based on position
            $homePage = ($position == "Admin") ? "AdminHome.php" : (($position == "Maintenance Staff") ? "MaintenanceHome.php" : "Home.php");
            ?>

            <a href="<?= $homePage ?>" class="logo-link <?= ($current_page === 'Home.php') ? 'active' : '' ?>" id="HomeLink">
                <img src="../Assets/home.svg" class="logo" alt="Home" id="Home">
            </a>
            <a href="History.php" class="logo-link <?= ($current_page === 'History.php') ? 'active' : '' ?>" id="HistoryLink">
                <img src="../Assets/history.svg" class="logo" alt="History" id="History">
            </a>
            <a href="Notification.php" class="logo-link <?= ($current_page === 'Notification.php') ? 'active' : '' ?>" id="NotificationLink">
                <img src="../Assets/notification.svg" class="logo <?= $hasUnread ? 'unread' : '' ?>" alt="Notifications" id="Notifications">
            </a>
            <a href="Settings.php" class="logo-link <?= ($current_page === 'Settings.php') ? 'active' : '' ?>" id="SettingsLink">
                <img src="../Assets/settings.svg" class="logo" alt="Settings" id="Settings">
            </a>
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
            <p>In the coming years, we see ourselves as the global leader in school maintenance solutions...</p>
        </div>
        <div class="mission">
            <h4>Mission</h4>
            <p>Our mission is to provide schools with an innovative, user-friendly platform that simplifies maintenance management...</p>
        </div>
        <div class="contact">
            <h4>Contact Us</h4>
            <p>maintenics@gmail.com</p>
        </div>
    </div>
</div>

<div class="filters">
    <form method="GET" action="History.php">
        <label for="problem">Filter by Problem:</label>
        <select id="problem" name="problem">
            <option value="" selected>All</option>
            <?php
            $probQuery = "SELECT DISTINCT probtype FROM problemtypes ORDER BY probtype ASC";
            $probResult = $Testsql->query($probQuery);

            if ($probResult && $probResult->num_rows > 0) {
                while ($row = $probResult->fetch_assoc()) {
                    $prob = htmlspecialchars($row['probtype']);
                    $selected = ($selectedProblem === $prob) ? "selected" : "";
                    echo "<option value=\"$prob\">$prob</option>";
                }
            }
            ?>
        </select>

        <label for="date">Filter by Date:</label>
        <input type="date" id="date" name="date" value="<?= htmlspecialchars($selectedDate) ?>">

        <button type="submit" id="btn">Go</button>
    </form>
</div>

<div class="report-h">
    <h1>Report History</h1>
</div>

<?php if (!empty($reports)): ?>
    <?php foreach ($reports as $report): ?>
        <div class="box report <?= strtolower($report['status']) ?>">
            <div class="report-container">
                <div>
                    <h3 class="overlayt" id="status-text">Status: <?= htmlspecialchars($report['status']) ?></h3>
                    <p>Report ID: <?= $report['report_id'] ?></p>
                    <p>Problem: <?= $report['problem'] ?></p>
                    <p>Date Reported: <?= $report['date_reported'] ?></p>
                    <p>Date Resolved: <?= $report['date_resolved'] ?: "Not yet resolved" ?></p>
                </div>
                
                <?php if ($position != "Maintenance Staff" && empty($report['feedback'])) : ?>
                    <div class="feedback-form">
                        <form method="POST" action="../Authentication/sendfeedback.php">
                            <input type="hidden" name="report_id" value="<?= $report['report_id'] ?>">
                            <textarea name="feedback" id="feedback" placeholder="Leave your feedback here..." rows="4"></textarea>

                            <div class="rating">
                                <?php for ($i = 5; $i >= 1; $i--) : ?>
                                    <input type="radio" name="rating<?= $report['report_id'] ?>" id="rating<?= $i ?>_<?= $report['report_id'] ?>" value="<?= $i ?>" <?= ($i == $report['rating']) ? 'checked' : '' ?>>
                                    <label for="rating<?= $i ?>_<?= $report['report_id'] ?>">
                                        <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 576 512" width="24" height="24">
                                            <path d="M316.9 18C311.6 7 300.4 0 288.1 0s-23.4 7-28.8 18L195 150.3 51.4 171.5c-12 1.8-22 10.2-25.7 21.7s-.7 24.2 7.9 32.7L137.8 329 113.2 474.7c-2 12 3 24.2 12.9 31.3s23 8 33.8 2.3l128.3-68.5 128.3 68.5c10.8 5.7 23.9 4.9 33.8-2.3s14.9-19.3 12.9-31.3L438.5 329 542.7 225.9c8.6-8.5 11.7-21.2 7.9-32.7s-13.7-19.9-25.7-21.7L381.2 150.3 316.9 18z"/>
                                        </svg>
                                    </label>
                                <?php endfor; ?>
                            </div>
                            <button type="submit" name="submit_feedback" id="feedbackbutton">Submit</button>
                        </form>
                    </div>
                <?php else: ?>
                    <p class="feedback-submitted"><b>Feedback:</b> <?= $report['feedback'] ? '"' . htmlspecialchars($report['feedback']) . '"' : "No feedback given." ?></p>
                <?php endif; ?>
            </div>
        </div>
    <?php endforeach; ?>
<?php else: ?>
    <p class="feedback-submitted" style="display: flex; justify-content: center; align-self: center;"><b>No recent reports.</b></p>
<?php endif; ?>

<?php
if (isset($_SESSION['just_logged_in'])): ?>
    <script>
        localStorage.setItem('activeTab', 'Home');
    </script>
    <?php unset($_SESSION['just_logged_in']); ?>
<?php endif; ?>

<script src="../JS/script1.js"></script>
<script src="../JS/script4.js"></script>
<script src="../JS/script6.js"></script>
<script src="../JS/script7.js"></script>

</body>
</html>

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

// Retrieve filters from GET parameters
$selectedProblem = $_GET['problem'] ?? '';
$selectedDate = $_GET['date'] ?? '';

// Base SQL query
$sql = "SELECT report_id, problem, date_reported, date_resolved, status, rating, feedback 
        FROM reportdetails
        WHERE status = 'Resolved'
        ORDER BY report_id DESC";

// If user is not maintenance staff, filter by `rid`
if ($position !== "Maintenance Staff") {
    $sql .= " AND rid = ?";
}

// Apply additional filters if selected
if (!empty($selectedProblem)) {
    $sql .= " AND problem = ?";
}
if (!empty($selectedDate)) {
    $sql .= " AND DATE(date_reported) = ?";
}

// Prepare statement
$stmt = $Testsql->prepare($sql);

// Bind parameters dynamically
$paramTypes = "";
$params = [];

if ($position !== "Maintenance Staff") {
    $paramTypes .= "i";
    $params[] = $rid;
}
if (!empty($selectedProblem)) {
    $paramTypes .= "s";
    $params[] = $selectedProblem;
}
if (!empty($selectedDate)) {
    $paramTypes .= "s";
    $params[] = $selectedDate;
}

// Bind parameters if needed
if (!empty($params)) {
    $stmt->bind_param($paramTypes, ...$params);
}

$stmt->execute();
$Report = $stmt->get_result();
$reports = $Report->fetch_all(MYSQLI_ASSOC);

$hasUnread = checkUnreadNotifications($mysqli);

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>SMART</title>
    <link href="../Style/History.css" rel="stylesheet">
    <link href="../Style/Sidebar.css" rel="stylesheet">
</head>
<body>

<header class="sticky-header">
    <div class="header-container">
    <div class="logos">
    <img src="../Assets/dots.svg" class="logo" alt="Dots" id="Dots">
    
    <?php
    $homePage = ($position == "Admin") ? "AdminHome.php" : (($position == "Maintenance Staff") ? "MaintenanceHome.php" : "Home.php");
    ?>
    <a href="<?= $homePage ?>" class="logo-link" id="HomeLink"><img src="../Assets/home.svg" class="logo" alt="Home" id="Home"></a>
    <a href="History.php" class="logo-link" id="HistoryLink"><img src="../Assets/history.svg" class="logo" alt="History" id="History"></a>
    <a href="Notification.php" class="logo-link" id="NotificationLink"><img src="../Assets/notification.svg" class="logo <?= $hasUnread ? 'unread' : '' ?>" alt="Notifications" id="Notifications"></a>
    <a href="Settings.php" class="logo-link" id="SettingsLink"><img src="../Assets/settings.svg" class="logo" alt="Settings" id="Settings"></a>
</div>
        <div class="user-info">
            <div class="user-top">
                <span class="username"><?= htmlspecialchars($user["full_name"] ?? "NULL") ?></span>
                <span class="position"><?= htmlspecialchars($user["position"] ?? "NULL") ?></span>
                <select class="dropdown" id="profileDropdown" onchange="handleProfileChange(this.value)">
                    <option value="" disabled selected>Profile</option>
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

<div class="filters">
<form method="GET" action="History.php">
        <label for="problem">Filter by Problem:</label>
        <select id="problem" name="problem">
            <option value="">All</option>
            <option value="TV" <?= ($selectedProblem === "TV") ? "selected" : "" ?>>TV</option>
            <option value="Broken Chair" <?= ($selectedProblem === "Broken Chair") ? "selected" : "" ?>>Broken Chair</option>
            <option value="No Wi-Fi" <?= ($selectedProblem === "No Wi-Fi") ? "selected" : "" ?>>No Wi-Fi</option>
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
                            <textarea name="feedback" placeholder="Leave your feedback here..." rows="4"></textarea>
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
    <p class="feedback-submitted"><b>No recent reports.</p>
<?php endif; ?>

<script src="../JS/script1.js"></script>
<script src="../JS/script4.js"></script>
<script src="../JS/script6.js"></script>
<script src="../JS/script7.js"></script>
</body>
</html>

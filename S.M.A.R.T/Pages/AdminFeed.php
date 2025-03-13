<?php
session_start();

// Check if user is logged in
if (!isset($_SESSION["position"])) {
    echo "<script>
    alert('You are not logged in!');
    window.location.href = '../index.html';
    </script>";
    exit();
}

$Testsql = require __DIR__ . "/../database.php";

// Fetch pending reports
$sql = "SELECT report_id, problem, date_reported FROM reportdetails WHERE status = 'Resolved' ";
$result = $Testsql->query($sql);

if ($result->num_rows > 0) {
    $pendingReports = $result->fetch_all(MYSQLI_ASSOC);
} else {
    $pendingReports = []; // Ensure it's always defined
}

// Fetch feedback
$sql = "SELECT report_id, feedback, rating FROM reportdetails";
$result = $Testsql->query($sql);

if ($result->num_rows > 0) {
    $sent = $result->fetch_all(MYSQLI_ASSOC);
} else {
    $sent = [];
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <title>SMART</title>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet"
        integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
        <link href="https://fonts.googleapis.com/css2?family=Merriweather:ital,wght@0,300;0,400;0,700;0,900;1,300;1,400;1,700;1,900&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="../Style/AdminFeed.css">
    <link rel="stylesheet" href="../Style/Sidebar.css">
</head>

<body>
    <div class="d-flex">
        <aside id="sidebar" class="sidebar-toggle">
            
        <div class="sidebar-header">
        <a href="#" class="sidebar-logo">S.M.A.R.T.</a>
        <button class="toggler-btn">
            <i><img src="../Assets/menu.svg"></i>
        </button>
        </div>
            <ul class="sidebar-nav p-0">

                <li class="sidebar-item">
                    <a href="Profile.php" class="sidebar-link">
                    <i><img src="../Assets/profile.svg"></i>
                    <span>User Profile</span>
                    </a>
                </li>

                <li class="sidebar-item">

                    <?php if ($_SESSION["position"] == "Admin" || $_SESSION["position"] == "Maintenance Staff"): ?>
                        <a href="Admin.php" class="sidebar-link">
                            <i><img src="../Assets/home.svg"></i>
                            <span>Home</span>
                        </a>

                    <?php else: ?>
                        <a href="Homepage.php" class="sidebar-link">
                            <i><img src="../Assets/home.svg"></i>
                            <span>Home</span>
                        </a>
                    <?php endif ?>
                </li>

                <li class="sidebar-item">
                    <a href="History.php" class="sidebar-link">
                    <i><img src="../Assets/history.svg"></i>
                    <span>History</span>
                    </a>
                </li>

                <li class="sidebar-item">
                    <a href="Notification.php" class="sidebar-link">
                    <i><img src="../Assets/notification.svg"></i>
                    <span>Notifications</span>
                    </a>
                </li>

            <?php if($_SESSION["position"] == "Admin"): ?>
                <li class="sidebar-item">
                        <a href="AdminFeed.php" class="sidebar-link">
                        <i><img src="../Assets/feedback.svg"></i>
                        <span>Feedback</span>
                        </a>
                    </li>
                </ul>

                <?php else: ?>
                    </ul>
            <?php endif ?>
            

            <div class="sidebar-footer" style="margin-bottom: 40px;">
                <a href="About.php" class="sidebar-link">
                    <i class=""><img src="../Assets/logo.svg"></i>
                    <span>About Us</span>
                </a>
            </div>
            <div class="sidebar-footer" style="margin-bottom: 20px;">
                <a href="Settings.php" class="sidebar-link">
                    <i><img src="../Assets/settings.svg"></i>
                    <span>Settings</span>
                </a>
            </div>
        </aside>

        <div class="main">
        <main>
        <div class="row" id="main1">
            <span style="font-size: 30px; font-weight: bold; text-align: center; margin-top: 25px;">User Feedback</span>
            <a href="../Excel/export1.php">
                <button id="exxport" type="button" name="button">Export To Excel</button>
            </a>

            <table style="width: 90%; height: 45%; margin-right: auto; margin-bottom: 35%;">
                <thead>
                    <tr id="tr1">
                        <th>Report ID</th>
                        <th>Problem</th>
                        <th>Rating</th>
                        <th>Feedback</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($pendingReports as $report): ?>
                        <tr>
                            <td><?= $report['report_id'] ?></td>
                            <td><?= $report['problem'] ?></td>
                            
                            <?php
                            // Find feedback that matches this report
                            $feedback = array_filter($sent, function ($item) use ($report) {
                                return $item['report_id'] == $report['report_id'];
                            });

                            if (!empty($feedback)) {
                                $feedback = reset($feedback); // Get the first matched feedback
                            ?>
<td>
    <?= $feedback['rating']; ?> 
    <?php 
    $rated = $feedback['rating'];
    for ($i = 1; $i <= 5; $i++) : ?>
        <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 576 512" width="24" height="24"
             fill="<?= ($i <= $rated) ? '#FFD700' : '#D3D3D3' ?>"> <!-- Gold for filled, Gray for empty -->
            <path d="M316.9 18C311.6 7 300.4 0 288.1 0s-23.4 7-28.8 18L195 150.3 51.4 171.5c-12 1.8-22 10.2-25.7 21.7s-.7 24.2 7.9 32.7L137.8 329 113.2 474.7c-2 12 3 24.2 12.9 31.3s23 8 33.8 2.3l128.3-68.5 128.3 68.5c10.8 5.7 23.9 4.9 33.8-2.3s14.9-19.3 12.9-31.3L438.5 329 542.7 225.9c8.6-8.5 11.7-21.2 7.9-32.7s-13.7-19.9-25.7-21.7L381.2 150.3 316.9 18z"/>
        </svg>
    <?php endfor; ?>
</td>



                            </td>
                                <td><?= $feedback['feedback']; ?></td>
                            <?php } else { ?>
                                <td>N/A</td>
                                <td>No Feedback</td>
                            <?php } ?>
                        </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
        </div>
        </main>
        </div>
    </div>

    
    <script src="../JS/Homepage.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"
        integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz"
        crossorigin="anonymous"></script>
</body>

</html>

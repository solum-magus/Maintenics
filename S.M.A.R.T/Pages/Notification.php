<?php 
session_start();

if (!isset($_SESSION["position"])) {
    echo "<script>
    alert('You are not logged in!');
    window.location.href = '../index.html';
    </script>";
    exit();
}

$Testsql = require __DIR__ . "/../database.php";
$position = $_SESSION["position"];

$sql = "SELECT * FROM reportdetails WHERE status IN ('Pending', 'Ongoing', 'Resolved')";
$reports = $Testsql->query($sql);

$pendingReports = [];
$ongoingReports = [];
$resolvedReports = [];

if ($reports->num_rows > 0) {
    while ($row = $reports->fetch_assoc()) { 
        switch ($row['status']) {
            case 'Pending':
                $pendingReports[] = $row;
                break;
            case 'Ongoing':
                $ongoingReports[] = $row;
                break;
            case 'Resolved':
                $resolvedReports[] = $row;
                break;
        }
    }
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
    <link rel="stylesheet" href="../Style/Notification.css"><!---->
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
        <div id="notifinfo">
                    <h2 style="color: black !important;">Notifications</h2>
                    <div class="notifbar">
                        
                        <!-- Pending Reports -->
                        <?php foreach ($pendingReports as $report): ?>
                            <div class="notify-p">
                                <h3>STATUS: Pending</h3>
                                <th>Report ID: <?= $report['report_id'] ?></th>
                                <p>Problem: <?= $report['problem'] ?></p>
                                <p>Date Report: <?= $report['date_reported'] ?></p>
                                <p>Date Resolved: ???</p>

                            <?php if ($_SESSION['position'] === 'Maintenance Staff'): ?>
                                <form method="POST" action="../Authentication/update_report.php">
                                    <input type="hidden" name="report_id" value="<?= $report['report_id'] ?>">
                                    <input type="hidden" name="status" value="Ongoing">
                                    <button type="submit">Take Action</button>
                                </form>
                            <?php endif; ?>

                            </div>
                        <?php endforeach; ?>

                        <!-- Ongoing Reports -->
                        <?php foreach ($ongoingReports as $report): ?>
                            <div class="notify-o">
                                <h3>STATUS: Ongoing</h3>
                                <p>Report ID: <?= $report['report_id'] ?></p>
                                <p>Problem: <?= $report['problem'] ?></p>
                                <p>Date Report: <?= $report['date_reported'] ?></p>
                                <p>Date Resolved: ???</p>

                            <?php if ($_SESSION['position'] === 'Maintenance Staff'): ?>
                                <form method="POST" action="../Authentication/update_report.php">
                                    <button type="submit" name="report_id" value="<?= $report['report_id'] ?>">
                                        <?= $report['status'] === 'Ongoing' ? 'Mark as Resolved' : 'Take Action' ?>
                                    </button>
                                </form>
                            <?php endif; ?>


                            </div>
                        <?php endforeach; ?>

        </main>
        </div>          
    </div>
    <script src="../JS/Homepage.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"
        integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz"
        crossorigin="anonymous"></script>
</body>

</html>

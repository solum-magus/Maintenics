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

<html>
    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <title>SMART - Notifications</title>
        <link rel="stylesheet" href="../Style/Notification.css">
        <link rel="stylesheet" href="../Style/Nav_Bar.css">
    </head>
    <body>
        <div class="Container">
            <nav>
                <svg id="logo" height="50" width="50">
                    <image height="50" width="50" href="../Assets/Logo2.png"></image>
                </svg>
                <span id="smart">SMART</span>
            </nav>
            <main>
                <div id="notifinfo">
                    <h2>Notifications</h2>
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

                        <!-- Resolved Reports -->
                        <?php foreach ($resolvedReports as $report): ?>
                            <div class="notify-r">
                                <h3>STATUS: Resolved</h3>
                                <p>Report ID: <?= $report['report_id'] ?></p>
                                <p>Problem: <?= $report['problem'] ?></p>
                                <p>Date Report: <?= $report['date_reported'] ?></p>
                                <p>Date Resolved: <?= $report['date_resolved'] ?></p>
                            </div>
                        <?php endforeach; ?>
                    </div>
                </div>
            </main>

            <div id="side">
			<div id="icons">
                <a href="Profile.php"><img id="prof" src="../Assets/Profile.png"></a>

                <?php if ($_SESSION["position"] == "Admin" || $_SESSION["position"] == "Maintenance Staff"):?>
                    <a href="Admin.php"><img id="" src="../Assets/Home.png"></a>

                <?php else: ?>
                    <a href="Homepage.php"><img id="home" src="../Assets/Home.png"></a>
                <?php endif; ?>

                <a href="History.php"><img id="id" src="../Assets/History.png"></a>


                <?php if ($_SESSION["position"] == "Admin" || $_SESSION["position"] == "Maintenance Staff"):?>
                    <a href="AdminFeed.php"><img id="" src="../Assets/Feedback.png"></a>

                <?php else: ?>
                    <a href="Feedback.php"><img id="fb" src="../Assets/Feedback.png"></a>
                <?php endif; ?>

                <a href="Notification.php"><img id="notif" src="../Assets/Notification.png"></a>
                </div>
            </div>
        </div>

    </body>
</html>

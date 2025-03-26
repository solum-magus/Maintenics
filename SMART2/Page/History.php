<?php 
session_start();

if (!isset($_SESSION["position"])) {
    echo "<script>
    alert('You are not logged in!');
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

$sql = "SELECT report_id, problem, date_reported, date_resolved, status, rating, feedback 
        FROM reportdetails 
        WHERE status = 'Resolved' AND rid = ? 
        ORDER BY date_reported DESC";

$stmt = $Testsql->prepare($sql);
$stmt->bind_param("i", $rid);
$stmt->execute();
$Report = $stmt->get_result();

$reports = [];

if ($Report->num_rows > 0) {
    while ($row = $Report->fetch_assoc()) { 
        $reports[] = $row;  
    }
}
$feedback="";
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
            <!-- Dots Icon, when clicked will show/hide sidebar -->

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

<!-- Sidebar -->
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

<h1>Report History</h1>

<div class="filters">
    <label for="problem">Filter by Problem:</label>
    <select id="problem">
        <option value="">Select Problem</option>
        <option value="TV">TV</option>
        <option value="Broken Chair">Broken Chair</option>
        <option value="No Wi-Fi">No Wi-Fi</option>
    </select>

    <label for="date">Filter by Date:</label>
    <input type="date" id="date">
</div>

<div class="box">

<?php 
                        // Loop through all reports and display 'em
                        foreach ($reports as $report): 
                        ?>
                          <div id="aa">
                            <div class="report
                                <?php
                                    // Change div class based on stats 
                                    echo strtolower($report['status']);
                                ?>">
                                <table>
                                <tr>
                        <th>
                                <h3 class="overlayt" id="status-text">Status: <?= $report['status'] ?></h3>
                                <p>Report ID: <?= $report['report_id'] ?></p>
                                <p>Problem: <?= $report['problem'] ?></p>
                                <p>Date Reported: <?= $report['date_reported'] ?></p>
                                <p>Date Resolved: <?= $report['date_resolved'] ?: "Not yet resolved" ?></p>
                        </th>

                    <?php if ($position != "Maintenance Staff") : ?>
                                <div class="rate">
                                <th>

                            <form method="POST" action="../Authentication/sendfeedback.php">
                            <input type="hidden" name="report_id" value="<?= $report['report_id'] ?>">

                            <div class="rating">
                            <?php 
                                $rated = $report['rating']; // Previous rating from the database
                                for ($i = 5; $i >= 1; $i--) : ?>  <!-- Reverse the loop -->
                                    <input type="radio" name="rating<?= $report['report_id'] ?>" 
                                        id="rating<?= $i ?>_<?= $report['report_id'] ?>" 
                                        value="<?= $i ?>" 
                                        <?= ($i == $rated) ? 'checked' : '' ?>> <!-- Show selected star -->

                                    <label for="rating<?= $i ?>_<?= $report['report_id'] ?>">
                                        <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 576 512" width="24" height="24">
                                            <path d="M316.9 18C311.6 7 300.4 0 288.1 0s-23.4 7-28.8 18L195 150.3 51.4 171.5c-12 1.8-22 10.2-25.7 21.7s-.7 24.2 7.9 32.7L137.8 329 113.2 474.7c-2 12 3 24.2 12.9 31.3s23 8 33.8 2.3l128.3-68.5 128.3 68.5c10.8 5.7 23.9 4.9 33.8-2.3s14.9-19.3 12.9-31.3L438.5 329 542.7 225.9c8.6-8.5 11.7-21.2 7.9-32.7s-13.7-19.9-25.7-21.7L381.2 150.3 316.9 18z"/>
                                        </svg>
                                    </label>
                            <?php endfor; ?>


                        </div>


                    <?php if (empty($feedback)) { ?>
                        <textarea name="feedback" rows="4" style="width: 100%; margin-top: 10px; padding: 10px; text-align: left;" >
                            <?= htmlspecialchars($report['feedback'] ?? '') ?></textarea>

                    <?php } else { ?>
                        <textarea name="feedback" placeholder="Leave your feedback here..." rows="4" style="width: 100%; margin-top: 10px; padding: 10px;"></textarea>
                    <?php } ?>


                            <button type="submit" name="submit_feedback" id="feedbackbutton">Submit</button>
                        </form>

                        <?php endif ?>
                        </th>
                            </div>


                        </th>
                        </tr>
                        </table>
                            </div>
                </div>                                             
                        <?php endforeach; ?>

    <!--<span class="overlayt" id="status-text">Status: Resolved</span>
    <div class="rating">
        <span class="star" data-value="1">&#9733;</span>
        <span class="star" data-value="2">&#9733;</span>
        <span class="star" data-value="3">&#9733;</span>
        <span class="star" data-value="4">&#9733;</span>
        <span class="star" data-value="5">&#9733;</span>
    </div>-->
</div>

<script src="../JS/script1.js"></script>
<script src="../JS/script4.js"></script>

</body>
</html>

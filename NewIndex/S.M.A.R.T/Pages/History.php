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
<html>
    <head>
    <title>SMART</title>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet"
        integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
        <link href="https://fonts.googleapis.com/css2?family=Merriweather:ital,wght@0,300;0,400;0,700;0,900;1,300;1,400;1,700;1,900&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="../Style/History.css">
    <link rel="stylesheet" href="../Style/Sidebar.css">

    </head>
    <body>
    <div class="d-flex">
        <aside id="sidebar" class="sidebar-toggle">
            
        <div class="sidebar-header" id="sidebar-header">
        <a href="#" class="sidebar-logo">
        <img src="../Assets/logo.svg" alt="Logo" class="sidebar-icon"> S.M.A.R.T.
        </a>
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
                 <i class=""><img src="../Assets/companyi.svg"></i>
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
        <div class="Container">
            <nav>
                <svg id="logo" height="50" width="50">
                    <image height="50" width="50" href="../Assets/Logo2.png"></image>
                </svg>
               
            </nav>
            <main>
            
                <div id="historyinfo">
                    <span style="font-size: 30px; font-weight: bold;">Report History</span>
                    <div class="historybar">

                    <?php if (($position) === "Admin"):  ?>
                        <div class="problem-summary">
                            <table class="table table-bordered">
                                <tr>
                                    <th class="cth">Most Frequent Problem</th>
                                    <th class="cth">Most Affected Classroom</th>
                                </tr>
                                <tr>
                                    <td>
                                        <?php 
                                        $problemQuery = "SELECT problem, COUNT(problem) as count FROM reportdetails GROUP BY problem ORDER BY count DESC LIMIT 1";
                                        $problemResult = $Testsql->query($problemQuery);
                                        $mostFrequentProblem = $problemResult->fetch_assoc();
                                        echo $mostFrequentProblem['problem'] ?? "No data"; 
                                        ?>
                                    </td>
                                    <td>
                                        <?php 
                                        $classroomQuery = "SELECT plocation, COUNT(plocation) as count FROM reportdetails GROUP BY plocation ORDER BY count DESC LIMIT 1";
                                        $classroomResult = $Testsql->query($classroomQuery);
                                        $mostFrequentClassroom = $classroomResult->fetch_assoc();
                                        echo $mostFrequentClassroom['plocation'] ?? "No data"; 
                                        ?>
                                    </td>
                                </tr>
                            </table>
                        </div>
                    <?php endif; ?>

                    <a href="../Excel/export.php"> <button id="exxport" type="button" name="button">Export To Excel</button> </a>

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
                                <h3>Status: <?= $report['status'] ?></h3>
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
                    </div>
                </div>
            </main>
            <script src="../JS/Homepage.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"
        integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz"
        crossorigin="anonymous"></script>

   <script>
   function setStarRating(StarIndex) {
      const stars = document.querySelectorAll('input[type="radio"]');
      const labels = document.querySelectorAll('label');

      
      stars.forEach((star, index) => {
        star.addEventListener('click', () => {
          labels.forEach((label, labelIndex) => {
            label.style.fill = labelIndex <= index ? '#fd4' : '#444';
          });
        });
      });

      
      labels.forEach((label, index) => {
        label.style.fill = index < StarIndex ? '#fd4' : '#444';
      });
    }

    setStarRating();
    </script>
        </div>
    </body>
</html>

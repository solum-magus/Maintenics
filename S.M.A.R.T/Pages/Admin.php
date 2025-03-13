<?php
    session_start();

    if (!isset($_SESSION["position"])) {
        echo "<script>
        alert('You are not logged in!');
        window.location.href = '../index.html';
        </script>";
        exit();
    }
    $mysqli = require __DIR__ . "/../database.php";

    $sql = "SELECT report_id, rname, plocation, problem, pdescription  FROM reportdetails";
    $result = $mysqli->query($sql);

    if ($result->num_rows > 0) {
        $reports = $result->fetch_all(MYSQLI_ASSOC);
    } else {
        $reports = [];
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
    <link rel="stylesheet" href="../Style/Admin.css">
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

            <div class="problem-summary">
            <span style="display: block; font-size: 30px; 	font-weight: bold; text-align: center;">Maintenance Report</span>
                <table class="table table">
                        <tr>
                            <th class="cth">Most Frequent Problem</th>
                            <th class="cth">Most Affected Classroom</th>
                        </tr>
                        <tr>
                            <td>
                                <?php 
                                        $problemQuery = "SELECT problem, COUNT(problem) as count FROM reportdetails GROUP BY problem ORDER BY count DESC LIMIT 1";
                                        $problemResult = $mysqli->query($problemQuery);
                                        $mostFrequentProblem = $problemResult->fetch_assoc();
                                        echo $mostFrequentProblem['problem'] ?? "No data"; 
                                ?>
                            </td>
                            <td>
                                <?php 
                                $classroomQuery = "SELECT plocation, COUNT(plocation) as count FROM reportdetails GROUP BY plocation ORDER BY count DESC LIMIT 1";
                                $classroomResult = $mysqli->query($classroomQuery);
                                $mostFrequentClassroom = $classroomResult->fetch_assoc();
                                echo $mostFrequentClassroom['plocation'] ?? "No data"; 
                                ?>
                            </td>
                        </tr>
                    </table>

                    <table class="table table" id="tab">
                        <tr>
                            <th class="cth">Average Feedback Rating</th>
                        </tr>
                        <tr>
                            <th>
                            <?php 
                                $feedbackQuery = "SELECT AVG(rating) AS avg_rating FROM reportdetails";
                                $feedbackResult = $mysqli->query($feedbackQuery);
                                $averageFeedback = $feedbackResult->fetch_assoc();
                                echo $averageFeedback['avg_rating'] ? number_format($averageFeedback['avg_rating'], 2) : "No data"; 
                                ?>
                            </th>
                        </tr>
                    </table>
                
            </div>

                <div class="row" id="main1">
			        <table style="width: 95%; height: 95%; margin-right: auto; margin-block: 2%;">

					  <tr>
					    <th>Report ID</th>
					    <th>Location</th>
						<th>Problem</th>
						<th>Description</th>
					  </tr>
                      <?php foreach ($reports as $report): ?>
					  <tr>
                        <td><?= $report['report_id']; ?></td>
                        <td><?= $report['plocation']; ?></td>
                        <td><?= $report['problem']; ?></td>
                        <td><?= $report['pdescription']; ?></td>
					  </tr>
					  <?php endforeach; ?>

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

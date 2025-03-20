<?php

    session_start();

    if (!isset($_SESSION["position"])) {
        echo "<script>
        alert('You are not logged in!');
        window.location.href = '../index.php';
        </script>";
        exit();
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
    <link rel="stylesheet" href="../Style/Homepage.css">
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

        <div class="main">
            <main class="">
                <div class="row" id="main1">
                    <div class="col-2" id="profile">
                        <img src="../Assets/profile.svg" style="width: 100px; height: 100px; margin: 10px;" >
                    </div>
                    <div class="col-10" id="info">

                    <?php if (isset($fname) && isset($position)):  ?>

                        <div id="nameposition"><p><?= htmlspecialchars($user["full_name"]) ?></p>
                        <p><?= htmlspecialchars($user["position"]) ?></p></div>

                    <?php endif; ?>

                    </div>
                </div>

                <div class="row" id="main2">
                    <p style="margin-bottom: 30px !important;">Report Facility Issue</p>

                    <form action="../Authentication/makereport.php" method="post">
                        <div id="inputdiv">
                        <p>Name</p>
                        <input type="text" id="rname" name="rname" value="<?= htmlspecialchars($user["full_name"]) ?>" readonly required>


                        <p>Location of Issue</p>
                        <input type="text" id="plocation" name="plocation" required>


                        <p>Problem</p>
                        <input type="text" id="problem" name="problem" required>

                        
                        <p>Description (Optional)</p>
                        <input type="text" id="pdescription" name="pdescription">
                        <br>

                        <input type="hidden" name="rid" value="<?= htmlspecialchars($school_id) ?>">

                        <div  class="d-grid"><button class="btn btn-block mb-1" id="button">Submit Report</button></div>
                        </div>
                    </form>

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

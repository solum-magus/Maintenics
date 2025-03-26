<?php
    session_start();

    if (!isset($_SESSION["position"])) {
        echo "<script>
        alert('You are not logged in!');
        window.location.href = '../index.php';
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

<head>
    <title>SMART</title>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet"
        integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
        <link href="https://fonts.googleapis.com/css2?family=Merriweather:ital,wght@0,300;0,400;0,700;0,900;1,300;1,400;1,700;1,900&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="../Style/Settings.css">
    <link rel="stylesheet" href="../Style/Sidebar.css">
    <script src="../JS/Settings.js" defer></script>
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
            <main>

                <div class="row" id="set">
                    <p style="font-weight: 800; font-size: 2.5rem; text-align: center; margin-block: 30px;">Settings</p>

                    <div class="row" id="qr">
                    <img src="../Assets/QR.svg">
                    </div>
                    
                    <div id="signout_button">
                        <a href="../Authentication/signout.php"><button id="signout">Sign out</button></a>                      
                    </div>

                    <div class="change">
                        <button id="change" onclick="navigateTo('CPassword')">Change Password</button>
                    </div>

                    <div class="pages" id="CPassword" style="display: none;">
                    <form id="ChangePasswordForm" action="../Authentication/change_pass.php" method="POST">
                    <h2>Change Password</h2>

                    <label for="school_id">School ID</label>
                    <input type="text" id="school_id" name="school_id" maxlength="11" required>
                    
                    <br>

                    <label for="current_password">Current Password</label>
                    <input type="password" id="current_password" name="current_password" required>

                    <br>

                    <label for="new_password">New Password</label>
                    <input type="password" id="new_password" name="new_password" required>

                    <br>

                    <label for="confirm_password">Confirm New Password</label>
                    <input type="password" id="confirm_password" name="confirm_password" required>

                    <br>

                    <button id="submit" type="submit">Change Password</button>
                </form>
                    </div>
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

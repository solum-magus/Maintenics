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
<head>
    <title>SMART</title>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet"
        integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
        <link href="https://fonts.googleapis.com/css2?family=Merriweather:ital,wght@0,300;0,400;0,700;0,900;1,300;1,400;1,700;1,900&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="../Style/About.css">
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
                    <div class="row-4 mainrow toprow" id="profile">
                        <img id="logo2" src="../Assets/company.svg">
                        <span></span>
                        <img id="logo" src="../Assets/logo.svg">
                        <h2>Maintenics | S.M.A.R.T.</h2>
                    </div>

                    <div class="row-4 mainrow">
                        <h3>Vision</h3>
                        <p>We aim to be the leading company for facility management in Bulacan, ensuring that the environment is safe and well-maintained for greater productivity and better well-being.</p>
                    </div>

                    <div class="row-4 mainrow">
                        <h3>Mission</h3>
                        <p>We are offering exceptional facility management services in Meycauayan Bulacan, prioritizing safety and maintaining greater productivity, we strive to create environments that promotes success and comfort.</p>
                    </div>

                    <div class="row-4 mainrow">
                        <h3>Core Values</h3>
                        <p>Our Company philosophy is to organize the world’s information and make it universally accessible and useful. As for the core values, it’s to always keep the consumer in mind: All products must be designed around a user.<br>
                            <br>Faster is better than slower: Concise and efficient products are preferable. <br>
                            <br>Better to do one thing really, really well: Play to your strengths. </p>
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

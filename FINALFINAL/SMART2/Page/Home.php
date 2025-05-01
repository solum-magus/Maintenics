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
    if ($_SESSION["position"] === "Admin" || $_SESSION["position"] === "Maintenance Staff") {
        echo "<script>
        alert('You do not have permission to access this page.');
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

        $full_name = $user["full_name"] ?? "";
        $first_name = explode(" ", trim($full_name))[0];

    }

    if (isset($_SESSION["report_submitted"])) {
        unset($_SESSION["report_submitted"]); 
    }

    $_SESSION["id"] = $school_id; 

    $hasUnread = checkUnreadNotifications($mysqli);

    $sql = "SELECT DISTINCT problemloc FROM problemlocations ORDER BY problemloc ASC";
    $result = $mysqli->query($sql);

    $locations = [];

    if ($result) {
        while ($row = $result->fetch_assoc()) {
            $locations[] = $row['problemloc'];
        }
    }

    $sql = "SELECT DISTINCT probtype FROM problemtypes ORDER BY probtype ASC";
    $result = $mysqli->query($sql);

    $ptype = [];

    if ($result) {
        while ($row = $result->fetch_assoc()) {
            $locations[] = $row['probtype'];
        }
    }
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>SMART</title>
    <link rel="apple-touch-icon" sizes="180x180" href="../Assets/apple-touch-icon.png">
    <link rel="icon" type="image/png" sizes="32x32" href="../Assets/favicon-32x32.png">
    <link rel="icon" type="image/png" sizes="16x16" href="../Assets/favicon-16x16.png">
    <link rel="manifest" href="../Assets/site.webmanifest">
    <link href="../Style/Home.css" rel="stylesheet">
    <link href="../Style/Sidebar.css" rel="stylesheet">
    <link href="../Style/Navigationbar.css" rel="stylesheet">
    <script
  src="https://unpkg.com/@dotlottie/player-component@2.7.12/dist/dotlottie-player.mjs"
  type="module"
></script>
</head>
<body>

<header class="sticky-header">
    <div class="header-container">
        <div class="logos">
            <!-- Dots Icon, when clicked will show/hide sidebar -->

            <img src="../Assets/companyl.svg" class="logo" alt="Dots" id="Dots">
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
                    <a href="Home.php" class="logo-link"><img src="../Assets/home.svg" class="logo" alt="Home" id="Home"></a>
                    <a href="History.php"><img src="../Assets/history.svg" class="logo" alt="History" id="History"></a>
                    <?php
                    break;
            
                default:
                    ?>
                    <a href="Home.php"><img src="../Assets/home.svg" class="logo" alt="Home" id="Home"></a>
                    <a href="History.php" class="logo-link"><img src="../Assets/history.svg" class="logo" alt="History" id="History"></a>
                    <?php
                    break;
            }
            ?>
            <a href="Notification.php" class="logo-link"><img src="../Assets/notification<?= $hasUnread ? '1' : '' ?>.svg" class="logo <?= $hasUnread ? 'unread' : '' ?>" alt="Notifications" id="Notifications"></a>
            <a href="Settings.php" class="logo-link"><img src="../Assets/settings.svg" class="logo" alt="Settings" id="Settings"></a>
        </div>

        <div class="user-info">
            <div class="user-top">
            <div class="position-dropdown">
                <img src="../Assets/profile.png" id="proff">
                <span class="username"><?= htmlspecialchars($first_name ?? "NULL") ?></span>
                <span class="position"><?= htmlspecialchars($user["position"] ?? "NULL") ?></span>
            </div>
                <select class="dropdown" id="profileDropdown" onchange="handleProfileChange(this.value)">
                    <option value="" disabled selected></option>
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
            <p>In the coming years, we see ourselves as the global leader in school maintenance solutions, using cutting-edge real-time tracking technology to transform how schools manage their facilities. We are building SMART because we believe every school deserves a safe, well-maintained, and efficient environment for learning, ensuring a brighter future for students and educators everywhere. </p>
        </div>
        <div class="mission">
            <h4>Mission</h4>
            <p>Our mission is to provide schools with an innovative, user-friendly platform that simplifies maintenance management through real-time tracking and data-driven insights. We are committed to delivering reliable, efficient, and sustainable solutions that empower schools to optimize their operations, reduce costs, and create safer, more productive learning environments. What sets us apart is our dedication to use technology to solve real-world challenges, ensuring every school can focus on what matters most—educating future generations.</p>
        </div>
        <div class="contact">
            <h4>Contact Us</h4>
            <p>maintenics@gmail.com</p>
        </div>
    </div>
</div>

<div class="form-container">
    <h2 class="form-title">Good day, <?= $first_name ?>! Reporting an issue?</h2>
    <form id="reportForm">
        <input type="hidden" id="rname" name="rname" value="<?= $full_name ?>">
        <input type="hidden" id="rid" name="rid">

        <select id="plocation" name="plocation" required>
            <option value="" disabled selected>Location of Issue</option>
            <?php
                $locationQuery = "SELECT DISTINCT problemloc FROM problemlocations ORDER BY problemloc ASC";
                $locationResult = $mysqli->query($locationQuery);

                if ($locationResult && $locationResult->num_rows > 0) {
                    while ($row = $locationResult->fetch_assoc()) {
                        $loc = htmlspecialchars($row['problemloc']);
                        echo "<option value=\"$loc\">$loc</option>";
                    }
                }
            ?>
            <option value="Other">Other</option>
        </select>

        <select id="problem" name="problem" required>
            <option value="" disabled selected>Problem Type</option>
            <?php
                $probQuery = "SELECT DISTINCT probtype FROM problemtypes ORDER BY probtype ASC";
                $probResult = $mysqli->query($probQuery);

                if ($probResult && $probResult->num_rows > 0) {
                    while ($row = $probResult->fetch_assoc()) {
                        $prob = htmlspecialchars($row['probtype']);
                        echo "<option value=\"$prob\">$prob</option>";
                    }
                }
            ?>
            <option value="Other">Other</option>
        </select>

        <textarea id="pdescription" placeholder="Description (optional)"></textarea>

        <button type="submit">Submit</button>
    </form>
</div>

</div>

<script>
document.addEventListener("DOMContentLoaded", function() {
    fetch("../Authentication/get_user.php")
    .then(response => response.json())
    .then(data => {
        if (data.rname && data.rid) {
           // document.getElementById("username").innerText = data.rname;
            document.getElementById("rname").value = data.rname;
            document.getElementById("rid").value = data.rid;
        } else {
            document.addEventListener('DOMContentLoaded', function() {
                customAlert("Error fetching user data: " + data.error);
            });
        }
    });

    document.getElementById("reportForm").addEventListener("submit", function(event) {
        event.preventDefault();

        let formData = new FormData();
        formData.append("rname", document.getElementById("rname").value);
        formData.append("rid", document.getElementById("rid").value);
        formData.append("plocation", document.getElementById("plocation").value);
        formData.append("problem", document.getElementById("problem").value);
        formData.append("pdescription", document.getElementById("pdescription").value);

        fetch("../Authentication/makereport.php", {
            method: "POST",
            body: formData
        })
        .then(response => response.text())
        .then(data => {
            console.log("Submit Response:", data);
            document.getElementById("reportForm").reset();
        });
    });
});
</script>


<div id="successModal" class="modal">
    <div class="modal-content">
        <span id="closeModal" class="close">&times;</span>
        <dotlottie-player
        src="https://lottie.host/04108b42-2a62-4577-b2e9-80cc8d590abf/biajU331Fa.lottie"
        background="transparent"
        speed="1"
        style="width: 150px; height: 150px"
        loop
        autoplay
        ></dotlottie-player>
        <h2>Report Submitted</h2>
        <hr class="separator">
        <p>Your report has been logged and will be addressed shortly.</p>
    </div>
</div>

<div id="popup" style="display:none; position:fixed; top:20px; left:50%; transform:translateX(-50%); background: rgb(0, 123, 255); padding:10px 20px; border:1px solid rgb(38, 52, 177); border-radius:8px; z-index:10000; color:white; font-family: Roboto, sans-serif; box-shadow:0 0 10px rgba(0,0,0,0.1);">
        <span id="popup-message"></span>
    </div>

<script src="../JS/script.js"></script>
<script src="../JS/script4.js"></script>
<script src="../JS/script6.js"></script>
<script src="../JS/script7.js"></script>
<script src="../JS/script8.js"></script>

</body>
</html>

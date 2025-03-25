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

    if (isset($_SESSION["report_submitted"])) {
        unset($_SESSION["report_submitted"]); // Remove session first
    }

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>SMART</title>
    <link href="../Style/Home.css" rel="stylesheet">
    <link href="../Style/Sidebar.css" rel="stylesheet">
</head>
<body>

<header class="sticky-header">
    <div class="header-container">
        <div class="logos">
            <!-- Dots Icon, when clicked will show/hide sidebar -->

            <img src="../Assets/dots.svg" class="logo" alt="Dots" id="Dots">
            <a href="Home.php"><img src="../Assets/home.svg" class="logo" alt="Home" id="Home"></a>
            <a href="History.php"><img src="../Assets/history.svg" class="logo" alt="History" id="History"></a>
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

<div class="form-container">
    <h2 class="form-title">Good day, <span id="username"></span>! Reporting an issue? <br> Fill out the form below!</h2>
    <form id="reportForm">
        <input type="hidden" id="rname" name="rname">

        <select id="plocation" required>
            <option value="" disabled selected>Location of Issue</option>
            <option>Ampi</option>
            <option>Room 101</option>
            <option>Library</option>
        </select>

        <select id="problem" required>
            <option value="" disabled selected>Problem Type</option>
            <option>TV</option>
            <option>Broken Chair</option>
            <option>No Wi-Fi</option>
        </select>

        <textarea id="pdescription" placeholder="Description (optional)"></textarea>

        <button type="submit">Submit</button>
    </form>
</div>

<script>
document.addEventListener("DOMContentLoaded", function() {
    // Fetch the user's full name (stored as rname) from userinfo table
    fetch("../Authentication/get_user.php")
    .then(response => response.json())
    .then(data => {
        if (data.rname) {
            document.getElementById("username").innerText = data.rname; // Show the name
            document.getElementById("rname").value = data.rname; // Assign to hidden input
        } else {
            alert("Error fetching user data: " + data.error);
        }
    });

    // Handle form submission
    document.getElementById("reportForm").addEventListener("submit", function(event) {
        event.preventDefault();

        let formData = new FormData();
        formData.append("rname", document.getElementById("rname").value); // Use full_name as rname
        formData.append("plocation", document.getElementById("plocation").value);
        formData.append("problem", document.getElementById("problem").value);
        formData.append("pdescription", document.getElementById("pdescription").value);

        fetch("../Authentication/submit_report.php", {
            method: "POST",
            body: formData
        })
        .then(response => response.text())
        .then(data => {
            document.getElementById("reportForm").reset(); // Reset form
        });
    });
});


</script>


<div id="successModal" class="modal">
    <div class="modal-content">
        <span id="closeModal" class="close">&times;</span>
        <img src="../Assets/modal.svg" class="modal-image">
        <h2>Report Submitted</h2>
        <hr class="separator">
        <p>Your report has been logged and will be addressed shortly.</p>
    </div>
</div>

<script src="../JS/script.js"></script>
<script src="../JS/script4.js"></script>



</body>
</html>

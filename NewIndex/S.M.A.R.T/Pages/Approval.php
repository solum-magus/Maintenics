<?php
session_start();

// Check if the user is logged in
if (!isset($_SESSION["position"])) {
    echo "<script>
    alert('You are not logged in!');
    window.location.href = '../index.php';
    </script>";
    exit();
}

// Connect to the database
$mysqli = require __DIR__ . "/../database.php";

// Fetch users with "Pending" status
$sql_pending = "SELECT position, full_name, school_id, userstatus FROM userinfo WHERE userstatus = 'Pending' AND position = 'Maintenance Staff'";
$result_pending = $mysqli->query($sql_pending);

// Check if there are pending users
$pending_users = [];
if ($result_pending->num_rows > 0) {
    $pending_users = $result_pending->fetch_all(MYSQLI_ASSOC);
}

// If the approve button is clicked
if ($_SERVER["REQUEST_METHOD"] === "POST" && isset($_POST["approve_user"])) {
    $school_id = $_POST["school_id"];

    // Update user status to "Approved"
    $update_sql = "UPDATE userinfo SET userstatus = 'Approved' WHERE school_id = ?";
    $stmt = $mysqli->prepare($update_sql);
    $stmt->bind_param("i", $school_id);

    if ($stmt->execute()) {
        echo "<script>
        alert('User approved successfully!');
        window.location.href = 'Approval.php'; // Reload the page
        </script>";
    } else {
        echo "<script>
        alert('Error approving user.');
        </script>";
    }

    $stmt->close();
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
            <link rel="stylesheet" href="../Style/Approval.css">
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
            <main>
            <div class="rows" id="main">
        <h2 id="h22"><b>Pending Approvals</b></h2>

        <?php if (count($pending_users) > 0): ?>
            <table class="table table-bordered">
                <thead>
                    <tr>
                        <th>Name</th>
                        <th>Position</th>
                        <th>School ID/Phone</th>
                        <th>Action</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($pending_users as $user): ?>
                        <tr>
                            <td><?php echo htmlspecialchars($user['full_name']); ?></td>
                            <td><?php echo htmlspecialchars($user['position']); ?></td>
                            <td><?php echo htmlspecialchars($user['school_id']); ?></td>
                            <td>
                                <form method="post">
                                    <input type="hidden" name="school_id" value="<?php echo $user['school_id']; ?>">
                                    <button type="submit" name="approve_user" class="btn btn-success">Approve</button>
                                </form>
                            </td>
                        </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
        <?php else: ?>
            <p>No pending users at the moment.</p>
        <?php endif; ?>
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

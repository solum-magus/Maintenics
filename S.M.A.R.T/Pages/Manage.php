<?php
session_start();

if (!isset($_SESSION["position"]) || $_SESSION["position"] !== "Admin") {
    echo "<script>
    alert('Access Denied!');
    window.location.href = '../index.html';
    </script>";
    exit();
}

$mysqli = require __DIR__ . "/../database.php";

$sql = "SELECT * FROM userinfo";
$result = $mysqli->query($sql);

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
    <link rel="stylesheet" href="../Style/Manage.css">
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
            <div class="container">
    <h2 class="mb-4"><b>User Management</b></h2>
    <table class="table table-bordered">
        <thead>
            <tr>
                <th>Full Name</th>
                <th>School ID</th>
                <th>Position</th>
                <th>Status</th>
                <th>Actions</th>
            </tr>
        </thead>
        <tbody>
            <?php while ($user = $result->fetch_assoc()): ?>
            <tr>
                <td><?= htmlspecialchars($user['full_name']) ?></td>
                <td><?= htmlspecialchars($user['school_id']) ?></td>
                <td><?= htmlspecialchars($user['position']) ?></td>
                <td><?= htmlspecialchars($user['userstatus']) ?></td>
                <td>
                    <a href="ManageEdit.php?id=<?= $user['school_id'] ?>" class="btn btn-warning btn-sm">Edit</a>
                    <a href="../Authentication/Admin/delete.php?id=<?= $user['school_id'] ?>" class="btn btn-danger btn-sm"
                        onclick="return confirm('Are you sure you want to delete this user?');">Delete</a>
                </td>
            </tr>
            <?php endwhile; ?>
        </tbody>
    </table>
</div>
    </div>
    <script src="../JS/Homepage.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"
        integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz"
        crossorigin="anonymous"></script>
</body>

</html>
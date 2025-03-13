<?php
session_start();
$mysqli = require __DIR__ . "/../database.php";

if (!isset($_GET['id'])) {
    echo "No user selected.";
    exit();
}

$id = $mysqli->real_escape_string($_GET['id']);
$sql = "SELECT * FROM userinfo WHERE school_id = '$id'";
$result = $mysqli->query($sql);

if ($result->num_rows === 1) {
    $user = $result->fetch_assoc();
} else {
    echo "User not found.";
    exit();
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
    <link rel="stylesheet" href="../Style/ManageEdit.css">
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

    <main id="main1">
    <div class="container mt-3">
        <h2><b>Edit User</b></h2>
        <form action="../Authentication/Admin/edit.php" method="post">
            <input type="hidden" name="school_id" value="<?= htmlspecialchars($user['school_id']) ?>">

            <div class="mb-3">
                <label for="full_name" class="form-label">School ID or Phone Number</label>
                <input type="text" name="school_id" class="form-control"
                oninput="this.value = this.value.replace(/[^0-9]/g, '').slice(0, 12);" 
                pattern="[0-9]{11,12}" minlength="11" maxlength="12"
                value="<?= htmlspecialchars($user['school_id']) ?>" required>
            </div>

            <div class="mb-3">
                <label for="full_name" class="form-label">Full Name</label>
                <input type="text" name="full_name" class="form-control" value="<?= htmlspecialchars($user['full_name']) ?>" required>
            </div>

            <div class="mb-3">
                <label for="position" class="form-label">Position</label>
                <select name="position" class="form-control" required>
                    <option value="Admin" <?= $user['position'] == 'Admin' ? 'selected' : '' ?>>Admin</option>
                    <option value="Maintenance Staff" <?= $user['position'] == 'Maintenance Staff' ? 'selected' : '' ?>>Maintenance Staff</option>
                    <option value="User" <?= $user['position'] == 'User' ? 'selected' : '' ?>>User</option>
                    <option value="Teacher" <?= $user['position'] == 'Teacher' ? 'selected' : '' ?>>Teacher</option>
                </select>
            </div>

            <div class="mb-3">
                <label for="userstatus" class="form-label">Status</label>
                <select name="userstatus" class="form-control" required>
                    <option value="Approved" <?= $user['userstatus'] == 'Approved' ? 'selected' : '' ?>>Approved</option>
                    <option value="Pending" <?= $user['userstatus'] == 'Pending' ? 'selected' : '' ?>>Pending</option>
                </select>
            </div>

            <button type="submit" class="btn btn-primary" id="final">Update User</button>
            <a href="Manage.php" class="btn btn-secondary">Cancel</a>
        </form>
    </div>
    </main>

    <script src="../JS/Homepage.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"
        integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz"
        crossorigin="anonymous"></script>
</body>
</html>
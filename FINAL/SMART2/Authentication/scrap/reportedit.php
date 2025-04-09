<?php
session_start();
require_once __DIR__ . "/../Authentication/checknotif.php";

if (!isset($_SESSION["position"]) || !isset($_SESSION["fname"]) || !isset($_SESSION["id"])) {
    echo "<script>
    alert('You are not logged in!');
    window.location.href = '../index.php';
    </script>";
    exit();
}

$Testsql = require __DIR__ . "/../database.php";

if (isset($_GET['delete']) && isset($_GET['type'])) {
    $id = $_GET['id'];
    $type = $_GET['type'];

    if ($type === 'location') {
        $deleteQuery = "DELETE FROM problemdetail WHERE problemloc = ?";
    } elseif ($type === 'problem') {
        $deleteQuery = "DELETE FROM problemdetail WHERE probtype = ?";
    }

    if ($deleteQuery) {
        $stmt = $Testsql->prepare($deleteQuery);
        $stmt->bind_param("s", $id);
        if ($stmt->execute()) {
            echo "<script>
                alert('Successfully deleted!');
                window.location.href = 'AdminHome.php'; // Redirect to Admin Home or Setup page
                </script>";
        } else {
            echo "<script>
                alert('Failed to delete!');
                window.location.href = 'AdminHome.php'; // Redirect to Admin Home or Setup page
                </script>";
        }
    }
    exit();
}

if (isset($_POST['add_location'])) {
    $newLocation = $_POST['location_name'];
    $addLocationQuery = "INSERT INTO problemdetail (problemloc) VALUES (?)";
    $stmt = $Testsql->prepare($addLocationQuery);
    $stmt->bind_param("s", $newLocation);
    if ($stmt->execute()) {
        echo "<script>
            alert('Location added successfully!');
            window.location.href = 'AdminHome.php'; // Redirect to Admin Home or Setup page
            </script>";
    } else {
        echo "<script>
            alert('Failed to add location!');
            window.location.href = 'AdminHome.php'; // Redirect to Admin Home or Setup page
            </script>";
    }
} elseif (isset($_POST['add_problem'])) {
    $newProblem = $_POST['problem_name'];
    $addProblemQuery = "INSERT INTO problemdetail (probtype) VALUES (?)";
    $stmt = $Testsql->prepare($addProblemQuery);
    $stmt->bind_param("s", $newProblem);
    if ($stmt->execute()) {
        echo "<script>
            alert('Problem type added successfully!');
            window.location.href = 'AdminHome.php'; // Redirect to Admin Home or Setup page
            </script>";
    } else {
        echo "<script>
            alert('Failed to add problem type!');
            window.location.href = 'AdminHome.php'; // Redirect to Admin Home or Setup page
            </script>";
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Edit Report Setup</title>
    <link href="../Style/AdminHome.css" rel="stylesheet">
</head>
<body>
    <h2>Add or Remove Locations and Problem Types</h2>

    <h3>Add Location</h3>
    <form method="POST">
        <input type="text" name="location_name" placeholder="Enter Location" required>
        <button type="submit" name="add_location">Add Location</button>
    </form>

    <h3>Add Problem Type</h3>
    <form method="POST">
        <input type="text" name="problem_name" placeholder="Enter Problem Type" required>
        <button type="submit" name="add_problem">Add Problem Type</button>
    </form>

    <h3>Existing Locations</h3>
    <ul>
    <?php
    $locationQuery = "SELECT * FROM problemdetail WHERE problemloc IS NOT NULL";
    $result = $Testsql->query($locationQuery);
    while ($row = $result->fetch_assoc()) {
        echo '<li>' . htmlspecialchars($row['problemloc']) . ' 
        <a href="reportedit.php?delete=true&id=' . urlencode($row['problemloc']) . '&type=location" onclick="return confirm(\'Are you sure?\')">Delete</a></li>';
    }
    ?>
    </ul>

    <h3>Existing Problem Types</h3>
    <ul>
    <?php
    $problemQuery = "SELECT * FROM problemdetail WHERE probtype IS NOT NULL";
    $result = $Testsql->query($problemQuery);
    while ($row = $result->fetch_assoc()) {
        echo '<li>' . htmlspecialchars($row['probtype']) . ' 
        <a href="reportedit.php?delete=true&id=' . urlencode($row['probtype']) . '&type=problem" onclick="return confirm(\'Are you sure?\')">Delete</a></li>';
    }
    ?>
    </ul>

    <a href="AdminHome.php">Back to Dashboard</a>
</body>
</html>
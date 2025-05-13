<?php
session_start();

if (!isset($_SESSION["position"])) {
    echo "<script>
    alert('You are not logged in!');
    window.location.href = '../../index.php';
    </script>";
    exit();
}

$mysqli = require __DIR__ . "/../database.php";

// Get the current user's ID and position
$fname = $_SESSION["fname"];
$position = $_SESSION["position"];

$sql = "SELECT * FROM userinfo WHERE full_name = ? AND position = ?";
$stmt = $mysqli->prepare($sql);
$stmt->bind_param("ss", $fname, $position);
$stmt->execute();
$result = $stmt->get_result();
$user = $result->fetch_assoc();

$rid = $user["school_id"] ?? null;

// Different behavior based on user position
switch ($position) {
    case "Admin":
    case "Maintenance Staff":
        // Admin and Maintenance Staff can mark all notifications as read
        $sql = "UPDATE reportdetails SET is_read = 1 WHERE status IN ('Pending', 'Ongoing', 'Resolved')";
        $stmt = $mysqli->prepare($sql);
        break;
    
    default:
        // Regular users only mark their own notifications as read
        $sql = "UPDATE reportdetails SET is_read = 1 WHERE rid = ? AND status IN ('Pending', 'Ongoing', 'Resolved')";
        $stmt = $mysqli->prepare($sql);
        $stmt->bind_param("i", $rid);
        break;
}

$stmt->execute();

// Redirect back to notifications page
header("Location: ../Page/Notification.php");
exit();
?>
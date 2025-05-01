<?php
session_start();
require __DIR__ . "/../database.php";

$school_id = $_SESSION["id"] ?? null;

$fname = $_SESSION["fname"];
$position = $_SESSION["position"];

$sql = "SELECT * FROM userinfo WHERE full_name = ? AND position = ?";
$stmt = $mysqli->prepare($sql);
$stmt->bind_param("ss", $fname, $position);
$stmt->execute();
$result = $stmt->get_result();
$user = $result->fetch_assoc();

$rid = $user["school_id"] ?? null;

switch ($position) {
    case "Admin":
    case "Maintenance Staff":
        $sql = "UPDATE reportdetails SET is_read = 1 WHERE status IN ('Pending', 'Ongoing', 'Resolved')";
        $stmt = $mysqli->prepare($sql);
        break;
    
    default:
        $sql = "UPDATE reportdetails SET is_read = 1 WHERE rid = ? AND status IN ('Pending', 'Ongoing', 'Resolved')";
        $stmt = $mysqli->prepare($sql);
        $stmt->bind_param("i", $rid);
        break;
}

header("Location: ../Page/Notification.php");
exit();
?>

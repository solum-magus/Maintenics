<?php
session_start();
require_once __DIR__ . "/../database.php";

if (!isset($_SESSION["position"])) {
    echo json_encode(["error" => "Not logged in"]);
    exit();
}

$Testsql = require __DIR__ . "/../database.php";

$fname = $_SESSION["fname"];
$position = $_SESSION["position"];

$sql = "SELECT * FROM userinfo WHERE full_name = ? AND position = ?";
$stmt = $Testsql->prepare($sql);
$stmt->bind_param("ss", $fname, $position);
$stmt->execute();
$result = $stmt->get_result();
$user = $result->fetch_assoc();

$rid = $user["school_id"] ?? null;

switch ($position) {
    case "Admin":
    case "Maintenance Staff":
        $sql = "SELECT r.*, u.full_name as reporter_name 
                FROM reportdetails r
                LEFT JOIN userinfo u ON r.rid = u.school_id
                WHERE r.status = 'Pending' AND r.is_read = 0
                ORDER BY r.date_reported DESC LIMIT 1";
        $stmt = $Testsql->prepare($sql);
        break;
    
    default:
        $sql = "SELECT * FROM reportdetails 
                WHERE rid = ? AND status = 'Pending' AND is_read = 0
                ORDER BY date_reported DESC LIMIT 1";
        $stmt = $Testsql->prepare($sql);
        $stmt->bind_param("i", $rid);
        break;
}

$stmt->execute();
$result = $stmt->get_result();
$newNotification = $result->fetch_assoc();

if ($newNotification) {
    echo json_encode(["new" => true, "report" => $newNotification]);
} else {
    echo json_encode(["new" => false]);
}
?>
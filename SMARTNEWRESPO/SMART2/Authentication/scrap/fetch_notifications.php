<?php
session_start();
require_once __DIR__ . "/../database.php";

if (!isset($_SESSION["position"])) {
    echo json_encode(["error" => "Not logged in"]);
    exit();
}

$Testsql = require __DIR__ . "/../database.php";

// Fetch only the latest unread notification
$sql = "SELECT * FROM reportdetails WHERE status = 'Pending' AND is_read = 0 ORDER BY date_reported DESC LIMIT 1";
$result = $Testsql->query($sql);

$newNotification = $result->fetch_assoc();

if ($newNotification) {
    echo json_encode(["new" => true, "report" => $newNotification]);
} else {
    echo json_encode(["new" => false]);
}
?>
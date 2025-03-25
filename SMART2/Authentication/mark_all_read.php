<?php
session_start();
require __DIR__ . "/../database.php";

$school_id = $_SESSION["school_id"] ?? null;

if ($school_id) {
    $sql = "UPDATE reportdetails SET is_read = TRUE WHERE status IN ('Pending', 'Ongoing', 'Resolved')";
    $mysqli->query($sql);
}

header("Location: ../Page/Notification.php");
exit();
?>
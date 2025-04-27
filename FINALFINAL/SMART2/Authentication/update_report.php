<?php
session_start();

if (!isset($_SESSION["position"]) || ($_SESSION["position"] !== "Admin" && $_SESSION["position"] !== "Maintenance Staff")) {
    header("Location: ../index.php");
    exit();
}

$Testsql = require __DIR__ . "/../database.php";

$report_id = $_POST["report_id"];

$sql = "SELECT status FROM reportdetails WHERE report_id = ?";
$stmt = $Testsql->prepare($sql);
$stmt->bind_param("i", $report_id);
$stmt->execute();
$result = $stmt->get_result();
$row = $result->fetch_assoc();

if ($row) {
    if ($row['status'] === 'Ongoing') {
        $update_sql = "UPDATE reportdetails SET status = 'Resolved', date_resolved = NOW() WHERE report_id = ?";
        $update_stmt = $Testsql->prepare($update_sql);
        $update_stmt->bind_param("i", $report_id);
        $update_stmt->execute();
        echo "<script>alert('Report marked as resolved.'); window.location.href = '../Page/Notification.php';</script>";
    } else {
        $update_sql = "UPDATE reportdetails SET status = 'Ongoing' WHERE report_id = ?";
        $update_stmt = $Testsql->prepare($update_sql);
        $update_stmt->bind_param("i", $report_id);
        $update_stmt->execute();
        echo "<script>alert('Report marked as ongoing.'); window.location.href = '../Page/Notification.php';</script>";
    }
} else {
    echo "<script>alert('Report not found.'); window.location.href = '../Page/Notification.php';</script>";
}
?>

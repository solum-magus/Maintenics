<?php
session_start();

if ($_SERVER["REQUEST_METHOD"] === "POST") {
    $Testsql = require __DIR__ . "/../database.php";

    $report_id = $_POST['report_id'] ?? null;
    $new_status = $_POST['status'] ?? null;

    if ($report_id && $new_status) {
        $sql = "UPDATE reportdetails SET status = ? WHERE report_id = ?";
        $stmt = $Testsql->prepare($sql);
        $stmt->bind_param("si", $new_status, $report_id);
        if ($stmt->execute()) {
            echo "Report status updated successfully!";
        } else {
            echo "Failed to update report status!";
        }
    } else {
        echo "Invalid request!";
    }
}
?>
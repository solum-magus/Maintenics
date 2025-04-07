<?php
require __DIR__ . '/../database.php';

if (isset($_POST['submit_feedback'])) {
    $report_id = $_POST['report_id'];
    $feedback = $_POST['feedback'];
    $rating = isset($_POST["rating$report_id"]) ? $_POST["rating$report_id"] : null; // Check if rating exists

    if (!empty($report_id) && !empty($rating) && !empty($feedback)) {
        $sql = "UPDATE reportdetails SET rating = ?, feedback = ? WHERE report_id = ?";
        $stmt = $mysqli->prepare($sql);
        $stmt->bind_param("isi", $rating, $feedback, $report_id);

        if ($stmt->execute()) {
            echo "<script>alert('Feedback submitted successfully!'); window.location.href='../Page/History.php';</script>";
        } else {
            echo "<script>alert('Something went wrong.'); window.location.href='../Page/History.php';</script>";
        }

        $stmt->close();
        $mysqli->close();
    } else {
        echo "<script>alert('Already rated this report!'); window.location.href='../Page/History.php';</script>";
    }
}
?>

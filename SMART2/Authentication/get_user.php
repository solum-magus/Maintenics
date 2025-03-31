<?php
session_start();
header("Content-Type: application/json");

// Debugging session ID
if (!isset($_SESSION["id"])) {
    echo json_encode(["error" => "User not logged in", "session" => $_SESSION]);
    exit;
}

$school_id = $_SESSION["id"];

$mysqli = require __DIR__ . "/../database.php";

$sql = "SELECT school_id, full_name FROM userinfo WHERE school_id = ?";
$stmt = $mysqli->prepare($sql);
$stmt->bind_param("i", $school_id);
$stmt->execute();
$result = $stmt->get_result();

if ($row = $result->fetch_assoc()) {
    echo json_encode([
        "rid" => $row["school_id"],
        "rname" => $row["full_name"]
    ]);
} else {
    echo json_encode(["error" => "User not found", "session_id" => $school_id]);
}

$stmt->close();
$mysqli->close();
?>

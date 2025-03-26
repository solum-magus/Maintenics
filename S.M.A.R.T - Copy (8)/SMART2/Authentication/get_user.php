<?php
header("Content-Type: application/json"); // Set response to JSON format

// Include database connection
$mysqli = require __DIR__ . "/../database.php"; // Make sure this file exists

session_start();

if (!isset($_SESSION["id"])) {
    echo json_encode(["error" => "User not logged in"]);
    exit;
}

$school_id = $_SESSION["school_id"];

// Use `$mysqli` (not `$conn`) for database queries
$sql = "SELECT full_name FROM userinfo WHERE school_id = ?";
$stmt = $mysqli->prepare($sql);

if (!$stmt) {
    echo json_encode(["error" => "Database query failed"]);
    exit;
}

$stmt->bind_param("i", $school_id);
$stmt->execute();
$result = $stmt->get_result();

if ($row = $result->fetch_assoc()) {
    echo json_encode(["rname" => $row["full_name"]]); // Send full_name as rname
} else {
    echo json_encode(["error" => "User not found"]);
}

$stmt->close();
$mysqli->close();
?>

<?php
session_start();
$mysqli = require __DIR__ . "/../database.php";

if (!isset($_SESSION["school_id"])) {
    echo json_encode(["error" => "User not logged in"]);
    exit;
}

$user_id = $_SESSION["school_id"]; // Assuming user_id is stored in session

// Fetch the user's full name from userinfo
$stmt = $conn->prepare("SELECT full_name FROM userinfo WHERE id = ?");
$stmt->bind_param("i", $user_id);
$stmt->execute();
$stmt->bind_result($full_name);
$stmt->fetch();
$stmt->close();
$conn->close();

if ($full_name) {
    echo json_encode(["rname" => $full_name]); // Return full_name as rname
} else {
    echo json_encode(["error" => "User not found"]);
}
?>

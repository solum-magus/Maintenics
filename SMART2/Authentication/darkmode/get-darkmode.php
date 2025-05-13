<?php
session_start();
require __DIR__ . "/config.php"; 

if (!isset($_SESSION['id'])) {
    exit(json_encode(["error" => "Unauthorized access"]));
}

$userId = $_SESSION['id'];
$sql = "SELECT dark_mode FROM userinfo WHERE school_id = ?";
$stmt = $conn->prepare($sql);
$stmt->bind_param("i", $userId);
$stmt->execute();
$result = $stmt->get_result();
$row = $result->fetch_assoc();

echo json_encode(["dark_mode" => $row ? $row["dark_mode"] : "0"]); 
$stmt->close();
$conn->close();
?>

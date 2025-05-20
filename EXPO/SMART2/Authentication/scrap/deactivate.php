<?php
session_start();
$mysqli = require __DIR__ . "/../database.php";

if (!isset($_SESSION["position"]) || $_SESSION["position"] !== "Admin") {
    die("Access Denied");
}

if (isset($_GET['id'])) {
    $id = intval($_GET['id']);
    $sql = "UPDATE userinfo SET userstatus = 'Deactivated' WHERE id = ?";
    $stmt = $mysqli->prepare($sql);
    $stmt->bind_param("i", $id);
    if ($stmt->execute()) {
        echo "<script>alert('User Deactivated!'); window.location.href = 'ManageUsers.php';</script>";
    } else {
        echo "<script>alert('Error deactivating user.'); window.location.href = 'ManageUsers.php';</script>";
    }
}
?>

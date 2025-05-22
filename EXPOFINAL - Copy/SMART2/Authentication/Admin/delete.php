<?php
session_start();

if (!isset($_SESSION["position"]) || $_SESSION["position"] !== "Admin") {
    echo "<script>
    alert('Access Denied!');
    window.location.href = '../index.php';
    </script>";
    exit();
}

if (!isset($_GET['id']) || empty($_GET['id'])) {
    echo "<script>
    alert('Invalid User ID!');
    window.location.href = '../../Admin.php';
    </script>";
    exit();
}

if (!isset($_SESSION["position"]) || $_SESSION["position"] !== "Admin") {
    die("Access Denied");
}

$mysqli = require __DIR__ . "/../../database.php";

$stmt = $mysqli->prepare("DELETE FROM userinfo WHERE school_id = ?");
if (!$stmt) {
    header("Location: ../../Page/AdminHome.php?error=db_error");
    exit();
}

$user_id = trim($_GET['id']);
$stmt->bind_param("s", $user_id);

if ($stmt->execute()) {
    if ($stmt->affected_rows > 0) {
        header("Location: ../../Page/AdminHome.php?success=user_deleted");
    } else {
        header("Location: ../../Page/AdminHome.php?error=user_not_found");
    }
} else {
    header("Location: ../../Page/AdminHome.php?error=delete_failed");
}

$stmt->close();
$mysqli->close();
?>
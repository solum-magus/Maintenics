<?php
session_start();

if (!isset($_SESSION["position"]) || $_SESSION["position"] !== "Admin") {
    echo "<script>
    alert('Access Denied!');
    window.location.href = '../index.html';
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

$user_id = $mysqli->real_escape_string($_GET['id']);

$sql = "DELETE FROM userinfo WHERE school_id = '$user_id'";
if ($mysqli->query($sql)) {
    echo "<script>
    alert('User deleted successfully!');
    window.location.href = '../../Pages/Manage.php';
    </script>";
} else {
    echo "<script>
    alert('Error deleting user!');
    window.location.href = '../../Pages/Manage.php';
    </script>";
}
?>
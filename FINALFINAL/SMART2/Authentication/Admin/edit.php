<?php
session_start();

if (!isset($_SESSION["position"]) || $_SESSION["position"] !== "Admin") {
    echo "<script>
    alert('Access Denied!');
    window.location.href = '../index.php';
    </script>";
    exit();
}

$mysqli = require __DIR__ . "/../../database.php";

if ($_SERVER["REQUEST_METHOD"] == "POST") {

    $school_id = $_POST["school_id"];
    $full_name = $_POST["full_name"];
    $position = $_POST["position"];
    $userstatus = $_POST["userstatus"];

    $stmt = $mysqli->prepare("UPDATE userinfo SET full_name = ?, position = ?, userstatus = ? WHERE school_id = ?");
    $stmt->bind_param("sssi", $full_name, $position, $userstatus, $school_id);


    if ($stmt->execute()) {
        echo "<script>
            window.location.href = '../../Page/AdminHome.php';
        </script>";
    } else {
        echo "<script>
        window.location.href = '../../Page/ManageEdit.php';
        alert('There was an issue in changing user information.');
        </script>";
    }
}
?>

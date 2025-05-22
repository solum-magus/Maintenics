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
    $original_school_id = $_POST["original_school_id"];
    $new_school_id = $_POST["new_school_id"];
    $full_name = $_POST["full_name"];
    $position = $_POST["position"];
    $userstatus = $_POST["userstatus"];

    $check_stmt = $mysqli->prepare("SELECT school_id FROM userinfo WHERE school_id = ? AND school_id != ?");
    $check_stmt->bind_param("ss", $new_school_id, $original_school_id);
    $check_stmt->execute();
    $check_result = $check_stmt->get_result();

    if ($check_result->num_rows > 0) {
        echo "<script>
            alert('Error: This school email is already registered.');
            window.location.href = '../../Page/ManageEdit.php?id=" . $original_school_id . "';
        </script>";
        exit();
    }

    $stmt = $mysqli->prepare("UPDATE userinfo SET school_id = ?, full_name = ?, position = ?, userstatus = ? WHERE school_id = ?");
    $stmt->bind_param("sssss", $new_school_id, $full_name, $position, $userstatus, $original_school_id);

    if ($stmt->execute()) {
        echo "<script>
            window.location.href = '../../Page/AdminHome.php';
        </script>";
    } else {
        echo "<script>
            alert('There was an issue in changing user information.');
            window.location.href = '../../Page/ManageEdit.php?id=" . $original_school_id . "';
        </script>";
    }
}
?>
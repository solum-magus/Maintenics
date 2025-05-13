<?php
session_start();

if (!isset($_SESSION["position"])) {
    echo "<script>
    alert('You are not logged in!');
    window.location.href = '../index.php';
    </script>";
    exit();
}

if ($_SERVER["REQUEST_METHOD"] === "POST") {
    $mysqli = require __DIR__ . "/../database.php";

    $school_id = $_POST["school_id"];
    $current_password = $_POST["current_password"];
    $new_password = $_POST["new_password"];
    $confirm_password = $_POST["confirm_password"];

    $sql = "SELECT * FROM userinfo WHERE school_id = ?";
    $stmt = $mysqli->prepare($sql);
    $stmt->bind_param("s", $school_id);
    $stmt->execute();
    $result = $stmt->get_result();
    $user = $result->fetch_assoc();

    if ($user && password_verify($current_password, $user["hashword"])) {
        if ($new_password === $confirm_password) {
            $new_hashed_password = password_hash($new_password, PASSWORD_DEFAULT);

            $update_sql = "UPDATE userinfo SET hashword = ? WHERE school_id = ?";
            $stmt = $mysqli->prepare($update_sql);
            $stmt->bind_param("ss", $new_hashed_password, $school_id);

            if ($stmt->execute()) {
                $_SESSION["success"] = "Password changed successfully.";
                if (isset($_SESSION["position"])) {
                    switch ($_SESSION["position"]) {
                        case "Student":
                            header("Location: ../Page/Home.php");
                            exit();
                        case "Teacher":
                            header("Location: ../Page/Home.php");
                            exit();
                        case "Admin":
                            header("Location: ../Page/AdminHome.php");
                            exit();
                        case "Maintenance Staff":
                            header("Location: ../Page/MaintenanceHome.php");
                            exit();
                        default:
                            header("Location: ../index.php");
                            exit();
                    }
                }
                exit();
            } else {
                $_SESSION["error"] = "Error updating password.";
            }
        } else {
            $_SESSION["error"] = "New password and confirm password do not match.";
        }
    } else {
        $_SESSION["error"] = "Incorrect current password.";
    }

    header("Location: ../Page/Settings.php");
    exit();
}
?>

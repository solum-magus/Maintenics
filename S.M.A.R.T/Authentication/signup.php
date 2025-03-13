<?php
    error_reporting(E_ALL);
    ini_set('display_errors', 1);

    $full_name = $_POST["full_name"];
    if (strlen($full_name) < 3 || strlen($full_name) > 70) {
        echo "<script>
            alert('Full name must be at least 3 characters long and less than 70 characters.');
            window.location.href = '../index.html';
        </script>";
        exit();
    }

    $password = $_POST["password"];
    if (strlen($password) < 8) {
        echo "<script>
            alert('Password must be at least 8 characters long.');
            window.location.href = '../index.html';
        </script>";
        exit();
    }

    if ($_POST["password"] !== $_POST["confirm_password"]) {
        echo "<script>
            alert('Passwords must match.');
            window.location.href = '../index.html';
        </script>";
        exit;
    }

    $school_id = $_POST["school_id"];
    if (preg_match("/[a-zA-Z]/", $school_id)) {
        echo "<script>
            alert('Only numbers are allowed.');
            window.location.href = '../index.html';
        </script>";
        exit;
    }

    $school_id = $_POST["school_id"];

    $mysqli = require __DIR__ . "/../database.php";

    $sql_check = "SELECT * FROM userinfo WHERE school_id = ?";
    $stmt_check = $mysqli->prepare($sql_check);
    $stmt_check->bind_param("s", $school_id);
    $stmt_check->execute();
    $result_check = $stmt_check->get_result();

    if ($result_check->num_rows > 0) {
        echo "<script>
            alert('This ID/Number is already taken.');
            window.location.href = '../index.html';
        </script>";
        exit();
    }

    $hashword = password_hash($_POST["password"], PASSWORD_DEFAULT);

    $sql = "INSERT INTO userinfo (position, full_name, school_id, hashword, userstatus)
            VALUES (?, ?, ?, ?, ?)";
    
    $insert = $mysqli->stmt_init();

    $insert->prepare($sql);

    $position = trim($_POST["position"]);
 
    if ($position === 'Maintenance Staff' || $position === 'Admin') {
    $userstatus = "Pending";
    } else {
        $userstatus = "Approved";
    }

    $insert->bind_param("ssiss",
                        $position,
                        $_POST["full_name"],
                        $_POST["school_id"],
                        $hashword,
                        $userstatus);

    try {
    $insert->execute();
        header("Location: ../index.html");
        exit;
    } catch (Exception) {
        echo "<script>
            alert('This ID is already taken.');
            window.location.href = '../index.html';
        </script>";
    }
?>

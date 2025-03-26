<?php

    if ($_SERVER["REQUEST_METHOD"] === "POST") {

        $mysqli = require __DIR__ . "/../database.php";
        $sql = sprintf("SELECT * FROM userinfo
                        WHERE school_id = '%s'",
                        $mysqli->real_escape_string($_POST["school_id"]));
        
        $data = $mysqli->query($sql);
        $user = $data->fetch_assoc();

        if ($user && password_verify($_POST["current_password"], $user["hashword"])) {
            if ($_POST["new_password"] === $_POST["confirm_password"]) {
                $new_hashed_password = password_hash($_POST["new_password"], PASSWORD_DEFAULT);
    
                $update_sql = "UPDATE userinfo SET hashword = ? WHERE school_id = ?";
                $stmt = $mysqli->prepare($update_sql);
                $stmt->bind_param("ss", $new_hashed_password, $_POST["school_id"]);
    
                if ($stmt->execute()) {
                    echo "Password changed successfully.";
                    header("Location: ../Page/Home.php"); //this probably needs a swich or if statement for if youre an admin or student
                } else {
                    echo "Error updating password.";
                }
            } else {
                echo "New password and confirm password do not match.";
            }
        } else {
            echo "Incorrect current password.";
        }
    }
    ?>
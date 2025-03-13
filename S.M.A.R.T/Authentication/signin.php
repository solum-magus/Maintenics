<?php

    $invalid_signin = false;

    if ($_SERVER["REQUEST_METHOD"] === "POST") {

        $mysqli = require __DIR__ . "/../database.php";
        $sql = sprintf("SELECT * FROM userinfo
                        WHERE full_name = '%s'",
                        $mysqli->real_escape_string($_POST["signin_school_id"]));
        
        $data = $mysqli->query($sql);

        $user = $data->fetch_assoc();

        if ($user) {
                        // Check if user status is "Pending"
            if ($user["userstatus"] === "Pending") {
                echo "<script>alert('Your account is still pending approval.');
                    window.location.href = '../index.html';
                    </script>";
                exit;
            }
            if (password_verify($_POST["signin_password"], $user["hashword"])) {

                switch ($user["position"]) {
                    case "Student":

                        session_start();
                        session_regenerate_id();

                        $_SESSION["fname"] = $user["full_name"];
                        $_SESSION["id"] = $user["school_id"];
                        $_SESSION["position"] = $user["position"];
                        $_SESSION["bio"] = $user["bio"];

                        header("Location: ../Pages/Homepage.php");

                        exit;
                    case "Admin":

                        session_start();
                        session_regenerate_id();

                        $_SESSION["fname"] = $user["full_name"];
                        $_SESSION["id"] = $user["school_id"];
                        $_SESSION["position"] = $user["position"];
                        $_SESSION["bio"] = $user["bio"];

                        header("Location: ../Pages/Admin.php");
                        exit;
                    case "Teacher":

                        session_start();
                        session_regenerate_id();

                        $_SESSION["fname"] = $user["full_name"];
                        $_SESSION["id"] = $user["school_id"];
                        $_SESSION["position"] = $user["position"];
                        $_SESSION["bio"] = $user["bio"];

                        header("Location: ../Pages/Homepage.php");
                        exit;
                    case "Maintenance Staff":

                        session_start();
                        session_regenerate_id();

                        $_SESSION["fname"] = $user["full_name"];
                        $_SESSION["id"] = $user["school_id"];
                        $_SESSION["position"] = $user["position"];
                        $_SESSION["bio"] = $user["bio"];

                        header("Location: ../Pages/Admin.php");
                        exit;
                }

            }

        }
        
        $invalid_signin = true;

        if ($invalid_signin === true) {
            echo "<script>alert('User not found. Please enter information correctly.');
                window.location.href = '../index.html';
            </script>";
            exit;
        }

    }

?>

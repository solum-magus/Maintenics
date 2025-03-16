<?php
session_start();  // Start the session to store errors

$invalid_signin = false;
$error_message2 = "";

if ($_SERVER["REQUEST_METHOD"] === "POST") {
    $mysqli = require __DIR__ . "/../database.php";

    // Get user input
    $entered_name = trim($_POST["signin_full_name"]); // Match input name from the form
    $password = $_POST["signin_password"];

    // Query to find user by full name
    $sql = "SELECT * FROM userinfo WHERE full_name = ?";
    $stmt = $mysqli->prepare($sql);
    $stmt->bind_param("s", $entered_name);
    $stmt->execute();
    $result = $stmt->get_result();
    $user = $result->fetch_assoc();

    if ($user) {
        // Check if the user is pending approval
        if ($user["userstatus"] === "Pending") {
            $_SESSION["error_message2"] = "Your account is still pending approval.";
            $_SESSION["entered_name"] = $entered_name;
            header("Location: ../index.php");
            exit();
        }

        // Verify password
        if (password_verify($password, $user["hashword"])) {
            session_regenerate_id();

            $_SESSION["fname"] = $user["full_name"];
            $_SESSION["id"] = $user["school_id"];
            $_SESSION["position"] = $user["position"];
            $_SESSION["bio"] = $user["bio"];
            $_SESSION["userstatus"] = $userstatus;

            // Redirect based on position
            $redirectPage = ($user["position"] === "Admin" || $user["position"] === "Maintenance Staff") 
                ? "../Pages/Admin.php" 
                : "../Pages/Homepage.php";

            header("Location: $redirectPage");
            exit();
        } else {
            $invalid_signin = true;
            $_SESSION["error_message2"] = "Incorrect password. Please try again.";
        }
    } else {
        $invalid_signin = true;
        $_SESSION["error_message2"] = "Name not found. Please enter information correctly.";
    }

    $_SESSION["entered_name"] = $entered_name; // Store input so it doesn’t reset
    header("Location: ../index.php"); // Redirect back to index.php
    exit();
}
?>

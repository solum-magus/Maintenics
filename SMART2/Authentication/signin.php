<?php
session_start();  // Start the session to store errors
echo "<pre>";
print_r($_SESSION);
echo "</pre>";

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

            switch ($user["position"]) {
                case "Admin":
                    $redirectPage = "../Page/AdminHome.php";
                    break;
                case "Maintenance Staff":
                    $redirectPage = "../Page/MaintenanceHome.php";
                    break;
                case "Student":
                case "Teacher":
                    $redirectPage = "../Page/Home.php";
                    break;
                default:
                    $redirectPage = "../index.php"; // Fallback for unknown positions
            }
            
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

<?php
session_start();
$mysqli = require __DIR__ . "/../database.php"; // Make sure this returns $mysqli

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $rname = $_POST["rname"]; // This was fetched as full_name from userinfo
    $plocation = $_POST["plocation"];
    $problem = $_POST["problem"];
    $pdescription = $_POST["pdescription"];

    // Insert into reportdetails
    $stmt = $mysqli->prepare("INSERT INTO reportdetails (rname, plocation, problem, pdescription) VALUES (?, ?, ?, ?)");
    
    if (!$stmt) {
        die("Prepare failed: " . $mysqli->error);
    }

    $stmt->bind_param("ssss", $rname, $plocation, $problem, $pdescription);

    if ($stmt->execute()) {
        $_SESSION["report_submitted"] = true;
        header("Location: ../Page/Home.php");
        exit();
    } else {
        echo "Error submitting report: " . $stmt->error;
    }

    $stmt->close();
    $mysqli->close();
}
?>

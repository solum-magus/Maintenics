<?php
session_start();
require __DIR__ . "/config.php"; // Ensure database connection

if (!isset($_SESSION['id'])) {
    exit("Unauthorized access");
}

$userId = $_SESSION['id'];

if ($_SERVER["REQUEST_METHOD"] === "POST") {
    $darkMode = isset($_POST['darkMode']) && $_POST['darkMode'] == "1" ? 1 : 0;

    $sql = "UPDATE userinfo SET dark_mode = ? WHERE school_id = ?";
    $stmt = $conn->prepare($sql);

    if (!$stmt) {
        error_log("SQL Error: " . $conn->error);
        exit("Database error!");
    }

    $stmt->bind_param("ii", $darkMode, $userId);

    if ($stmt->execute()) {
        $_SESSION['dark_mode'] = $darkMode; // Store in session
        echo "success";
    } else {
        error_log("DB Update Failed: " . $stmt->error);
        echo "error";
    }

    $stmt->close();
    $conn->close();
} elseif ($_SERVER["REQUEST_METHOD"] === "GET") {
    // Retrieve the current dark mode setting
    $sql = "SELECT dark_mode FROM userinfo WHERE school_id = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("i", $userId);
    $stmt->execute();
    $stmt->bind_result($darkMode);
    $stmt->fetch();

    echo json_encode(["darkMode" => $darkMode]); // Send response as JSON

    $stmt->close();
    $conn->close();
}
?>

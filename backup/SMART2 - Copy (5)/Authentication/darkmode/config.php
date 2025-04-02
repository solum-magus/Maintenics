<?php
$host = "localhost";
$database = "smartdb";
$username = "root";
$password = "";

$conn = new mysqli($host, $username, $password, $database);

if ($conn->connect_errno) {
    die("Database Connection Failed: " . $conn->connect_error);
}
?>

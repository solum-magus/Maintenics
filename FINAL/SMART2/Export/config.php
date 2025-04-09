<?php

    $host = "localhost";
    $database = "smartdb";
    $username = "root";
    $password = "";

$conn = mysqli_connect($host, $username, $password, $database);

if (!$conn) {
    echo "<script>
            alert('Connection Failed.');
        </script>";
}
?>

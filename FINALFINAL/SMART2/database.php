<?php

    $host = "localhost";
    $database = "smartdb";
    $username = "root";
    $password = "";

    $mysqli = new mysqli(hostname: $host,
                         database: $database,
                         username: $username,
                         password: $password);

    if ($mysqli->connect_errno) {
        echo "<script>
            alert('Connection Failed.');
            window.location.href = '../index.html';
        </script>";
    }

    return $mysqli;

?>
<?php

$mysqli = require __DIR__ . "/../database.php";


$rid = ($_POST["rid"]);

$sql = "INSERT INTO reportdetails (rname, plocation, problem, pdescription, rid)
        VALUES (?, ?, ?, ?, ?)";

$insert = $mysqli->stmt_init();

$insert->prepare($sql);

if ($rid === null) {
    die("Error: rid is NULL. Check form submission.");
}
$insert->bind_param("sssss",
                    $_POST["rname"],
                    $_POST["plocation"],
                    $_POST["problem"],
                    $_POST["pdescription"],
                    $rid);

try {
$insert->execute();
} catch (Exception) {
    echo
    "<script>
        alert('There was a problem submitting your report.');
        window.location.href = '../Page/Homepage.php';
    </script>";
}
    

?>

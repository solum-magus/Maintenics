<?php

    $mysqli = require __DIR__ . "/../database.php";

    $sql = "INSERT INTO reportdetails (rname, plocation, problem, pdescription)
            VALUES (?, ?, ?, ?)";

    $insert = $mysqli->stmt_init();

    $insert->prepare($sql);

    $insert->bind_param("ssss",
                        $_POST["rname"],
                        $_POST["plocation"],
                        $_POST["problem"],
                        $_POST["pdescription"]);

    try {
    $insert->execute();
        echo
        "<script>
            alert('Your report has been submitted.');
            window.location.href = '../Pages/Homepage.php';
        </script>";
        
        exit;
    } catch (Exception) {
        echo
        "<script>
            alert('There was a problem submitting your report.');
            window.location.href = '../Pages/Homepage.php';
        </script>";
    }
    

?>

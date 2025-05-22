<?php 
if (!isset($_SESSION["position"]) === "Pending" || !isset($_SESSION["position"]) === "Rejected") {
    header("Location: ../index.php");
    exit();
}
?>
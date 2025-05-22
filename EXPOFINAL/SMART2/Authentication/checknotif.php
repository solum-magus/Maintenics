<?php

function checkUnreadNotifications($Testsql, $rid = null) {
    if ($rid === null) {
        $sql = "SELECT COUNT(*) as count FROM reportdetails WHERE is_read = 0";
        $result = $Testsql->query($sql);
    } else {
        $sql = "SELECT COUNT(*) as count FROM reportdetails WHERE rid = ? AND is_read = 0";
        $stmt = $Testsql->prepare($sql);
        $stmt->bind_param("s", $rid);
        $stmt->execute();
        $result = $stmt->get_result();
    }
    
    $row = $result->fetch_assoc();
    return ($row['count'] > 0);
}

?>
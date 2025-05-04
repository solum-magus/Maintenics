<?php

function checkUnreadNotifications($Testsql, $rid = null) {
    if ($rid === null) {
        // For Admin and Maintenance Staff - check all unread notifications
        $sql = "SELECT COUNT(*) as count FROM reportdetails WHERE is_read = 0";
        $result = $Testsql->query($sql);
    } else {
        // For regular users - check only their unread notifications
        $sql = "SELECT COUNT(*) as count FROM reportdetails WHERE rid = ? AND is_read = 0";
        $stmt = $Testsql->prepare($sql);
        $stmt->bind_param("i", $rid);
        $stmt->execute();
        $result = $stmt->get_result();
    }
    
    $row = $result->fetch_assoc();
    return ($row['count'] > 0);
}

?>
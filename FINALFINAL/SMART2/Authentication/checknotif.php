<?php

function checkUnreadNotifications($Testsql, $rid = null) {
    if ($rid === null) {
        $sql = "SELECT * FROM reportdetails WHERE status IN ('Pending', 'Ongoing', 'Resolved') AND is_read = 0 ORDER BY date_reported DESC";
        $result = $Testsql->query($sql);
    } else {
        $sql = "SELECT * FROM reportdetails WHERE rid = ? AND status IN ('Pending', 'Ongoing', 'Resolved') AND is_read = 0 ORDER BY date_reported DESC";
        $stmt = $Testsql->prepare($sql);
        $stmt->bind_param("i", $rid);
        $stmt->execute();
        $result = $stmt->get_result();
    }

    return ($result->num_rows > 0);
}

?>
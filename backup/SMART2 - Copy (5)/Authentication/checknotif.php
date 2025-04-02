<?php

function checkUnreadNotifications($Testsql) {
    $sql = "SELECT * FROM reportdetails WHERE status IN ('Pending', 'Ongoing', 'Resolved') ORDER BY date_reported DESC";
    $reports = $Testsql->query($sql);

    $hasUnread = false;
    if ($reports->num_rows > 0) {
        while ($row = $reports->fetch_assoc()) {
            if ($row['is_read'] == 0) {
                $hasUnread = true;
                break;  // Stop once we find the first unread notification
            }
        }
    }
    return $hasUnread;
}

?>
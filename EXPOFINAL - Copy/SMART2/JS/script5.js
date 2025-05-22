function updateStatus(reportId, newStatus) {
    if (!confirm("Are you sure you want to update the report status?")) {
        return;
    }

    let xhr = new XMLHttpRequest();
    xhr.open("POST", "../Authentication/change_status.php", true);
    xhr.setRequestHeader("Content-Type", "application/x-www-form-urlencoded");

    xhr.onreadystatechange = function () {
        if (xhr.readyState == 4 && xhr.status == 200) {
            alert(xhr.responseText);
            location.reload();
        }
    };

    xhr.send("report_id=" + reportId + "&status=" + newStatus);
}
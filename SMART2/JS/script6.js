document.addEventListener("DOMContentLoaded", function () {
    let lastPlayedReportId = localStorage.getItem("lastPlayedReportId") || null;
    const notifIcon = document.getElementById("Notifications");

    let soundPlayed = localStorage.getItem("soundPlayed") === 'true'; 

    function fetchNotifications() {
        fetch("../Authentication/fetch_notifications.php")
            .then(response => response.json())
            .then(data => {
                if (data.new && data.report && data.report.report_id) {
                    const currentReportId = String(data.report.report_id);
                    const lastPlayedReportId = localStorage.getItem("lastPlayedReportId");
            
                    if (currentReportId !== lastPlayedReportId) {
                        playNotificationSound();
                        localStorage.setItem("lastPlayedReportId", currentReportId);
                    } else {
                        console.log("Same notification, skipping sound.");
                    }
            
                    changeNotificationIcon(true);
                    updateNotificationUI(data.report);
                } else {
                    changeNotificationIcon(false);
                }
            })
    }

    function playNotificationSound() {
        const audio = new Audio("../Assets/newnotif.ogg");
        audio.play()
            .then(() => {
                console.log("Notification sound played successfully.");
            })
            .catch((error) => {
                console.error("Failed to play notification sound:", error);
            });
    }

    function updateNotificationUI(report) {
        const notificationContainer = document.querySelector(".notification-container");

        if (document.querySelector(`[data-id="${report.report_id}"]`)) return;

        const box = document.createElement("div");
        box.className = "box1";
        box.setAttribute("data-id", report.report_id);
        box.innerHTML = ` 
            <span class="overlayt">A report was submitted!<br>
            Report ID: ${report.report_id}</span>
            <span class="timestamp">${timeAgo(report.date_reported)}</span>
        `;
        notificationContainer.prepend(box);
    }

    function timeAgo(timestamp) {
        const now = new Date();
        const past = new Date(timestamp);
        const seconds = Math.floor((now - past) / 1000);

        if (seconds < 60) return `${seconds} seconds ago`;
        if (seconds < 3600) return `${Math.floor(seconds / 60)} minutes ago`;
        if (seconds < 86400) return `${Math.floor(seconds / 3600)} hours ago`;
        return `${Math.floor(seconds / 86400)} days ago`;
    }

    function changeNotificationIcon(hasNewNotif) {
        const notifIcon = document.getElementById("Notifications");
    
        if (notifIcon) {
    
            if (hasNewNotif) {
                notifIcon.src = "../Assets/notification1.svg";
                notifIcon.classList.add("unread");
            } else {
                notifIcon.src = "../Assets/notification.svg";
                notifIcon.classList.remove("unread");
            }
        } else {
            console.error("Notification icon element not found!");
        }
    }

    notifIcon.addEventListener("click", () => {
        changeNotificationIcon(false);
    });

    fetchNotifications();
    setInterval(fetchNotifications, 1000);
    console.log(fetchNotifications);
});
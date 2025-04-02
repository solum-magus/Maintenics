document.addEventListener("DOMContentLoaded", function () {
    let lastPlayedReportId = sessionStorage.getItem("lastPlayedReportId") || null;
    const notifIcon = document.getElementById("Notifications"); // Ensure this is the correct element

    function fetchNotifications() {
        fetch("../Authentication/fetch_notifications.php")
            .then(response => response.json())
            .then(data => {
                console.log("Fetched notification data:", data); // Log fetched data to see what you receive
                if (data.new) {
                    lastPlayedReportId = data.report.report_id; // Update the last played report ID
                    sessionStorage.setItem("lastPlayedReportId", lastPlayedReportId); // Store in session storage
                    changeNotificationIcon(true);
                    playNotificationSound();  // Always play sound for new notification
                    updateNotificationUI(data.report);
                } else {
                    changeNotificationIcon(false); // Reset to default icon if no new notification
                }
            })
    }

    function playNotificationSound() {
        const audio = new Audio("../Assets/newnotif.ogg"); // Make sure this path is correct
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
        // Prevent duplicate notifications
        if (document.querySelector(`[data-id="${report.report_id}"]`)) return;

        const box = document.createElement("div");
        box.className = "box1";
        box.setAttribute("data-id", report.report_id);
        box.innerHTML = `
            <span class="overlayt">A report was submitted!<br>
            Report ID: ${report.report_id}</span>
            <span class="timestamp">${timeAgo(report.date_reported)}</span>
        `;
        notificationContainer.prepend(box); // Add the new notification to the top
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
    
        if (notifIcon) {  // Check if the element exists to avoid errors
            console.log("Changing notification icon...");
    
            if (hasNewNotif) {
                console.log("Setting icon to new notification");
                notifIcon.src = "../Assets/notification1.svg";  // Path for "new notification" icon
                notifIcon.classList.add("unread");  // Add the unread class (if you have styling for this)
            } else {
                console.log("Setting icon to default notification");
                notifIcon.src = "../Assets/notification.svg";  // Path for default notification icon
                notifIcon.classList.remove("unread");  // Remove unread class
            }
        } else {
            console.error("Notification icon element not found!");
        }
    }

    // Reset icon when clicking on the notification icon
    notifIcon.addEventListener("click", () => {
        changeNotificationIcon(false); // Reset the icon when clicked
    });

    // Start fetching notifications immediately
    fetchNotifications();
    setInterval(fetchNotifications, 5000); // Fetch notifications every 5 seconds
    console.log(fetchNotifications);
});
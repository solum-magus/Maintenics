document.addEventListener("DOMContentLoaded", function() {
    function updateStatus(status) {
        const statusText = document.getElementById('status-text');
        if (statusText) {
            statusText.innerText = `Status: ${status}`;

            if (status === 'Pending') {
                statusText.style.color = 'gray';
            } else if (status === 'Resolved') {
                statusText.style.color = 'green';
            } else if (status === 'Ongoing') {
                statusText.style.color = 'orange';
            } else if (status === 'Rejected') {
                statusText.style.color = 'red';
            }
        } else {
            console.log('status-text element not found!');
        }
    }

    const currentPath = window.location.pathname;
    console.log('Current Path:', currentPath);

    const homeIcon = document.getElementById("Home");
    const historyIcon = document.getElementById("History");
    const notifIcon = document.getElementById("Notifications");
    const settingsIcon = document.getElementById("Settings");

    console.log('homeIcon:', homeIcon);
    console.log('historyIcon:', historyIcon);
    console.log('notifIcon:', notifIcon);
    console.log('settingsIcon:', settingsIcon);

    function removeActiveClass() {
        if (homeIcon) homeIcon.classList.remove("active");
        if (historyIcon) historyIcon.classList.remove("active");
        if (notifIcon) notifIcon.classList.remove("active");
        if (settingsIcon) settingsIcon.classList.remove("active");
    }

    function highlightIcon() {
        removeActiveClass();

        if (currentPath.includes("home")) {
            if (homeIcon) homeIcon.classList.add("active");
        } else if (currentPath.includes("history")) {
            if (historyIcon) historyIcon.classList.add("active");
        } else if (currentPath.includes("notif")) {
            if (notifIcon) notifIcon.classList.add("active");
        } else if (currentPath.includes("settings")) {
            if (settingsIcon) settingsIcon.classList.add("active");
        }
    }

    highlightIcon();s
});

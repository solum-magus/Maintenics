document.addEventListener("DOMContentLoaded", function() {
    // Function to set the status text color based on maintenance status
    function updateStatus(status) {
        const statusText = document.getElementById('status-text');
        if (statusText) {
            statusText.innerText = `Status: ${status}`;

            // Change color based on the status
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

    // Automatically set the status to 'Resolved' for testing
    updateStatus('Resolved');

    // Get the current URL path
    const currentPath = window.location.pathname;
    console.log('Current Path:', currentPath); // Log the current path

    // Get all icons by their IDs
    const homeIcon = document.getElementById("Home");
    const historyIcon = document.getElementById("History");
    const notifIcon = document.getElementById("Notifications");
    const settingsIcon = document.getElementById("Settings");

    // Check if icons are found
    console.log('homeIcon:', homeIcon);
    console.log('historyIcon:', historyIcon);
    console.log('notifIcon:', notifIcon);
    console.log('settingsIcon:', settingsIcon);

    // Function to remove the 'active' class from all icons
    function removeActiveClass() {
        if (homeIcon) homeIcon.classList.remove("active");
        if (historyIcon) historyIcon.classList.remove("active");
        if (notifIcon) notifIcon.classList.remove("active");
        if (settingsIcon) settingsIcon.classList.remove("active");
    }

    // Function to add 'active' class to the appropriate icon
    function highlightIcon() {
        removeActiveClass(); // Remove active class from all icons

        // Check the current URL path and add 'active' to the corresponding icon
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

    highlightIcon(); // Run the function when the page loads
});

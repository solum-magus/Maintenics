document.addEventListener("DOMContentLoaded", function() {
    // Get the Dots icon and sidebar
    const dotsIcon = document.getElementById("Dots");
    const sidebar = document.getElementById("sidebar");
    const content = document.querySelector(".content");

    // Function to toggle sidebar visibility
    function toggleSidebar() {
        sidebar.classList.toggle("active");
        content.classList.toggle("active");
    }

    // Add event listener to the Dots icon to toggle the sidebar
    dotsIcon.addEventListener("click", toggleSidebar);

    // Other icon functionality remains the same as your previous script
    const currentPath = window.location.pathname;
    const homeIcon = document.getElementById("Home");
    const historyIcon = document.getElementById("History");
    const notifIcon = document.getElementById("Notifications");
    const settingsIcon = document.getElementById("Settings");

    function removeActiveClass() {
        homeIcon.classList.remove("active");
        historyIcon.classList.remove("active");
        notifIcon.classList.remove("active");
        settingsIcon.classList.remove("active");
    }

    function highlightIcon() {
        removeActiveClass();
        if (currentPath.includes("home")) {
            homeIcon.classList.add("active");
        } else if (currentPath.includes("history")) {
            historyIcon.classList.add("active");
        } else if (currentPath.includes("notif")) {
            notifIcon.classList.add("active");
        } else if (currentPath.includes("settings")) {
            settingsIcon.classList.add("active");
        }
    }

    highlightIcon(); 
});

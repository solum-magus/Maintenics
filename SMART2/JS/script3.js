document.addEventListener("DOMContentLoaded", function() {
    // Get the current URL path
    const currentPath = window.location.pathname;

    // Get all icons by their IDs
    const homeIcon = document.getElementById("Home");
    const historyIcon = document.getElementById("History");
    const notifIcon = document.getElementById("Notifications");
    const settingsIcon = document.getElementById("Settings");

    // Function to remove the 'active' class from all icons
    function removeActiveClass() {
        homeIcon.classList.remove("active");
        historyIcon.classList.remove("active");
        notifIcon.classList.remove("active");
        settingsIcon.classList.remove("active");
    }

    // Function to add 'active' class to the appropriate icon
    function highlightIcon() {
        removeActiveClass(); // Remove active class from all icons

        // Check the current URL path and add 'active' to the corresponding icon
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

    highlightIcon(); // Run the function when the page loads
});
// Get the modal and button elements
const modal = document.getElementById("privacyModal");
const privacyBtn = document.getElementById("privacyPolicyBtn");
const closeBtn = modal.querySelector(".close");

// Open modal when clicking "Privacy & Policy"
privacyBtn.addEventListener("click", () => {
    modal.style.display = "flex";
});

// Close modal when clicking "X"
closeBtn.addEventListener("click", () => {
    modal.style.display = "none";
});

// Close modal when clicking outside of it
window.addEventListener("click", (e) => {
    if (e.target === modal) {
        modal.style.display = "none";
    }
});

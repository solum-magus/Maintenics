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

document.addEventListener("DOMContentLoaded", function () {
    const darkModeToggle = document.getElementById("darkModeToggle");
    const body = document.body;

    // 🔹 Fetch Dark Mode Setting from DB on Page Load
    fetch("../Authentication/darkmode/update-darkmode.php", { method: "GET" })
        .then(response => response.json())
        .then(data => {
            console.log("Fetched dark mode setting:", data);
            if (data.darkMode === 1) {
                body.classList.add("dark-mode");
                darkModeToggle.checked = true;
            } else {
                body.classList.remove("dark-mode");
                darkModeToggle.checked = false;
            }
        })
        .catch(error => console.error("Error fetching dark mode setting:", error));

    // 🔹 Toggle Dark Mode and Save to DB
    darkModeToggle.addEventListener("change", function () {
        let darkMode = darkModeToggle.checked ? "1" : "0";

        console.log("Sending update: darkMode =", darkMode);

        fetch("../Authentication/darkmode/update-darkmode.php", {
            method: "POST",
            headers: { "Content-Type": "application/x-www-form-urlencoded" },
            body: "darkMode=" + encodeURIComponent(darkMode)
        })
        .then(response => response.text())
        .then(data => {
            console.log("Server Response:", data);
            if (data.trim() === "success") {
                body.classList.toggle("dark-mode", darkModeToggle.checked);
            } else {
                console.error("Update failed:", data);
            }
        })
        .catch(error => console.error("Error updating dark mode:", error));
    });
});

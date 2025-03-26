document.addEventListener("DOMContentLoaded", function() {
    // Get the Dots icon and sidebar
    const dotsIcon = document.getElementById("Dots");
    const sidebar = document.getElementById("sidebar");
    // Create a close button inside the sidebar
    const closeDots = document.createElement("img");
    closeDots.src = "../Assets/dots.svg";
    closeDots.classList.add("logo");
    closeDots.id = "CloseDots";
    sidebar.insertBefore(closeDots, sidebar.firstChild);

    // Function to toggle sidebar visibility
    function toggleSidebar() {
        sidebar.classList.toggle("active");
        content.classList.toggle("active");
    }
    // Add event listener to the Dots icon to toggle the sidebar
    dotsIcon.addEventListener("click", toggleSidebar);
    closeDots.addEventListener("click", toggleSidebar);
    // Add event listener to the Dots icon to toggle the sidebar
    dotsIcon.addEventListener("click", toggleSidebar);

    // Check localStorage for sidebar state
    if (localStorage.getItem("sidebarState") === "open") {
        sidebar.classList.add("active");
    }

    // Function to toggle sidebar visibility
    function toggleSidebar() {
        sidebar.classList.toggle("active");

        // Save sidebar state to localStorage
        if (sidebar.classList.contains("active")) {
            localStorage.setItem("sidebarState", "open");
        } else {
            localStorage.setItem("sidebarState", "closed");
        }
    }

    dotsIcon.addEventListener("click", toggleSidebar);

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

function handleProfileChange(value) {
    if (value === "settings") {
        window.location.href = "Settings.php"; // Redirect to settings page
    } else if (value === "logout") {
        window.location.href = "../Authentication/signout.php"; // Redirect to signout script
    }
}

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


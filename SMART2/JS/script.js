document.addEventListener("DOMContentLoaded", function () {
    const modal = document.getElementById("successModal");
    const closeModal = document.getElementById("closeModal");
    const form = document.getElementById("reportForm");

    // Function to show the modal
    function showModal() {
        modal.style.display = "flex"; // Use flexbox to center the modal
    }

    // Function to hide the modal
    function hideModal() {
        modal.style.display = "none";
    }

    // Form submit event listener
    form.addEventListener("submit", function (event) {
        event.preventDefault(); // Prevent the default form submission (refreshing page)

        // Check if the required fields (location and problem) are filled out
        const location = document.getElementById("location");
        const problem = document.getElementById("problem");

        if (location.value && problem.value) {
            // If both fields are filled, show the modal
            showModal();
            form.reset(); // Optionally reset the form after submission
        } else {
            alert("Please fill out all required fields.");
        }
    });

    // Close the modal when the close button is clicked
    closeModal.addEventListener("click", hideModal);

    // Ensure the modal is hidden when the page loads (start in a hidden state)
    modal.style.display = "none";
});

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


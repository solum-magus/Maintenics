document.addEventListener("DOMContentLoaded", function () {
    // Modal Elements
    const modal = document.getElementById("successModal");
    const closeModal = document.getElementById("closeModal");
    const form = document.getElementById("reportForm");

    // Ensure modal elements exist before using them
    if (modal && closeModal && form) {
        // Show Modal Function
        function showModal() {
            modal.style.display = "flex"; // Show modal
        }

        // Hide Modal Function
        function hideModal() {
            modal.style.display = "none";
        }

        // Form Submit Event
        form.addEventListener("submit", function (event) {
            event.preventDefault(); // Prevent page refresh

            const plocation = document.getElementById("plocation");
            const problem = document.getElementById("problem");

            if (plocation?.value && problem?.value) {
                showModal();
                form.reset(); // Reset form after submission
            } else {
                alert("Please fill out all required fields.");
            }
        });

        // Close Modal Button
        closeModal.addEventListener("click", hideModal);

        // Start with modal hidden
        modal.style.display = "none";
    }

    // Highlight Active Icon in Sidebar
    const currentPath = window.location.pathname.toLowerCase();

    const icons = {
        home: document.getElementById("Home"),
        history: document.getElementById("History"),
        notif: document.getElementById("Notifications"),
        settings: document.getElementById("Settings"),
    };

    // Remove 'active' class from all icons
    function removeActiveClass() {
        Object.values(icons).forEach(icon => icon?.classList.remove("active"));
    }

    // Highlight the correct icon
    function highlightIcon() {
        removeActiveClass();
        if (currentPath.includes("home")) icons.home?.classList.add("active");
        else if (currentPath.includes("history")) icons.history?.classList.add("active");
        else if (currentPath.includes("notif")) icons.notif?.classList.add("active");
        else if (currentPath.includes("settings")) icons.settings?.classList.add("active");
    }

    highlightIcon(); // Run when page loads

    // Ensure report form exists before adding event listener
    if (form) {
        form.addEventListener("submit", function (event) {
            event.preventDefault();
            console.log("Form submitted!");
        });
    } else {
        console.error("reportForm not found in DOM!");
    }
});

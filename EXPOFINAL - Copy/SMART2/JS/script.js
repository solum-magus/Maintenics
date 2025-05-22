document.addEventListener("DOMContentLoaded", function () {
    const modal = document.getElementById("successModal");
    const closeModal = document.getElementById("closeModal");
    const form = document.getElementById("reportForm");

    function showModal() {
        modal.style.display = "flex";
    }

    function hideModal() {
        modal.style.display = "none";
    }

    form.addEventListener("submit", function (event) {
        event.preventDefault();

        const plocation = document.getElementById("plocation");
        const problem = document.getElementById("problem");

        if (plocation.value && problem.value) {
            showModal();
            form.reset();
        } else {
            alert("Please fill out all required fields.");
        }
    });

    closeModal.addEventListener("click", hideModal);

    modal.style.display = "none";
});

	document.addEventListener("DOMContentLoaded", function() {

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



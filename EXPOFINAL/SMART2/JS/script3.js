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

function setupModal(buttonId, modalId) {

setTimeout(() => {
    const modal = document.getElementById(modalId);
    const button = document.getElementById(buttonId);
    const closeBtn = modal.querySelector(".close");

    if (!modal || !button || !closeBtn) return;

    button.addEventListener("click", () => {
        modal.style.display = "flex";
    });

    closeBtn.addEventListener("click", () => {
        modal.style.display = "none";
    });

    window.addEventListener("click", (e) => {
        if (e.target === modal) {
            modal.style.display = "none";
        }
    });
}, 100);
}

setupModal("privacyPolicyBtn", "privacyModal");
setupModal("contactUsBtn", "contactModal");
setupModal("changePasswordBtn", "passwordModal");
setupModal("manageUserBtn", "manageModal");
setupModal("viewReportBtn", "reportModal");
setupModal("setReportBtn", "setupModal");

var a = 0;
function showpass() {
    if (a == 1) {
        document.getElementById('new_password').type = 'password';
        document.getElementById('pass-icon').src='../Assets/eye-alt.svg';
        a = 0;
    } else {
        document.getElementById('new_password').type = 'text';
        document.getElementById('pass-icon').src='../Assets/eye.svg';
        a = 1;
    }
}
var b = 0;
function showpass2() {
    if (b == 1) {
        document.getElementById('confirm_password').type = 'password';
        document.getElementById('pass-icon2').src='../Assets/eye-alt.svg';
        b = 0;
    } else {
        document.getElementById('confirm_password').type = 'text';
        document.getElementById('pass-icon2').src='../Assets/eye.svg';
        b = 1;
    }
}
var c = 0;
function showpass3() {
    if (c == 1) {
        document.getElementById('current_password').type = 'password';
        document.getElementById('pass-icon3').src='../Assets/eye-alt.svg';
        c = 0;
    } else {
        document.getElementById('current_password').type = 'text';
        document.getElementById('pass-icon3').src='../Assets/eye.svg';
        c = 1;
    }
}

function toggleVisibility(id) {
    let element = document.getElementById(id);
    element.style.display = (element.style.display === "none" || element.style.display === "") ? "block" : "none";
}

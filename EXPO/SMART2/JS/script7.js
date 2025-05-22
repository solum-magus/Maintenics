document.addEventListener('DOMContentLoaded', function () {
    const logos = document.querySelectorAll('.logo-link');

    const currentPage = window.location.pathname.split('/').pop(); // e.g., 'MaintenanceSettings.php'

    let matched = false;

    logos.forEach(function (logoLink) {
        const logo = logoLink.querySelector('.logo');
        const href = logoLink.getAttribute('href');

        if (href && href.includes(currentPage)) {
            logo.classList.add('active');
            localStorage.setItem('activeTab', logo.id);
            matched = true;
        }
    });

    // Fallback if no match found
    if (!matched) {
        const defaultLogo = document.querySelector('#Home');
        if (defaultLogo) {
            defaultLogo.classList.add('active');
            localStorage.setItem('activeTab', 'Home');
        }
    }

    // Handle clicks
    logos.forEach(function (logoLink) {
        logoLink.addEventListener('click', function () {
            logos.forEach(function (link) {
                link.querySelector('.logo').classList.remove('active');
            });

            this.querySelector('.logo').classList.add('active');
            const clickedTabId = this.querySelector('.logo').id;
            localStorage.setItem('activeTab', clickedTabId);
        });
    });
});

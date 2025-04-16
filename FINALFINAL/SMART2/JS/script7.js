document.addEventListener('DOMContentLoaded', function () {
    const logos = document.querySelectorAll('.logo-link');  // Select all logo links

    // Check if there's a saved active tab in localStorage
    const activeTab = localStorage.getItem('activeTab');

    // If there is a saved active tab, apply the 'active' class
    if (activeTab) {
        const activeLogo = document.querySelector(`#${activeTab}`);
        if (activeLogo) {
            activeLogo.classList.add('active');
        }
    } else {
        // If no saved active tab, detect based on the current page URL
        const currentPath = window.location.pathname.split('/').pop(); // e.g., "MaintenanceHome.php"
        
        logos.forEach(function (logoLink) {
            const href = logoLink.getAttribute('href').split('/').pop(); // Get the filename part of href
            if (href === currentPath) {
                const logo = logoLink.querySelector('.logo');
                logo.classList.add('active');
                localStorage.setItem('activeTab', logo.id); // Save the active tab
            }
        });
    }

    // Add event listeners to logos to update active class on click
    logos.forEach(function (logoLink) {
        logoLink.addEventListener('click', function () {
            // Remove the active class from all logo links
            logos.forEach(function (link) {
                link.querySelector('.logo').classList.remove('active');
            });

            // Add the active class to the clicked logo (not the link)
            this.querySelector('.logo').classList.add('active');

            // Save the active tab to localStorage
            const clickedTabId = this.querySelector('.logo').id;
            localStorage.setItem('activeTab', clickedTabId);
        });
    });
});

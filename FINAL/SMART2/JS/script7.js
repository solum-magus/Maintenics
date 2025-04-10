document.addEventListener('DOMContentLoaded', function () {
    const logos = document.querySelectorAll('.logo-link');  // Select all logo links

    // Check if there's a saved active tab in localStorage
    const activeTab = localStorage.getItem('activeTab');

    // Apply the active class to the saved tab if it exists and matches the current page
    if (activeTab) {
        const activeLogo = document.querySelector(`#${activeTab}`);
        if (activeLogo) {
            activeLogo.classList.add('active', 'HomeLink');
        }
    }

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

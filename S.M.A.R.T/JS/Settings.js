document.addEventListener("DOMContentLoaded", function () {
    navigateTo("mainPage");
});

function navigateTo(pageId) {
    document.querySelectorAll('.page').forEach(page => {
        page.style.display = 'none';
    });
    const targetPage = document.getElementById(pageId);
    if (targetPage) {
        targetPage.style.display = 'block';
    }
}
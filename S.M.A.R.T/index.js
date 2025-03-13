/*document.addEventListener("DOMContentLoaded", function () {
    navigateTo("mainPage");
});*/

document.addEventListener("DOMContentLoaded", function () {
    navigateTo("welcomePage");
});

function navigateTo(pageId) {
    document.querySelectorAll('.page').forEach(page => {
        page.style.display = 'none';
    });
    document.getElementById(pageId).style.display = 'block';
}

/**function navigateTo(pageId) {
    document.querySelectorAll('.page').forEach(page => {
        page.style.display = 'none';
    });
    const targetPage = document.getElementById(pageId);
    if (targetPage) {
        targetPage.style.display = 'block';
    }
}*/

var a = 0;
function showpass() {
    if (a == 1) {
        document.getElementById('password').type = 'password';
        document.getElementById('pass-icon').src='Assets/eye-alt.svg';
        a = 0;
    } else {
        document.getElementById('password').type = 'text';
        document.getElementById('pass-icon').src='Assets/eye.svg';
        a = 1;
    }
}
var b = 0;
function showpass2() {
    if (b == 1) {
        document.getElementById('confirm_password').type = 'password';
        document.getElementById('pass-icon2').src='Assets/eye-alt.svg';
        b = 0;
    } else {
        document.getElementById('confirm_password').type = 'text';
        document.getElementById('pass-icon2').src='Assets/eye.svg';
        b = 1;
    }
}
var c = 0;
function showpass3() {
    if (c == 1) {
        document.getElementById('signin_password').type = 'password';
        document.getElementById('pass-icon3').src='Assets/eye-alt.svg';
        c = 0;
    } else {
        document.getElementById('signin_password').type = 'text';
        document.getElementById('pass-icon3').src='Assets/eye.svg';
        c = 1;
    }
}

function toggleVisibility(id) {
    let element = document.getElementById(id);
    element.style.display = (element.style.display === "none" || element.style.display === "") ? "block" : "none";
}

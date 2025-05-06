document.addEventListener("DOMContentLoaded", function () {
    const successModal = document.getElementById("successModal");
    const successAnimation = document.getElementById("successAnimation");
    const closeModal = document.getElementById("closeModal");

    function showSuccessModal() {
        successModal.style.display = "flex";
        successAnimation.stop();
        successAnimation.play();
    }

    closeModal.addEventListener("click", function () {
        successModal.style.display = "none";
        successAnimation.stop();
    });

    setTimeout(() => {
        successModal.style.display = "none";
        successAnimation.stop();
    }, 5000);

    const reportForm = document.getElementById("reportForm");
    reportForm.addEventListener("submit", function (event) {
        event.preventDefault();
        let formData = new FormData(reportForm);
        fetch("../Authentication/makereport.php", {
            method: "POST",
            body: formData
        })
        .then(response => response.text())
        .then(data => {
            console.log("Submit Response:", data);
            reportForm.reset();
            showSuccessModal();
        });
    });
});
function customAlert(message) {
    const popup = document.getElementById('popup');
    document.getElementById('popup-message').innerText = message;
    popup.style.display = 'block';

    setTimeout(() => {
      popup.style.display = 'none';
    }, 3000);
  }
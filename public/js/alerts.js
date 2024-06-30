// public/js/alerts.js
document.addEventListener("DOMContentLoaded", function() {
    console.log("alerts.js is loaded"); // Tambahkan log untuk memastikan bahwa skrip dijalankan
    setTimeout(function() {
        let successAlert = document.getElementById('success-alert');
        if (successAlert) {
            successAlert.style.transition = 'opacity 0.5s';
            successAlert.style.opacity = '0';
            setTimeout(function() {
                successAlert.remove();
            }, 500);
        }

        let errorAlert = document.getElementById('error-alert');
        if (errorAlert) {
            errorAlert.style.transition = 'opacity 0.5s';
            errorAlert.style.opacity = '0';
            setTimeout(function() {
                errorAlert.remove();
            }, 500);
        }
    }, 2000);
});

document.addEventListener('DOMContentLoaded', () => {
    const successAlert = document.getElementById('success-alert');
    const errorAlert = document.getElementById('error-alert');

    if (successAlert) {
        setTimeout(() => {
            successAlert.style.display = 'none';
        }, 3000); // Sembunyikan setelah 3 detik
    }

    if (errorAlert) {
        setTimeout(() => {
            errorAlert.style.display = 'none';
        }, 5000); // Sembunyikan setelah 5 detik
    }
});

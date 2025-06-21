document.addEventListener('DOMContentLoaded', function() {
    const form = document.querySelector('.password-reset-form');
    const emailInput = document.getElementById('correo_electronico');
    const btn = document.querySelector('.password-reset-btn');
    if (form && btn && emailInput) {
        btn.addEventListener('mousedown', function() {
            btn.style.transform = 'scale(0.97)';
        });
        btn.addEventListener('mouseup', function() {
            btn.style.transform = '';
        });
        btn.addEventListener('mouseleave', function() {
            btn.style.transform = '';
        });
        emailInput.addEventListener('focus', function() {
            emailInput.style.boxShadow = '0 0 0 2px #43e97b44';
        });
        emailInput.addEventListener('blur', function() {
            emailInput.style.boxShadow = '';
        });
    }
    // Si hay mensaje de éxito, limpiar el campo
    const success = document.querySelector('.password-reset-success');
    if (success && emailInput) {
        setTimeout(() => {
            emailInput.value = '';
        }, 1500);
    }
}); 
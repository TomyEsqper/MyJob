(() => {
    const patterns = {
        uppercase: /[A-Z]/,
        lowercase: /[a-z]/,
        number:    /\d/,
        special:   /[!@#$%^&*(),.?":{}|\/\-_<>]/,
        length:    /.{8,}/
    };
    document.querySelectorAll('.password-field').forEach(field => {
        const input = field.querySelector('input');
        const rules = field.querySelectorAll('.rule');
        input.addEventListener('focus', () => field.classList.add('focused'));
        input.addEventListener('blur', () => {
            if (!input.value) field.classList.remove('focused');
        });
        input.addEventListener('input', () => {
            rules.forEach(r => {
                const rule = r.dataset.rule;
                r.classList.toggle('valid', patterns[rule].test(input.value));
            });
        });
        // Mostrar/ocultar contraseña
        const toggleBtn = field.querySelector('.toggle-password');
        if (toggleBtn) {
            toggleBtn.addEventListener('click', () => {
                input.type = input.type === 'password' ? 'text' : 'password';
                toggleBtn.textContent = input.type === 'password' ? 'Mostrar' : 'Ocultar';
            });
        }
    });
})(); 
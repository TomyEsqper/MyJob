const csrfToken = document.querySelector('meta[name="csrf-token"]').getAttribute('content');
const loginUrl  = document.querySelector('meta[name="login-url"]').getAttribute('content');
document.addEventListener('DOMContentLoaded', function () {
    const btnEmpresa = document.getElementById('btn-empresa');
    const btnUsuario = document.getElementById('btn-usuario');
    const inputsEmpresa = document.getElementById('inputs-empresa');
    const inputsUsuario = document.getElementById('inputs-usuario');
    const rolField = document.getElementById('rol');
    // Sincronizar correo_empresarial con email oculto
    const correoEmpresarial = document.getElementById('correo_empresarial');
    const emailEmpresa = document.getElementById('email_empresa');

    // Por defecto, deshabilitar inputs de empresa
    inputsEmpresa.querySelectorAll('input').forEach(input => input.disabled = true);

    function toggleSection(showEl, hideEl, showBtn, hideBtn, rolValue) {
        showEl.style.display = 'block';
        hideEl.style.display = 'none';
        showBtn.classList.add('activo');
        hideBtn.classList.remove('activo');
        rolField.value = rolValue;

        // Habilitar inputs visibles y deshabilitar ocultos
        showEl.querySelectorAll('input').forEach(input => input.disabled = false);
        hideEl.querySelectorAll('input').forEach(input => input.disabled = true);
    }

    btnEmpresa.addEventListener('click', () => {
        toggleSection(inputsEmpresa, inputsUsuario, btnEmpresa, btnUsuario, 'empleador');
    });

    btnUsuario.addEventListener('click', () => {
        toggleSection(inputsUsuario, inputsEmpresa, btnUsuario, btnEmpresa, 'empleado');
    });

    // Sincronizar el campo oculto email con correo_empresarial
    if (correoEmpresarial && emailEmpresa) {
        correoEmpresarial.addEventListener('input', function () {
            emailEmpresa.value = correoEmpresarial.value;
        });
    }
});

    (() => {
    const patterns = {
    uppercase: /[A-Z]/,
    lowercase: /[a-z]/,
    number:    /\d/,
    special: /[!@#$%^&*(),.?\":{}|\/\-_<>]/,
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
        });
    })();

    document.addEventListener('DOMContentLoaded', () => {
    document.querySelectorAll('.toggle-password').forEach(btn => {
        btn.addEventListener('click', () => {
            const input = document.getElementById(btn.dataset.target);
            const isPwd = input.type === 'password';
            input.type = isPwd ? 'text' : 'password';
            btn.textContent = isPwd ? 'Ocultar' : 'Mostrar';
        });
    });
});

    const form = document.getElementById('formulario-registro');
    const btnRegistro = document.getElementById('btn-registro');
    const btnText = document.getElementById('btn-text');
    const btnIcon = document.getElementById('btn-icon');

    form.addEventListener('submit', async function (e) {
    e.preventDefault();

    // Mostrar estado de carga: deshabilitar botón y ocultar icono
    btnRegistro.disabled = true;
    btnText.textContent = 'Registrando...';
    btnIcon.style.display = 'none';

    const formData = new FormData(this);

    try {
        const response = await fetch(this.action, {
            method: 'POST',
            headers: {
                'X-CSRF-TOKEN': csrfToken,
                'Accept': 'application/json'
},
    body: formData
});

    const data = await response.json();

    if (!response.ok) {
    Swal.fire({
    icon: 'error',
    title: 'Registro Fallido',
    html: `<p>${data.error}</p><p>Por favor verifica los datos e intenta nuevamente.</p>`,
    confirmButtonText: 'Cerrar'
});
} else {
    Swal.fire({
    icon: 'success',
    title: '¡Registrado!',
    text: data.message,
    confirmButtonColor: '#007bff',  // Color del botón de confirmación
    timer: 2000,
    showConfirmButton: false
}).then(() => {
        window.location.href = loginUrl;
});

}
} catch (error) {
    console.error(error);
    Swal.fire({ icon: 'error', title: 'Error', text: 'No se pudo procesar la solicitud.' });
} finally {
    btnRegistro.disabled = false;
    btnText.textContent = 'Registrarme';
    btnIcon.style.display = '';
}
});

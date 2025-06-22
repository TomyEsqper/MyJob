document.addEventListener('DOMContentLoaded', function () {
    console.log('DOM loaded, initializing registration form...');
    
    // Get meta tags
    const csrfTokenMeta = document.querySelector('meta[name="csrf-token"]');
    const loginUrlMeta = document.querySelector('meta[name="login-url"]');
    const googleRedirectMeta = document.querySelector('meta[name="google-redirect-url"]');
    
    const csrfToken = csrfTokenMeta ? csrfTokenMeta.getAttribute('content') : '';
    const loginUrl = loginUrlMeta ? loginUrlMeta.getAttribute('content') : '/login';
    const googleBaseUrl = googleRedirectMeta ? googleRedirectMeta.getAttribute('content') : '/auth/google/redirect';
    
    console.log('Meta tags loaded:', { csrfToken: !!csrfToken, loginUrl, googleBaseUrl });

    // Initialize tooltips if Bootstrap is available
    if (typeof bootstrap !== 'undefined') {
        const tooltipTriggerList = [].slice.call(document.querySelectorAll('[data-bs-toggle="tooltip"]'));
        tooltipTriggerList.map(function (tooltipTriggerEl) {
            return new bootstrap.Tooltip(tooltipTriggerEl);
        });
    }

    // Get DOM elements
    const btnEmpresa = document.getElementById('btn-empresa');
    const btnUsuario = document.getElementById('btn-usuario');
    const inputsEmpresa = document.getElementById('inputs-empresa');
    const inputsUsuario = document.getElementById('inputs-usuario');
    const rolField = document.getElementById('rol');
    const correoEmpresarial = document.getElementById('correo_empresarial');
    const emailEmpresa = document.getElementById('email_empresa');
    const btnGoogle = document.getElementById('btn-google');
    
    console.log('DOM elements found:', {
        btnEmpresa: !!btnEmpresa,
        btnUsuario: !!btnUsuario,
        inputsEmpresa: !!inputsEmpresa,
        inputsUsuario: !!inputsUsuario,
        rolField: !!rolField,
        btnGoogle: !!btnGoogle
    });

    // Function to update Google button href
    function updateGoogleHref(rol) {
        if (btnGoogle && googleBaseUrl) {
            const newHref = `${googleBaseUrl}?rol=${encodeURIComponent(rol)}`;
            btnGoogle.setAttribute('href', newHref);
            console.log('Updated Google href to:', newHref);
        }
    }

    // Initialize Google href with current role
    if (rolField) {
        console.log('Initializing Google href with role:', rolField.value);
        updateGoogleHref(rolField.value);
    }

    // Disable empresa inputs initially
    if (inputsEmpresa) {
        inputsEmpresa.querySelectorAll('input').forEach(input => {
            input.disabled = true;
            input.removeAttribute('required');
        });
        console.log('Disabled empresa inputs initially');
    }

    // Function to toggle between empresa and usuario sections
    function toggleSection(showEl, hideEl, showBtn, hideBtn, rolValue) {
        console.log('Toggling section to:', rolValue);
        
        if (showEl && hideEl && showBtn && hideBtn && rolField) {
            // Show/hide sections
            showEl.style.display = 'block';
            hideEl.style.display = 'none';
            
            // Update button states
            showBtn.classList.add('activo');
            hideBtn.classList.remove('activo');
            
            // Update role field
            rolField.value = rolValue;
            
            // Enable/disable inputs
            showEl.querySelectorAll('input').forEach(input => {
                input.disabled = false;
                if (input.hasAttribute('data-required')) {
                    input.setAttribute('required', 'required');
                }
            });
            
            hideEl.querySelectorAll('input').forEach(input => {
                input.disabled = true;
                input.removeAttribute('required');
            });
            
            // Update Google href
            updateGoogleHref(rolValue);
            
            console.log('Section toggle completed for:', rolValue);
        } else {
            console.error('Cannot toggle section:', { showEl: !!showEl, hideEl: !!hideEl, showBtn: !!showBtn, hideBtn: !!hideBtn, rolField: !!rolField });
        }
    }

    // Add event listeners for empresa/usuario buttons
    if (btnEmpresa && btnUsuario) {
        btnEmpresa.addEventListener('click', function(e) {
            e.preventDefault();
            console.log('Empresa button clicked');
            toggleSection(inputsEmpresa, inputsUsuario, btnEmpresa, btnUsuario, 'empleador');
        });

        btnUsuario.addEventListener('click', function(e) {
            e.preventDefault();
            console.log('Usuario button clicked');
            toggleSection(inputsUsuario, inputsEmpresa, btnUsuario, btnEmpresa, 'empleado');
        });
        
        console.log('Event listeners added for empresa/usuario buttons');
    } else {
        console.error('Empresa/Usuario buttons not found');
    }

    // Sync empresa email fields
    if (correoEmpresarial && emailEmpresa) {
        correoEmpresarial.addEventListener('input', function () {
            emailEmpresa.value = correoEmpresarial.value;
        });
        console.log('Email sync handler added');
    }

    // Password validation rules
    const patterns = {
        uppercase: /[A-Z]/,
        lowercase: /[a-z]/,
        number: /\d/,
        special: /[!@#$%^&*(),.?":{}|\\/\-_<>]/,
        length: /.{8,}/
    };

    // Initialize password validation
    document.querySelectorAll('.password-field').forEach(field => {
        const input = field.querySelector('input');
        const rules = field.querySelectorAll('.rule');
        
        if (input && rules.length > 0) {
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
        }
    });

    // Toggle password visibility
    document.querySelectorAll('.toggle-password').forEach(btn => {
        btn.addEventListener('click', () => {
            const input = document.getElementById(btn.dataset.target);
            if (input) {
                const isPwd = input.type === 'password';
                input.type = isPwd ? 'text' : 'password';
                btn.textContent = isPwd ? 'Ocultar' : 'Mostrar';
            }
        });
    });

    // Form submission
    const form = document.getElementById('formulario-registro');
    const btnRegistro = document.getElementById('btn-registro');
    const btnText = document.getElementById('btn-text');
    const btnIcon = document.getElementById('btn-icon');

    if (form) {
        form.addEventListener('submit', async function (e) {
            e.preventDefault();
            console.log('Form submitted');

            if (btnRegistro) btnRegistro.disabled = true;
            if (btnText) btnText.textContent = 'Registrando...';
            if (btnIcon) btnIcon.style.display = 'none';

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
                    if (typeof Swal !== 'undefined') {
                        Swal.fire({
                            icon: 'error',
                            title: 'Registro Fallido',
                            html: `<p>${data.error}</p><p>Por favor verifica los datos e intenta nuevamente.</p>`,
                            confirmButtonText: 'Cerrar'
                        });
                    } else {
                        alert('Error: ' + data.error);
                    }
                } else {
                    if (typeof Swal !== 'undefined') {
                        Swal.fire({
                            icon: 'success',
                            title: '¡Registrado!',
                            text: data.message,
                            confirmButtonColor: '#007bff',
                            timer: 2000,
                            showConfirmButton: false
                        }).then(() => {
                            window.location.href = loginUrl;
                        });
                    } else {
                        alert('Registro exitoso: ' + data.message);
                        window.location.href = loginUrl;
                    }
                }
            } catch (error) {
                console.error('Form submission error:', error);
                if (typeof Swal !== 'undefined') {
                    Swal.fire({ icon: 'error', title: 'Error', text: 'No se pudo procesar la solicitud.' });
                } else {
                    alert('Error: No se pudo procesar la solicitud.');
                }
            } finally {
                if (btnRegistro) btnRegistro.disabled = false;
                if (btnText) btnText.textContent = 'Registrarme';
                if (btnIcon) btnIcon.style.display = '';
            }
        });
        
        console.log('Form submission handler added');
    } else {
        console.error('Form not found');
    }
    
    console.log('Registration form initialization complete');
});
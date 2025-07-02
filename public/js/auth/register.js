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
            // Asegurarnos de que el rol se mantenga incluso si el usuario hace clic rápidamente
            btnGoogle.addEventListener('click', function(e) {
                e.preventDefault();
                const currentRol = rolField ? rolField.value : rol;
                window.location.href = `${googleBaseUrl}?rol=${encodeURIComponent(currentRol)}`;
            }, { once: true });
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
            
            // Validar todos los campos visibles
            const visibleInputs = Array.from(this.querySelectorAll('input:not([type="hidden"])'))
                .filter(input => input.offsetParent !== null);
                
            let hasErrors = false;
            
            visibleInputs.forEach(input => {
                if (!input.checkValidity()) {
                    hasErrors = true;
                    input.reportValidity();
                }
            });
            
            if (hasErrors) {
                return;
            }

            if (btnRegistro) btnRegistro.disabled = true;
            if (btnText) btnText.textContent = 'Registrando...';
            if (btnIcon) btnIcon.style.display = 'none';

            try {
                const formData = new FormData(this);
                
                // Sanitizar todos los datos antes de enviar
                for (let pair of formData.entries()) {
                    if (typeof pair[1] === 'string' && pair[0] !== 'password' && pair[0] !== 'password_confirmation') {
                        formData.set(pair[0], sanitizeInput(pair[1]));
                    }
                }

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
                    throw new Error(data.error || data.message || 'Error en el registro');
                }

                // Éxito
                Swal.fire({
                    icon: 'success',
                    title: '¡Registro exitoso!',
                    text: 'Tu cuenta ha sido creada correctamente.',
                    timer: 2000,
                    showConfirmButton: false
                }).then(() => {
                    window.location.href = data.redirect || loginUrl;
                });

            } catch (error) {
                console.error('Error:', error);
                
                if (btnRegistro) btnRegistro.disabled = false;
                if (btnText) btnText.textContent = 'Registrarme';
                if (btnIcon) btnIcon.style.display = 'inline';

                Swal.fire({
                    icon: 'error',
                    title: 'Error en el Registro',
                    text: error.message,
                    confirmButtonText: 'Entendido',
                    confirmButtonColor: '#258d19'
                });
            }
        });
        
        console.log('Form submission handler added');
    } else {
        console.error('Form not found');
    }
    
    console.log('Registration form initialization complete');
});

// Función para sanitizar input
function sanitizeInput(input) {
    if (typeof input !== 'string') return input;
    return input
        .replace(/&/g, '&amp;')
        .replace(/</g, '&lt;')
        .replace(/>/g, '&gt;')
        .replace(/"/g, '&quot;')
        .replace(/'/g, '&#x27;')
        .replace(/\//g, '&#x2F;');
}

// Función para validar email
function isValidEmail(email) {
    const emailRegex = /^[a-zA-Z0-9._%+-]+@[a-zA-Z0-9.-]+\.[a-zA-Z]{2,}$/;
    return emailRegex.test(email);
}

// Función para validar NIT
function isValidNIT(nit) {
    // Eliminar guiones y espacios
    nit = nit.replace(/[-\s]/g, '');
    // Verificar que solo contenga números
    return /^\d{9,14}$/.test(nit);
}

// Función para validar nombre de usuario
function isValidUsername(username) {
    // Letras, números, espacios, guiones y puntos, 3-30 caracteres
    return /^[a-zA-ZáéíóúÁÉÍÓÚñÑ0-9\s.-]{3,30}$/.test(username);
}

// Agregar validaciones a los campos del formulario
document.querySelectorAll('input').forEach(input => {
    input.addEventListener('input', function() {
        // Sanitizar input en tiempo real
        if (this.type !== 'password') {
            this.value = sanitizeInput(this.value);
        }

        // Validaciones específicas por tipo de campo
        switch(this.id) {
            case 'email_usuario':
            case 'correo_empresarial':
                if (!isValidEmail(this.value)) {
                    this.setCustomValidity('Por favor, ingresa un correo electrónico válido.');
                } else {
                    this.setCustomValidity('');
                }
                break;

            case 'nit_empresa':
                if (!isValidNIT(this.value)) {
                    this.setCustomValidity('Por favor, ingresa un NIT válido (9-14 dígitos).');
                } else {
                    this.setCustomValidity('');
                }
                break;

            case 'name_usuario':
            case 'name_empresa':
                if (!isValidUsername(this.value)) {
                    this.setCustomValidity('El nombre debe tener entre 3 y 30 caracteres y solo puede contener letras, números, guiones y puntos.');
                } else {
                    this.setCustomValidity('');
                }
                break;
        }
    });
});
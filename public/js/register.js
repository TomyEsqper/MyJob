document.addEventListener('DOMContentLoaded', () => {
    const btnEmpresa    = document.getElementById('btn-empresa');
    const btnUsuario    = document.getElementById('btn-usuario');
    const inputsEmpresa = document.getElementById('inputs-empresa');
    const inputsUsuario = document.getElementById('inputs-usuario');

    const toggleSection = (showEl, hideEl, showBtn, hideBtn) => {
        showEl.style.display = 'block';
        hideEl.style.display = 'none';
        showBtn.classList.add('activo');
        hideBtn.classList.remove('activo');

        showEl.querySelectorAll('input').forEach(i => i.disabled = false);
        hideEl.querySelectorAll('input').forEach(i => i.disabled = true);
    };

    btnEmpresa.addEventListener('click', () =>
        toggleSection(inputsEmpresa, inputsUsuario, btnEmpresa, btnUsuario)
    );
    btnUsuario.addEventListener('click', () =>
        toggleSection(inputsUsuario, inputsEmpresa, btnUsuario, btnEmpresa)
    );

    // Verificar NIT
    const nitInput     = document.getElementById('nit_empresa');
    const registrarBtn = document.getElementById('btn-registro');

    nitInput.addEventListener('blur', async () => {
        const nit = nitInput.value.trim();
        if (!nit) return;

        registrarBtn.disabled = true;

        try {
            const res = await fetch('/verificar-nit', {
                method: 'POST',
                headers: {
                    'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content'),
                    'Accept': 'application/json',
                    'Content-Type': 'application/json'
                },
                body: JSON.stringify({ nit })
            });
            const data = await res.json();

            if (res.ok && data.valid) {
                document.querySelectorAll('#inputs-empresa input').forEach(i => i.disabled = false);
                Swal.fire('✔️', 'NIT verificado: ' + data.empresa.razon_social, 'success');
            } else {
                Swal.fire('❌', data.message || 'Error al verificar NIT.', 'error');
            }
        } catch (e) {
            Swal.fire('❌', 'No se pudo conectar con la API.', 'error');
        } finally {
            registrarBtn.disabled = false;
        }
    });

    // Enviar formulario
    const form    = document.getElementById('formulario-registro');
    const btnText = document.getElementById('btn-text');
    const btnIcon = document.getElementById('btn-icon');

    form.addEventListener('submit', async (e) => {
        e.preventDefault();

        registrarBtn.disabled = true;
        btnText.textContent   = 'Registrando...';
        btnIcon.style.display = 'none';

        const formData = new FormData(form);

        try {
            const response = await fetch(form.action, {
                method: 'POST',
                headers: { 'Accept': 'application/json' },
                body: formData
            });
            const result = await response.json();

            if (!response.ok) {
                Swal.fire('Oops...', result.error || 'Hubo un error.', 'error');
            } else {
                Swal.fire('¡Registrado!', result.message, 'success');
                setTimeout(() => window.location.href = '{{ route("login") }}', 2000);
            }
        } catch (err) {
            Swal.fire('Error', 'No se pudo procesar la solicitud.', 'error');
        } finally {
            registrarBtn.disabled = false;
            btnText.textContent   = 'Registrarme';
            btnIcon.style.display = '';
        }
    });
});

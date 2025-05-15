import Swal from 'sweetalert2';

const form    = document.querySelector('formulario-registro');
const btn     = document.querySelector('btn-registro');
const btnText = document.querySelector('btn-text');
const btnIcon = document.querySelector('btn-icon');

form.addEventListener('submit', async function (e) {
    e.preventDefault();

    // Mostrar estado de carga
    btnRegistro.disabled = true;
    btnText.textContent  = 'Registrando...';

    const formData = new FormData(this);

    try{
        const response = await fetch(this.action, {
            method: 'POST',
            headers: {
                'X-CSRF-TOKEN': '{{ csrf_token() }}',
            },
            body: formData,
        });

        const data = await response.json();

        if (!response.ok) {

            // Si llega error de validación o API, muestra el error

            Swal.fire({
                icon:   'success',
                title: '¡Registrado!',
                text:    data.message,
                timer:   2000,
                showConfirmButton: false
            }).then(() => {
                // Redirigir a la página de inicio
                window.location.href = '{{ route("login") }}';
            });
        }
    } catch (error) {}
})

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Registro</title>
    <link rel="stylesheet" media="all" href="{{ asset('css/loginRegistro.css') }}">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.4/dist/css/bootstrap.min.css" rel="stylesheet"
          integrity="sha384-DQvkBjpPgn7RC31MCQoOeC9TI2kdqa4+BSgNMNj8v77fdC77Kj5zpWFTJaaAoMbC" crossorigin="anonymous">
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
</head>
<body>
<div class="row">
    <div class="col-md-5 col-12 p-4 bg-light">
        <div class="container-der-login" style="display: flex; flex-direction: column; justify-content: center; align-items: center; text-align: center; margin-bottom:0">
            <h1>Bienvenido a <strong>My<span style="color:#258d19;">Job</span></strong></h1>
            <h6>Regístrate para acceder a las oportunidades laborales.</h6>

            <!-- Botón de inicio de sesión con Google -->
            <div style="display: flex; gap: 10px; margin-top: 5%; margin-bottom: 10%;">
                <a href="{{ route('google.redirect') }}" class="google-btn">
                    <div class="google-icon-wrapper">
                        <img class="google-icon" src="https://developers.google.com/identity/images/g-logo.png" alt="Google logo">
                    </div>
                    <span>Registrarse con Google</span>
                </a>
            </div>
        </div>

        <!-- Selector para cambiar entre Empresa y Usuario -->
        <div class="selector">
            <button id="btn-empresa"><span>Empresa</span></button>
            <button id="btn-usuario" class="activo"><span>Usuario</span></button>
        </div>

        <!-- Formulario de Registro -->
        <div class="container-der-login-formulario mb-4">
            <form id="formulario-registro" method="POST" action="{{ route('register') }}">
                @csrf

                <!-- Campo oculto para el rol -->
                <input type="hidden" id="rol" name="rol" value="empleado">

                <!-- Formulario de Usuario -->
                <div id="inputs-usuario" class="inputs-usuario">
                    <div class="mb-3">
                        <label for="name_usuario" class="form-label">Nombre</label>
                        <input type="text" class="form-control" name="name" id="name_usuario" placeholder="Ingrese su primer nombre" required>
                    </div>
                    <div class="mb-3">
                        <label for="email_usuario" class="form-label">Correo Electrónico</label>
                        <input type="email" class="form-control" id="email_usuario" name="email" placeholder="Ingrese su correo electrónico" required>
                    </div>
                    <div class="mb-3">
                        <label for="password_usuario" class="form-label">Contraseña</label>
                        <input type="password" class="form-control" id="password_usuario" name="password" placeholder="Ingrese su contraseña" required>
                        <input type="password" class="form-control mt-4" id="password_confirmation_usuario" name="password_confirmation" placeholder="Repita su contraseña" required>
                    </div>
                </div>

                <!-- Formulario de Empresa -->
                <div id="inputs-empresa" class="inputs-empresa" style="display: none;">
                    <div class="mb-3">
                        <label for="name_empresa" class="form-label">Nombre de la Empresa</label>
                        <input type="text" class="form-control" name="nombre_empresa" id="name_empresa" placeholder="Ingrese el nombre de la empresa" required>
                    </div>
                    <div class="mb-3">
                        <label for="nit_empresa" class="form-label">NIT</label>
                        <input type="text" class="form-control" name="nit" id="nit_empresa" placeholder="Ingrese su NIT" required>
                    </div>
                    <div class="mb-3">
                        <label for="correo_empresarial" class="form-label">Correo Empresarial</label>
                        <input type="email" class="form-control" id="correo_empresarial" name="correo_empresarial" placeholder="Ingrese el correo empresarial" required>
                        <!-- Campo oculto para email (necesario para el backend) -->
                        <input type="hidden" id="email_empresa" name="email">
                    </div>
                    <div class="mb-3">
                        <label for="direccion_empresa" class="form-label">Dirección de la Empresa</label>
                        <input type="text" class="form-control" id="direccion_empresa" name="direccion_empresa" placeholder="Ingrese la dirección de la empresa" required>
                    </div>
                    <div class="mb-3">
                        <label for="telefono_contacto" class="form-label">Teléfono de Contacto</label>
                        <input type="text" class="form-control" id="telefono_contacto" name="telefono_contacto" placeholder="Ingrese el teléfono de contacto" required>
                    </div>
                    <div class="mb-3">
                        <label for="password_empresa" class="form-label">Contraseña</label>
                        <input type="password" class="form-control" id="password_empresa" name="password" placeholder="Ingrese su contraseña" required>
                        <input type="password" class="form-control mt-4" id="password_confirmation_empresa" name="password_confirmation" placeholder="Repita su contraseña" required>
                    </div>
                </div>

                <!-- Botón de Envío -->
                <div style="display: flex; justify-content: space-between; align-items: center; margin: 7%">
                    <button type="submit" id="btn-registro" class="cta btn">
                        <span id="btn-text">Registrarme</span>
                        <svg id="btn-icon" width="6%" height="1rem" viewBox="0 0 13 10">
                            <path d="M1,5 L11,5"></path>
                            <polyline points="8 1 12 5 8 9"></polyline>
                        </svg>
                    </button>
                </div>
            </form>
        </div>

        <!-- Enlace de Login -->
        <div class="container-der-login-registro mt-3">
            <p>¿Ya tienes una cuenta? <a href="{{ route('login') }}" class="enlaces-etiqueta-a" style="text-decoration: none;">Inicia sesión</a></p>
        </div>
    </div>

    <div class="col-md-7 col-12 d-flex justify-content-center align-items-center">
        <!-- Imagen representativa -->
        <img class="mujer-3d" src="{{asset('images/ilustracion-3d-mujer-programando.png')}}" alt="">
    </div>
</div>

<script>
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
</script>

<script>
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
                    'X-CSRF-TOKEN': '{{ csrf_token() }}',
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
                    window.location.href = '{{ route("login") }}';
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
</script>
</body>
</html>

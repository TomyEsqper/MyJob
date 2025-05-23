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

            <div style="display: flex; gap: 10px; margin-top: 5%; margin-bottom: 10%;">

                <!-- Boton de acceder con google -->
                <a href="{{ route('google.redirect') }}" class="google-btn">
                    <div class="google-icon-wrapper">
                        <img class="google-icon" src="https://developers.google.com/identity/images/g-logo.png" alt="Google logo">
                    </div>
                    <span>Registrarse con Google</span>
                </a>
            </div>
        </div>

        <div class="selector">
            <button id="btn-empresa"><span>Empresa</span></button>
            <button id="btn-usuario"><span>Usuario</span></button>
        </div>

        <div class="container-der-login-formulario mb-4">
            <form id="formulario-registro" method="POST" action="{{ route('register') }}">
                @csrf

                <div id="inputs-usuario" class="inputs-usuario">
                    <div class="mb-3">
                        <label for="nombre_usuario" class="form-label">Nombre</label>
                        <input type="text" class="form-control" name="name" id="name" placeholder="Ingrese su primer nombre">
                    </div>
                    <div class="mb-3">
                        <label for="correo_electronico" class="form-label">Correo Electrónico</label>
                        <input type="email" class="form-control" id="email" name="email" placeholder="Ingrese su correo electrónico">
                    </div>
                    <div class="mb-3">
                        <label for="contrasena" class="form-label">Contraseña</label>
                        <input type="password" class="form-control" id="password" name="password" placeholder="Ingrese su contraseña">
                        <input type="password" class="form-control mt-4" id="password_confirmation" name="password_confirmation" placeholder="Repita su contraseña">
                    </div>
                </div>

                <div id="inputs-empresa" class="inputs-empresa" style="display: none;">
                    <div class="mb-3">
                        <label for="nit" class="form-label">NIT</label>
                        <input type="text" class="form-control" name="nit" id="nit" placeholder="Ingrese su primer nombre">
                    </div>
                    <div class="mb-3">
                        <label for="correo_electronico" class="form-label">Correo Electrónico</label>
                        <input type="email" class="form-control" id="email" name="email" placeholder="Ingrese su correo electrónico">
                    </div>
                    <div class="mb-3">
                        <label for="contrasena" class="form-label">Contraseña</label>
                        <input type="password" class="form-control" id="password" name="password" placeholder="Ingrese su contraseña">
                        <input type="password" class="form-control mt-4" id="password_confirmation" name="password_confirmation" placeholder="Repita su contraseña">
                    </div>
                </div>



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
        <div class="container-der-login-registro mt-3">
            <p>¿Ya tienes una cuenta? <a href="{{ route('login') }}" class="enlaces-etiqueta-a" style="text-decoration: none;">Inicia sesion</a></p>
        </div>
    </div>

    <div class="col-md-7 col-12 d-flex justify-content-center align-items-center">
        <img class="mujer-3d" src="{{asset('images/ilustracion-3d-mujer-programando.png')}}" alt="">
    </div>
</div>


<script>
    document.addEventListener('DOMContentLoaded', function () {
        const btnEmpresa = document.getElementById('btn-empresa');
        const btnUsuario = document.getElementById('btn-usuario');
        const inputsEmpresa = document.getElementById('inputs-empresa');
        const inputsUsuario = document.getElementById('inputs-usuario');

        function activate(btnToActivate, btnToDeactivate) {
            btnToActivate.classList.add('activo');
            btnToDeactivate.classList.remove('activo');
        }
        btnEmpresa.addEventListener('click', () => {
            inputsEmpresa.style.display = 'block';
            inputsUsuario.style.display = 'none';
            activate(btnEmpresa, btnUsuario);
        });

        btnUsuario.addEventListener('click', () => {
            inputsUsuario.style.display = 'block';
            inputsEmpresa.style.display = 'none';
            activate(btnUsuario, btnEmpresa);
        });
    })
</script>
<script>

    const form = document.getElementById('formulario-registro');
    const btnRegistro = document.getElementById('btn-registro');
    const btnText = document.getElementById('btn-text');
    const btnIcon = document.getElementById('btn-icon');

    form.addEventListener('submit', async function (e) {
        e.preventDefault();

        // Mostrar estado de carga
        btnRegistro.disabled = true;
        btnText.textContent = 'Registrando...';

        const formData = new FormData(this);

        try {
            const response = await fetch(this.action, {
                method: 'POST',
                headers: {
                    'X-CSRF-TOKEN': '{{ csrf_token() }}'
                },
                body: formData
            });

            const data = await response.json();

            if (!response.ok) {
                // Si llega error de validación o API, lo mostramos
                Swal.fire({
                    icon: 'error',
                    title: 'Oops...',
                    text: data.error || 'Ha ocurrido un error.',
                });
            }else{
                // Exito
                Swal.fire({
                    icon: 'success',
                    title: '¡Registrado!',
                    text: data.message,
                    timer: 2000,
                    showConfirmButton: false
                }).then(() => {
                    window.location.href = '{{ route("login") }}';
                });
            }
        } catch (error) {
            console.error(error);
            Swal.fire({
                icon: 'error',
                title: 'Error',
                text: 'No se pudo procesar la solicitud.',
            });
        } finally {
            // Restablecer el estado del botón
            btnRegistro.disabled = false;
            btnText.textContent = 'Registrarme';
            btnIcon.style.display = '';
        }
    });
</script>
</body>
</html>

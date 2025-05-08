<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Registro</title>
    <link rel="stylesheet" media="all" href="{{ asset('css/loginRegistro.css') }}">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.4/dist/css/bootstrap.min.css" rel="stylesheet"
          integrity="sha384-DQvkBjpPgn7RC31MCQoOeC9TI2kdqa4+BSgNMNj8v77fdC77Kj5zpWFTJaaAoMbC" crossorigin="anonymous">
    <script src="https://accounts.google.com/gsi/client" async defer></script>
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
                <div
                    style="display: flex; flex-direction: column; align-items: center; gap: 10px; margin-top: 5%; margin-bottom: 12%;">
                    <div id="g_id_onload"
                         data-client_id="71941218229-ftubpr0ff82011hhgl43oueu0i3bs97t.apps.googleusercontent.com"
                         data-callback="handleCredentialResponse" data-context="signin" data-ux_mode="popup"
                         data-login_uri="" data-auto_prompt="false">
                    </div>
                    <div class="g_id_signin" data-type="standard" data-size="large" data-theme="outline"
                         data-text="sign_in_with" data-shape="rectangular" data-logo_alignment="left">
                    </div>
                </div>
            </div>
        </div>

        <div class="container-der-login-formulario mb-4" >
            <form id="formulario-registro" method="POST" action="{{ route('register') }}">
                @csrf
                <div class="mb-3">
                    <label for="text" class="form-label">Nombre</label>
                    <input type="text" class="form-control" name="nombre_usuario" id="nombre_usuario" placeholder="Ingrese su primer nombre">
                </div>
                <div class="mb-3">
                    <label for="email" class="form-label">Correo Electrónico</label>
                    <input type="email" class="form-control" id="correo_electronico" name="correo_electronico" placeholder="Ingrese su correo electrónico">
                </div>
                <div class="mb-3">
                    <label for="password" class="form-label">Contraseña</label>
                    <input type="password" class="form-control" id="contrasena" name="contrasena" placeholder="Ingrese su contraseña">
                    <input type="password" class="form-control mt-4" id="contrasena_confirmation" name="contrasena_confirmation" placeholder="Repita su contraseña">
                </div>

                <div style="display: flex; justify-content: space-between; align-items: center;">
                    <button type="submit" class="cta btn">
                        <span>Registrarme</span>
                        <svg width="6%" height="1rem" viewBox="0 0 13 10">
                            <path d="M1,5 L11,5"></path>
                            <polyline points="8 1 12 5 8 9"></polyline>
                        </svg>
                    </button>
                </div>
            </form>
        </div>
            <div class="container-der-login-registro">
            <p>¿Ya tienes una cuenta? <a href="/login" class="enlaces-etiqueta-a" style="text-decoration: none;">Inicia sesion</a></p>
        </div>
    </div>

    <div class="col-md-7 col-12 d-flex justify-content-center align-items-center">
        <img class="mujer-3d" src="{{asset('images/ilustracion-3d-mujer-programando.png')}}" alt="">
    </div>
</div>


<script>
    document.getElementById('formulario-registro').addEventListener('submit', async function (e) {
        e.preventDefault();

        const formData = new FormData(this);

        try {
            const response = await fetch("{{ route('register') }}", {
                method: 'POST',
                body: formData
            });

            const data = await response.json();
            if (data.error) {
                Swal.fire({
                    icon: 'error',
                    title: 'Oops...',
                    text: data.error,
                })
            } else if (data.message) {
                Swal.fire({
                    icon: 'success',
                    title: '¡Registrado!',
                    text: data.message,
                    timer: 2000,
                    showConfirmButton: false
                }).then(() => {
                    window.location.href = 'login.php';
                });
            }
        } catch (error) {
            console.error(error);
            Swal.fire({
                icon: 'error',
                title: 'Error',
                text: 'No se pudo procesar la solicitud.',
            });
        }
    });
</script>
</body>
</html>

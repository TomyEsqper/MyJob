<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Iniciar Sesión</title>
    <link rel="stylesheet" media="all" href="{{ asset('css/loginRegistro.css') }}">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.4/dist/css/bootstrap.min.css" rel="stylesheet"
          integrity="sha384-DQvkBjpPgn7RC31MCQoOeC9TI2kdqa4+BSgNMNj8v77fdC77Kj5zpWFTJaaAoMbC" crossorigin="anonymous">
    <script src="https://accounts.google.com/gsi/client" async defer></script>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
</head>
<body>
    <div class="row">
        <div class="col-md-7 col-12" style="display: flex; justify-content: center; align-items: center;">
            <img class="mujer-3d" src="{{ asset('Images/ilustracion-3d-mujer-saludando.png')}}" alt="">
        </div>

        <div class="col-md-5 col-12" style="padding: 4%; background-color: #f8f9fa;">
            <div class="container-der-login"
                 style="display: flex; flex-direction: column; justify-content: center; align-items: center; text-align: center;">
                <h1>Bienvenido a <span style="font-weight: bold;">My<span style="color: #258d19;">Job</span></span></h1>
                <h6>Regístrate para acceder a las oportunidades laborales que mejor se adapten a tu perfil.</h6>

                <!-- Boton de acceder con google -->
                <a href="{{ route('google.redirect') }}" class="google-btn m-4">
                    <div class="google-icon-wrapper">
                        <img class="google-icon" src="https://developers.google.com/identity/images/g-logo.png" alt="Google logo">
                    </div>
                    <span>Iniciar sesion con Google</span>
                </a>
            </div>

            <div class="container-der-login-formulario" style="margin-bottom: 20%;">
                <form id="formulario-login" method="POST" action="{{ route('login') }}">
                    @csrf
                    <div class="mb-3">
                        <label for="email" class="form-label">Correo Electrónico</label>
                        <input type="email" class="form-control" id="correo_electronico" name="correo_electronico" required autofocus
                               placeholder="Ingrese su correo electrónico">
                    </div>
                    <div class="mb-3">
                        <label for="password" class="form-label">Contraseña</label>
                        <input type="password" class="form-control" id="password" name="password" required
                               placeholder="Ingrese su contraseña">
                    </div>
                    <div style="display: flex; justify-content: space-between; align-items: center; margin: 6%">
                        <button type="submit" class="cta btn">
                            <span>Iniciar Sesión</span>
                            <svg width="6%" height="1rem" viewBox="0 0 13 10">
                                <path d="M1,5 L11,5"></path>
                                <polyline points="8 1 12 5 8 9"></polyline>
                            </svg>
                        </button>
                        <p style="margin-top: 3%">¿Haz olvidado tu contraseña?<a href="{{ route('ForgotPassword') }}"
                                                                                 class="enlaces-etiqueta-a" style="text-decoration: none;"> Haz click aquí</a></p>
                    </div>
                </form>
            </div>

            <div class="container-der-login-registro">
                <p>¿No tienes una cuenta? <a href="{{ route('register') }}" class="enlaces-etiqueta-a"
                                             style="text-decoration: none;">Regístrate</a></p>
            </div>
        </div>
    </div>

    <script>
        async function handleCredentialResponse(response) {
            console.log("Encoded JWT ID token: " + response.credential);
            try {
                const res = await fetch('{{ route('login.google') }}', {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json',
                        'X-CSRF-TOKEN': '{{ csrf_token() }}'
                    },
                    body: JSON.stringify({ credential: response.credential})
                });

                const data = await res.json();

                if (data.error) {
                    Swal.fire({
                        icon: 'error',
                        title: 'Oops...',
                        text: data.error,
                    });
                } else if (data.message && data.rol) {
                    Swal.fire({
                        icon: 'success',
                        title: '¡Bienvenido!',
                        text: data.message,
                        timer: 1500,
                        showConfirmButton: false
                    });
                }

            } catch (error) {
                console.error("Error sending token to backend:", error);
                Swal.fire({
                    icon: 'error',
                    title: 'Error',
                    text: 'No se pudo conectar con el servidor para el login con Google.'
                });
            }
        }
    </script>
</body>
</html>

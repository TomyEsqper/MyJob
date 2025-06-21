<!DOCTYPE html>
<html lang="es">
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
<!-- Contenedor principal con flexbox para mostrar imagen y formulario de login -->
<div class="row">
    <div class="col-md-7 col-12" style="display: flex; justify-content: center; align-items: center;">
        <!-- Imagen 3D de bienvenida -->
        <img class="mujer-3d" src="{{ asset('Images/ilustracion-3d-mujer-saludando.png')}}" alt="">
    </div>

    <div class="col-md-5 col-12" style="padding: 4%; background-color: #f8f9fa;">
        <div class="container-der-login"
             style="display: flex; flex-direction: column; justify-content: center; align-items: center; text-align: center; margin-bottom:0%">

            <!-- Título principal y subtítulo -->
            <h1>Bienvenido a <span style="font-weight: bold;">My<span style="color: #258d19;">Job</span></span></h1>
            <h6>Regístrate para acceder a las oportunidades laborales que mejor se adapten a tu perfil.</h6>

            <!-- Botón de acceso con Google -->
            <a href="{{ route('google.redirect') }}" class="google-btn m-4">
                <div class="google-icon-wrapper">
                    <!-- Logo de Google para el inicio de sesión -->
                    <img class="google-icon" src="https://developers.google.com/identity/images/g-logo.png" alt="Google logo">
                </div>
                <span>Iniciar sesion con Google</span>
            </a>
        </div>

        @if($errors->any())
            <script>
                document.addEventListener('DOMContentLoaded', function(){
                    Swal.fire({
                        icon: 'error',
                        title: 'Error al iniciar sesión',
                        text: '{{ $errors->first() }}'
                    });
                });
            </script>
        @endif

        <!-- Formulario de inicio de sesión -->
        <div class="container-der-login-formulario" style="margin-bottom: 20%;">
            <form id="formulario-login" method="POST" action="{{ route('login') }}">
                @csrf

                <!-- Correo Electrónico -->
                <label class="label">
                      <span class="icon">
                        <!-- Heroicon envelope outline -->
                        <svg xmlns="http://www.w3.org/2000/svg" width="30" height="30" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.25" stroke-linecap="round" stroke-linejoin="round">
                          <path d="M3 8.5l9 6 9-6"/>
                          <path d="M21 6v12H3V6h18Z"/>
                        </svg>
                      </span>
                    <input type="email" id="correo_electronico" name="correo_electronico" class="input @error('correo_electronico') is-invalid @enderror" value="{{ old('correo_electronico') }}" placeholder="Ingrese su correo electrónico" required autofocus/>

                </label>

                <!-- Contraseña -->
                <label class="label relative">
                    <input type="password" id="password" name="password" class="input pr-12" placeholder="Ingrese su contraseña" required/>
                    <button type="button" class="toggle-password absolute inset-y-0 right-0 pr-3 flex items-center" data-target="password" aria-label="Mostrar u ocultar contraseña">
                        Mostrar
                    </button>
                </label>


                <!-- Botón de inicio de sesión y enlace para recuperación de contraseña -->
                <div style="display: flex; justify-content: space-between; align-items: center;">
                    <button type="submit" class="cta btn">
                        <span>Iniciar Sesión</span>
                        <svg width="6%" height="1rem" viewBox="0 0 13 10">
                            <path d="M1,5 L11,5"></path>
                            <polyline points="8 1 12 5 8 9"></polyline>
                        </svg>
                    </button>
                    <p>¿Haz olvidado tu contraseña?<a href="{{ route('password.request') }}" class="enlaces-etiqueta-a" style="text-decoration: none;"> Haz click aquí</a></p>
                </div>
            </form>
        </div>

        <!-- Enlace para registro de nuevos usuarios -->
        <div class="container-der-login-registro" STYLE="margin-top: -4.6rem;">
            <p>¿No tienes una cuenta? <a href="{{ route('register') }}" class="enlaces-etiqueta-a"
                                         style="text-decoration: none;">Regístrate</a></p>
        </div>
    </div>
</div>

<!-- Script para el manejo de la respuesta de Google -->
<script>
    async function handleCredentialResponse(response) {
        console.log("Encoded JWT ID token: " + response.credential);
        try {
            // Enviar el token de Google al backend para iniciar sesión
            const res = await fetch('{{ route('login.google') }}', {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                    'X-CSRF-TOKEN': '{{ csrf_token() }}'
                },
                body: JSON.stringify({ credential: response.credential})
            });

            const data = await res.json();

            // Manejo de errores si el login falla
            if (data.error) {
                Swal.fire({
                    icon: 'error',
                    title: 'Oops...',
                    text: data.error,
                });
            } else if (data.message && data.rol) {
                // Si el login es exitoso, mostrar mensaje y redirigir
                Swal.fire({
                    icon: 'success',
                    title: '¡Bienvenido!',
                    text: data.message,
                    timer: 1500,
                    showConfirmButton: false
                });
            }

        } catch (error) {
            // En caso de error en la conexión con el backend
            console.error("Error sending token to backend:", error);
            Swal.fire({
                icon: 'error',
                title: 'Error',
                text: 'No se pudo conectar con el servidor para el login con Google.'
            });
        }
    }
</script>
<script>
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

</script>
</body>
</html>

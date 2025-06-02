<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>Registro</title>
    <link rel="stylesheet" media="all" href="{{ asset('css/loginRegistro.css') }}">
    <link rel="stylesheet" media="all" href="{{ asset('css/buttons.css') }}">

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.4/dist/css/bootstrap.min.css" rel="stylesheet"
          integrity="sha384-DQvkBjpPgn7RC31MCQoOeC9TI2kdqa4+BSgNMNj8v77fdC77Kj5zpWFTJaaAoMbC" crossorigin="anonymous">
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

</head>
<body>
<div class="row">
    <div class="col-md-5 col-12 p-4 bg-light" style="height: 100%">
        <div class="container-der-login" style="display: flex; flex-direction: column; justify-content: center; align-items: center; text-align: center; margin-bottom:0">
            <h1>Bienvenido a <strong>My<span style="color:#258d19;">Job</span></strong></h1>
            <h6>Regístrate para acceder a las oportunidades laborales.</h6>
            <div style="display: flex; gap: 10px; margin-top: 4%; margin-bottom: 4%;">
                <!-- Boton de acceder con google -->
                <a href="{{ route('google.redirect') }}" class="google-btn">
                    <div class="google-icon-wrapper">
                        <img class="google-icon" src="https://developers.google.com/identity/images/g-logo.png" alt="Google logo">
                    </div>
                    <span>Registrarse con Google</span>
                </a>
            </div>
        </div>

        <div class="selector" style="display: flex; justify-content: center; align-items: center; gap: 1rem">
            <button id="btn-empresa"><span>Empresa</span></button>
            <button id="btn-usuario" class="activo"><span>Usuario</span></button>
        </div>

        <div class="container-der-login-formulario mb-4">
            <form id="formulario-registro" method="POST" action="{{ route('register') }}">
                @csrf

                {{-- SECCION USUARIO --}}
                <div id="inputs-usuario">
                    <div class="mb-3">
                        <label for="name_usuario" class="form-label">Nombre</label>
                        <input type="text" name="name" id="name_usuario"
                               class="form-control" placeholder="Ingrese su nombre" required>
                    </div>
                    <div class="mb-3">
                        <label for="correo_electronico_usuario" class="form-label">
                            Correo Electrónico
                        </label>
                        <input type="email" name="correo_electronico" id="correo_electronico_usuario"
                               class="form-control" placeholder="Ingrese su correo" required>
                    </div>
                    <div class="mb-3">
                        <label for="password_usuario" class="form-label">Contraseña</label>
                        <input type="password" name="password" id="password_usuario"
                               class="form-control" placeholder="Ingrese su contraseña" required>
                        <input type="password" name="password_confirmation"
                               id="password_confirmation_usuario"
                               class="form-control mt-3"
                               placeholder="Repita su contraseña" required>
                    </div>
                </div>


                {{-- SECCIÓN EMPRESA --}}
                <div id="inputs-empresa" style="display:none;">
                    {{-- si quieres prellenar el nombre de la empresa desde la API --}}
                    <input type="hidden" name="name" id="company_name" value="">

                    <div class="mb-3">
                        <label for="nit_empresa" class="form-label">NIT</label>
                        <input type="text" name="nit" id="nit_empresa"
                               class="form-control" placeholder="Ingrese su NIT"
                               disabled required>
                    </div>
                    <div class="mb-3">
                        <label for="correo_electronico_empresa" class="form-label">
                            Correo Electrónico
                        </label>
                        <input type="email" name="correo_electronico"
                               id="correo_electronico_empresa"
                               class="form-control" placeholder="Ingrese su correo"
                               disabled required>
                    </div>
                    <div class="mb-3">
                        <label for="password_empresa" class="form-label">Contraseña</label>
                        <input type="password" name="password" id="password_empresa"
                               class="form-control" placeholder="Ingrese su contraseña"
                               disabled required>
                        <input type="password" name="password_confirmation"
                               id="password_confirmation_empresa"
                               class="form-control mt-3"
                               placeholder="Repita su contraseña" disabled required>
                    </div>
                </div>

                <div class="d-flex justify-content-between align-items-center my-4">
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
        <div class="container-der-login-registro">
            <p>¿Ya tienes una cuenta? <a href="{{ route('login') }}" class="enlaces-etiqueta-a" style="text-decoration: none;">Inicia sesión</a></p>
        </div>
    </div>

    <div class="col-md-7 col-12 d-flex justify-content-center align-items-center">
        <img class="mujer-3d" src="{{asset('images/ilustracion-3d-mujer-programando.png')}}" alt="">
    </div>
</div>

<script src="{{ asset('js/register.js') }}" defer></script>
</body>
</html>

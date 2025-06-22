<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Registro</title>
    <link rel="stylesheet" media="all" href="{{ asset('css/loginRegistro.css') }}">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <meta name="login-url" content="{{ route('login') }}">
    <meta name="google-redirect-url"
          content="{{ route('google.redirect') }}">
    <script src="{{ asset('js/auth/register.js') }}" defer></script>

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.4/dist/css/bootstrap.min.css" rel="stylesheet"
          integrity="sha384-DQvkBjpPgn7RC31MCQoOeC9TI2kdqa4+BSgNMNj8v77fdC77Kj5zpWFTJaaAoMbC" crossorigin="anonymous">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.4/dist/js/bootstrap.bundle.min.js" integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous" defer></script>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <style>
        .help-icon {
            display: inline-flex;
            align-items: center;
            justify-content: center;
            width: 20px;
            height: 20px;
            border-radius: 50%;
            background-color: #6c757d;
            color: white;
            font-weight: bold;
            cursor: pointer;
            font-size: 14px;
        }
    </style>
</head>
<body>
<div class="row">
    <div class="col-md-5 col-12 p-4 bg-light">
        <div class="container-der-login" style="display: flex; flex-direction: column; justify-content: center; align-items: center; text-align: center; margin-bottom:0">
            <h1>Bienvenido a <strong>My<span style="color:#258d19;">Job</span></strong></h1>
            <h6>Regístrate para acceder a las oportunidades laborales.</h6>

            <!-- Botón de inicio de sesión con Google -->
            <div style="display: flex; align-items: center; gap: 10px; margin-top: 5%;">
                <a href="#"
                   id="btn-google"
                   data-base-url="{{ route('google.redirect') }}"
                   class="google-btn">
                    <div class="google-icon-wrapper">
                        <img class="google-icon"
                             src="https://developers.google.com/identity/images/g-logo.png"
                             alt="Google logo">
                    </div>
                    <span>Registrarme con Google</span>
                </a>
                <span class="help-icon" data-bs-toggle="tooltip" data-bs-placement="top" title="Según la opción que elijas (Usuario o Empresa), se te asignará un rol en el sistema.">?</span>
            </div>
        </div>

        <!-- Selector para cambiar entre Empresa y Usuario -->
        <div class="role-toggle">
            <div class="btnContainer">
                <button type="button" id="btn-empresa"><span>Empresa</span></button>
            </div>
            <div class="btnContainer">
                <button type="button" id="btn-usuario" class="activo"><span>Usuario</span></button>
            </div>
        </div>

        <!-- Formulario de Registro -->
        <div class="container-der-login-formulario mb-4">
            <form id="formulario-registro" method="POST" action="{{ route('register') }}">
                @csrf

                <!-- Campo oculto para el rol -->
                <input type="hidden" id="rol" name="rol" value="empleado">


                <!-- Formulario de Usuario (visible al cargar) -->
                <div id="inputs-usuario" class="inputs-usuario" style="display: block;">
                    <label class="label">
                            <span class="icon">
                              <svg class="w-6 h-6 text-gray-800 dark:text-white" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" width="30" height="30" fill="none" viewBox="0 0 24 24">
                                <path stroke="currentColor" stroke-width="1.25" d="M7 17v1a1 1 0 0 0 1 1h8a1 1 0 0 0 1-1v-1a3 3 0 0 0-3-3h-4a3 3 0 0 0-3 3Zm8-9a3 3 0 1 1-6 0 3 3 0 0 1 6 0Z"/>
                              </svg>
                            </span>
                        <input type="text" class="input" name="name" id="name_usuario" placeholder="Ingrese su nombre" autocomplete="off" data-required="true" required/>
                    </label>

                    <label class="label">
                            <span class="icon">
                              <svg xmlns="http://www.w3.org/2000/svg" width="30" height="30" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.25" stroke-linecap="round" stroke-linejoin="round">
                                <path d="M3 8.5l9 6 9-6"/>
                                <path d="M21 6v12H3V6h18Z"/>
                              </svg>
                            </span>
                        <input type="email" class="input" name="email" id="email_usuario" placeholder="Ingrese su correo electrónico" autocomplete="off" data-required="true" required/>
                    </label>

                    <!-- Usuario Password Field -->
                    <div class="password-field">
                        <label class="label">
                            <input
                                type="password"
                                id="password_usuario"
                                name="password"
                                class="input"
                                placeholder="Ingrese su contraseña"
                                data-required="true"
                                required
                            />
                            <button
                                type="button"
                                class="toggle-password"
                                data-target="password_usuario"
                                aria-label="Mostrar u ocultar contraseña"
                            >Mostrar</button>
                        </label>
                        <div class="password-rules">
                            <div class="rule" data-rule="uppercase">Mayúscula</div>
                            <div class="rule" data-rule="lowercase">Minúscula</div>
                            <div class="rule" data-rule="number">Número</div>
                            <div class="rule" data-rule="special">Especial</div>
                            <div class="rule" data-rule="length">>= 8 caracteres</div>
                        </div>
                    </div>


                    <label class="label">
                            <span class="icon">
                              <svg xmlns="http://www.w3.org/2000/svg" width="30" height="30" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.25" stroke-linecap="round" stroke-linejoin="round">
                                <rect x="4" y="11" width="16" height="10" rx="2" ry="2"/>
                                <path d="M8 11V7a4 4 0 0 1 8 0v4"/>
                              </svg>
                            </span>
                        <input type="password" class="input" id="password_confirmation_usuario" name="password_confirmation" placeholder="Repita su contraseña" data-required="true" required/>
                    </label>
                </div>

                <!-- Formulario de Empresa (oculto al cargar) -->
                <div id="inputs-empresa" class="inputs-empresa" style="display: none;">
                    <label class="label">
                            <span class="icon">
                              <svg xmlns="http://www.w3.org/2000/svg" width="30" height="30" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.25" stroke-linecap="round" stroke-linejoin="round">
                                <path d="M3 21V8a1 1 0 0 1 1-1h16a1 1 0 0 1 1 1v13"/>
                                <path d="M9 21V12h6v9"/>
                                <path d="M9 3v4"/>
                                <path d="M15 3v4"/>
                              </svg>
                            </span>
                        <input type="text" id="name_empresa" name="nombre_empresa" class="input" placeholder="Ingrese el nombre de la empresa" data-required="true" required/>
                    </label>

                    <label class="label">
                            <span class="icon">
                              <svg xmlns="http://www.w3.org/2000/svg" width="30" height="30" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.25" stroke-linecap="round" stroke-linejoin="round">
                                <path d="M4 4h16v16H4z"/>
                                <path d="M4 8h16"/>
                                <circle cx="8" cy="12" r="2"/>
                              </svg>
                            </span>
                        <input type="text" id="nit_empresa" name="nit" class="input" placeholder="Ingrese su NIT" data-required="true" required/>
                    </label>

                    <label class="label">
                            <span class="icon">
                              <svg xmlns="http://www.w3.org/2000/svg" width="30" height="30" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.25" stroke-linecap="round" stroke-linejoin="round">
                                <path d="M3 8.5l9 6 9-6"/>
                                <path d="M21 6v12H3V6h18Z"/>
                              </svg>
                            </span>
                        <input type="email" id="correo_empresarial" name="correo_empresarial" class="input" placeholder="Ingrese el correo empresarial" data-required="true" required/>
                        <!-- oculto para backend -->
                        <input type="hidden" id="email_empresa" name="email">
                    </label>

                    <label class="label">
                            <span class="icon">
                              <svg xmlns="http://www.w3.org/2000/svg" width="30" height="30" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.25" stroke-linecap="round" stroke-linejoin="round">
                                <path d="M12 21s-6-5.686-6-10a6 6 0 0 1 12 0c0 4.314-6 10-6 10z"/>
                                <circle cx="12" cy="11" r="2"/>
                              </svg>
                            </span>
                        <input type="text" id="direccion_empresa" name="direccion_empresa" class="input" placeholder="Ingrese la dirección de la empresa" data-required="true" required/>
                    </label>

                    <label class="label">
                            <span class="icon">
                              <svg xmlns="http://www.w3.org/2000/svg" width="30" height="30" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round">
                                <path d="M22 16.92v3a2 2 0 0 1-2.18 2
                                         19.79 19.79 0 0 1-8.63-3.07
                                         19.57 19.57 0 0 1-6-6
                                         A19.79 19.79 0 0 1 2 4.18
                                         2 2 0 0 1 4 2h3
                                         a2 2 0 0 1 2 1.72
                                         c.12.81.36 1.6.72 2.34
                                         a2 2 0 0 1-.45 2.11
                                         L8.09 8.91
                                         a16 16 0 0 0 6 6
                                         l1.17-1.17
                                         a2 2 0 0 1 2.11-.45
                                         c.74.36 1.53.6 2.34.72
                                         A2 2 0 0 1 22 16.92z"/>
                              </svg>
                            </span>
                        <input type="text" id="telefono_contacto" name="telefono_contacto" class="input" placeholder="Ingrese el teléfono de contacto" data-required="true" required/>
                    </label>

                    <div class="inputs-empresa-inline">
                        <!-- Empresa Password Field -->
                        <div class="password-field">
                            <label class="label">
                                <input
                                    type="password"
                                    id="password_empresa"
                                    name="password_empresa"
                                    class="input"
                                    placeholder="Ingrese su contraseña"
                                    data-required="true"
                                    required
                                />
                                <button
                                    type="button"
                                    class="toggle-password"
                                    data-target="password_empresa"
                                    aria-label="Mostrar u ocultar contraseña"
                                >Mostrar</button>
                            </label>
                            <div class="password-rules">
                                <div class="rule" data-rule="uppercase">Mayúscula</div>
                                <div class="rule" data-rule="lowercase">Minúscula</div>
                                <div class="rule" data-rule="number">Número</div>
                                <div class="rule" data-rule="special">Especial</div>
                                <div class="rule" data-rule="length">>= 8 caracteres</div>
                            </div>
                        </div>

                        <label class="label">
                                  <span class="icon">
                                    <svg xmlns="http://www.w3.org/2000/svg" width="30" height="30" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.25" stroke-linecap="round" stroke-linejoin="round">
                                      <rect x="4" y="11" width="16" height="10" rx="2" ry="2"/>
                                      <path d="M8 11V7a4 4 0 0 1 8 0v4"/>
                                    </svg>
                                  </span>
                            <input type="password" id="password_confirmation_empresa" name="password_confirmation_empresa" class="input" placeholder="Repita su contraseña" data-required="true" required/>
                        </label>
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
</body>
</html>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Iniciar Sesión</title>
    <link rel="stylesheet" media="all" href="../../Assets/CSS/styles.css">

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.4/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-DQvkBjpPgn7RC31MCQoOeC9TI2kdqa4+BSgNMNj8v77fdC77Kj5zpWFTJaaAoMbC" crossorigin="anonymous">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.4/dist/js/bootstrap.bundle.min.js" integrity="sha384-YUe2LzesAfftltw+PEaao2tjU/QATaW/rOitAq67e0CT0Zi2VVRL0oC4+gAaeBKu" crossorigin="anonymous"></script>

    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
</head>
<body>
    <div class="row">
        <div class="col-md-7 col-12" style="display: flex; justify-content: center; align-items: center;">
            <img class="mujer-3d" src="../../Resources/Images/ilustracion-3d-mujer-saludando.png" alt="">
        </div>

        <div class="col-md-5 col-12" style="padding: 4%; background-color: #f8f9fa;">
            <div class="container-der-login" style="display: flex; flex-direction: column; justify-content: center; align-items: center; text-align: center; margin-bottom:0%">
                <h1>Bienvenido a <span style="font-weight: bold;">My<span style="color: #258d19;">Job</span></span></h1>
                <h6>Regístrate para acceder a las oportunidades laborales que mejor se adapten a tu perfil.</h6>
            
                <div style="display: flex; gap: 10px; margin-top: 5%; margin-bottom: 12%;">
                    <button class="btn-iconos"><img src="../../Resources/Logos/logo-de-google-48.png" alt="logo-google"></button>
                    <button class="btn-iconos"><img src="../../Resources/Logos/facebook-nuevo-48.png" alt="logo-facebook"></button>
                    <button class="btn-iconos"><img src="../../Resources/Logos/mac-os-50.png" alt="logo-apple"></button>
                </div>
            </div>

            <div class="container-der-login-formulario" style="margin-bottom: 20%;">
                <form id="formulario-login" method="POST">
                    <div class="mb-3">
                        <label for="email" class="form-label">Correo Electrónico</label>
                        <input type="email" class="form-control" id="email" name="correo_electronico" placeholder="Ingrese su correo electrónico">
                    </div>
                    <div class="mb-3">
                        <label for="password" class="form-label">Contraseña</label>
                        <input type="password" class="form-control" id="password" name="password" placeholder="Ingrese su contraseña">
                    </div>
                    <div style="display: flex; justify-content: space-between; align-items: center;">
                        <button type="submit" class="cta btn">
                            <span>Iniciar Sesión</span>
                            <svg width="6%" height="1rem" viewBox="0 0 13 10">
                                <path d="M1,5 L11,5"></path>
                                <polyline points="8 1 12 5 8 9"></polyline>
                            </svg>
                        </button>
                        <p style="margin-top: 3%">¿Haz olvidado tu contraseña?<a href="register.php" class="enlaces-etiqueta-a" style="text-decoration: none;"> Haz click aquí</a></p>
                    </div>
                </form>
            </div>

            <div class="container-der-login-registro">
                <p>¿No tienes una cuenta? <a href="register.php" class="enlaces-etiqueta-a" style="text-decoration: none;">Regístrate</a></p>
            </div>
        </div>
    </div>  


    <script>
        document.getElementById('formulario-login').addEventListener('submit', async function(e) {
            e.preventDefault();

            const formData = new FormData(this);

            try {
                const response = await fetch('../../Controllers/Auth/loginController.php', {
                    method: 'POST',
                    body: formData
                });

                const data = await response.json();

                if (data.error) {
                    Swal.fire({
                        icon: 'error',
                        title: 'Oops...',
                        text: data.error,
                    });
                }else if (data.message && data.rol) {
                    Swal.fire({
                        icon: 'success',
                        title: '¡Bienvenido!',
                        text: data.message,
                        timer: 1500,
                        showConfirmButton: false
                    }).then(() => {
                        if (data.rol === 'empleado') {
                            window.location.href = '../../Views/Empleado/dashboard.php';
                        } else if (data.rol === 'empleador') {
                            window.location.href = '../../Views/Empleador/dashboard.php';
                        } else if (data.rol === 'admin') {
                            window.location.href = '../../Views/Admin/dashboard.php';
                        } else {
                            window.location.href = '#';
                        }
                    });
                }
            } catch (error) {
                console.error(error);
                Swal.fire({
                    icon: 'error',
                    title: 'Error',
                    text: 'No se pudo procesar la solicitud.'
                })
            }

        });
    </script>
</body>
</html>
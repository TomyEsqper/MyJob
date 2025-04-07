<?php
require_once '../../../Config/db.php';
// Se elimina esta línea porque no usas la consulta
// $userTypes = $conexion->query("SELECT * FROM usuarios"); 
?>


<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Registro</title>
    <link rel="stylesheet" media="all" href="../../Assets/CSS/styles.css">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.4/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-DQvkBjpPgn7RC31MCQoOeC9TI2kdqa4+BSgNMNj8v77fdC77Kj5zpWFTJaaAoMbC" crossorigin="anonymous">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.4/dist/js/bootstrap.bundle.min.js" integrity="sha384-YUe2LzesAfftltw+PEaao2tjU/QATaW/rOitAq67e0CT0Zi2VVRL0oC4+gAaeBKu" crossorigin="anonymous"></script>
    
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>

</head>
<body>
    <div class="row">
        <div class="col-md-5 col-12" style="padding: 4%; background-color: #f8f9fa; hight: 100%;">
            <div class="container-der-login" style="display: flex; flex-direction: column; justify-content: center; align-items: center; text-align: center; margin-bottom:0%">
                <h1>Bienvenido a <span style="font-weight: bold;">My<span style="color: #258d19;">Job</span></span></h1>
                <h6>Regístrate para acceder a las oportunidades laborales que mejor se adapten a tu perfil.</h6>
            
                <div style="display: flex; gap: 10px; margin-top: 5%; margin-bottom: 10%;">
                    <button class="btn-iconos"><img src="../../Resources/Logos/logo-de-google-48.png" alt="logo-google"></button>
                    <button class="btn-iconos"><img src="../../Resources/Logos/facebook-nuevo-48.png" alt="logo-facebook"></button>
                    <button class="btn-iconos"><img src="../../Resources/Logos/mac-os-50.png" alt="logo-apple"></button>
                </div>

            </div>

            <div class="container-der-login-formulario" style="margin-bottom: 10%;">
                <form id="formulario-registro" method="POST" action="../../Controllers/Auth/registerController.php">
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
                        <input type="password" class="form-control" id="password" name="password" placeholder="Ingrese su contraseña">
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
            <div class="container-der-login-registro"">
                <p>¿Ya tienes una cuenta? <a href="#" class="enlaces-etiqueta-a" style="text-decoration: none;">Inicia sesion</a></p>
            </div>
        </div>

        <div class="col-md-7 col-12" style="display: flex; justify-content: center; align-items: center;">
            <img class="mujer-3d" src="../../Resources/Images/ilustracion-3d-mujer-programando.png" alt="">
        </div>
    </div>  
</body>
</html>
<?php
$host = "localhost";
$db   = "myjob";
$user = "root";
$pass = "";

$conexion = mysqli_connect($host, $user, $pass, $db);

if (!$conexion) {
    echo "Error al conectar a la base de datos: " . mysqli_connect_error();
} /* else {
    echo "Conexión exitosa";
} */
?>

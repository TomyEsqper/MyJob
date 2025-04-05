<?php
$host = "localhost";
$db   = "myjob";
$user = "root";
$pass = "";

$conexion = mysqli_connect($host, $user, $pass, $db);

if ($conexion->connect_error) {
    echo "Error al conectar a la base de datos";
}/*else {
    echo "Conexión exitosa";
}*/
?> 
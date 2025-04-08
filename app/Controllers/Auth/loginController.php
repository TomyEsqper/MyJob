<?php
session_start();
header('Content-Type: application/json');
require_once '../../../Config/db.php';

$correo = $_POST['correo_electronico'];
$password = $_POST['password'];

$stmt = $conexion->prepare("SELECT id_usuario, contrasena, rol FROM usuarios WHERE correo_electronico = ?");
$stmt->bind_param("s", $correo);
$stmt->execute();
$result = $stmt->get_result();

if ($result->num_rows === 0) {
    echo json_encode(['error' => 'Correo no esta registrado']);
    exit();
}

$user = $result->fetch_assoc();

//Verifica la contraseña
if (password_verify($password, $user['contrasena'])) {
    $_SESSION['id_usuario'] = $user['id_usuario'];
    $_SESSION['rol'] = $user['rol'];

    echo json_encode([
        'message' => 'Inicio de sesion exitoso',
        'rol' => $user['rol']
    ]);
}else {
    echo json_encode(['error' => 'Contraseña incorrecta']);
}
?>
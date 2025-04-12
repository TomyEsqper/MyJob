<?php
session_start();
header('Content-Type: application/json');
require_once '../../../Config/db.php';

$correo = $_POST['correo_electronico'];
$password = $_POST['password'];

$stmt = $conexion->prepare("SELECT id_usuario, contrasena, rol, correo_electronico FROM usuarios WHERE correo_electronico = ?");
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
    
    // Verificar si el correo termina con @myjob.com para asignar rol de admin
    if (substr(strtolower($user['correo_electronico']), -10) === '@myjob.com') {
        $_SESSION['rol'] = 'admin';
        
        // Actualizar el rol en la base de datos si no es admin ya
        if ($user['rol'] !== 'admin') {
            $updateStmt = $conexion->prepare("UPDATE usuarios SET rol = 'admin' WHERE id_usuario = ?");
            $updateStmt->bind_param("i", $user['id_usuario']);
            $updateStmt->execute();
        }
        
        $rol = 'admin';
    } else {
        $_SESSION['rol'] = $user['rol'];
        $rol = $user['rol'];
    }

    echo json_encode([
        'message' => 'Inicio de sesion exitoso',
        'rol' => $rol
    ]);
}else {
    echo json_encode(['error' => 'Contraseña incorrecta']);
}
?>
<?php
header('Content-Type: application/json');
require_once '../../../Config/db.php'; // Asegúrate de que la ruta sea correcta

// Validar si los campos existen
if (!isset($_POST['nombre_usuario']) || !isset($_POST['correo_electronico']) || !isset($_POST['password'])) {
    echo json_encode(['error' => 'Faltan datos']);
    exit();
}

$nombre = $_POST['nombre_usuario'];
$correo = $_POST['correo_electronico'];
$password = password_hash($_POST['password'], PASSWORD_DEFAULT);
$rol = 'empleado'; // Rol por defecto

// Validar si el correo ya existe
$stmt = $conexion->prepare("SELECT id_usuario FROM usuarios WHERE correo_electronico = ?");
if (!$stmt) {
    echo json_encode(['error' => 'Error en la consulta']);
    exit();
}
$stmt->bind_param("s", $correo);
$stmt->execute();
$result = $stmt->get_result();

if ($result->num_rows > 0) {
    echo json_encode(['error' => 'El correo ya está registrado']);
    exit();
}

// Insertar el nuevo usuario con rol "empleado"
$stmt = $conexion->prepare("INSERT INTO usuarios (nombre_usuario, correo_electronico, contrasena, rol) VALUES (?, ?, ?, ?)");
if (!$stmt) {
    echo json_encode(['error' => 'Error al preparar la consulta']);
    exit();
}
$stmt->bind_param("ssss", $nombre, $correo, $password, $rol);

if ($stmt->execute()) {
    echo json_encode(['message' => 'Registro exitoso']);
} else {
    echo json_encode(['error' => 'Error al registrar el usuario']);
}
?>

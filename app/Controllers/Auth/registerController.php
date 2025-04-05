<?php
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    require_once '../../../Config/db.php';

    $nombre_usuario = trim($_POST['nombre_usuario']);
    $correo_electronico = trim($_POST['correo_electronico']);
    $contrasena = password_hash(trim($_POST['contrasena']), PASSWORD_DEFAULT);

    if (empty($nombre_usuario) || empty($correo_electronico) || empty($contrasena)) {
        echo "Todos los campos son obligatorios.";
        exit;
    }

    // Verificar si el correo ya está registrado
    $stmt = $conexion->prepare("SELECT id_usuario FROM usuarios WHERE correo_electronico = ?");
    if (!$stmt) {
        echo "Error en la preparación de la consulta: " . $conexion->error;
        exit;
    }
    $stmt->bind_param("s", $correo_electronico);
    $stmt->execute();
    $stmt->store_result();

    if ($stmt->num_rows > 0) {
        echo "El correo electrónico ya está registrado.";
    } else {
        // Insertar el nuevo usuario
        $stmt = $conexion->prepare("INSERT INTO usuarios (nombre_usuario, correo_electronico, contrasena) VALUES (?, ?, ?)");
        if (!$stmt) {
            echo "Error en la preparación de la consulta: " . $conexion->error;
            exit;
        }
        $stmt->bind_param("sss", $nombre_usuario, $correo_electronico, $contrasena);

        if ($stmt->execute()) {
            echo "Usuario registrado correctamente.";
        } else {
            echo "Error al registrar el usuario: " . $stmt->error;
        }
    }
    $stmt->close();
    $conexion->close();
}
?>
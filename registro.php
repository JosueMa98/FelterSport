<?php

include 'conexion.php'; 

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $correo = $_POST['correo'];
    $contraseña = $_POST['contraseña'];
    $nombre = $_POST['nombre'];
    $direccion = $_POST['direccion'];

    // Validar formato de correo
    if (!filter_var($correo, FILTER_VALIDATE_EMAIL)) {
        $mensaje = "El correo no tiene un formato válido.";
    } else {
        // Validar existencia del dominio
        $dominio = substr(strrchr($correo, "@"), 1); // Extrae el dominio
        if (!checkdnsrr($dominio, "MX")) {
            $mensaje = "El dominio del correo no existe.";
        } else {
            // Validar si el correo ya existe en la base de datos
            $sql = "SELECT * FROM Usuarios WHERE correo = ?";
            $stmt = $conn->prepare($sql);
            $stmt->bind_param("s", $correo);
            $stmt->execute();
            $resultado = $stmt->get_result();

            if ($resultado->num_rows > 0) {
                $mensaje = "El correo ya está registrado.";
            } else {
                // Registrar al cliente
                $contraseñaHash = password_hash($contraseña, PASSWORD_DEFAULT); // Encriptar contraseña
                $sql = "INSERT INTO Usuarios (correo, contraseña, nombre, direccion, tipo_usuario) VALUES (?, ?, ?, ?, 'cliente')";
                $stmt = $conn->prepare($sql);
                $stmt->bind_param("ssss", $correo, $contraseñaHash, $nombre, $direccion);

                if ($stmt->execute()) {
                    session_start(); // Inicia la sesión
                    $_SESSION['mensaje'] = "Registro exitoso. ¡Inicia sesión!"; // Guarda el mensaje en la sesión
                    header("Location: login.php"); // Redirige al login
                    exit(); // Finalizar el script después de redirigir

                } else {
                    $mensaje = "Error al registrar. Inténtalo de nuevo.";
                }
            }
        }
    }

    // Mostrar mensaje final
    echo $mensaje;
}
?>


<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Registro</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>
<div class="container mt-5">
    <h2 class="text-center">Registro de Cliente</h2>
    <?php if (isset($mensaje)) : ?>
        <div class="alert alert-info text-center"><?php echo $mensaje; ?></div>
    <?php endif; ?>
    <form method="POST" class="mt-4">
        <div class="mb-3">
            <label for="correo" class="form-label">Correo Electrónico</label>
            <input type="email" class="form-control" id="correo" name="correo" required>
        </div>
        <div class="mb-3">
            <label for="contraseña" class="form-label">Contraseña (máximo 10 caracteres)</label>
            <input type="password" class="form-control" id="contraseña" name="contraseña" maxlength="10" required>
        </div>
        <div class="mb-3">
            <label for="nombre" class="form-label">Nombre Completo</label>
            <input type="text" class="form-control" id="nombre" name="nombre" required>
        </div>
        <div class="mb-3">
            <label for="direccion" class="form-label">Dirección</label>
            <textarea class="form-control" id="direccion" name="direccion" required></textarea>
        </div>
        <button type="submit" class="btn btn-primary w-100">Registrar</button>
    </form>
    <div class="text-center mt-3">
        <a href="login.php">¿Ya tienes una cuenta? Inicia sesión</a>
    </div>
</div>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>

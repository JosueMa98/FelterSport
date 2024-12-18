<?php
// Incluir conexión a la base de datos
include 'conexion.php';

session_start(); // Iniciar sesión para almacenar los datos del usuario

// Verificar si hay un mensaje de sesión y mostrarlo
if (isset($_SESSION['mensaje'])) {
    echo '<div class="alert alert-success text-center">' . htmlspecialchars($_SESSION['mensaje']) . '</div>';
    unset($_SESSION['mensaje']); // Elimina el mensaje después de mostrarlo
}

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $correo = $_POST['correo'];
    $contraseña = $_POST['contraseña'];

    // Consultar si el usuario existe
    $sql = "SELECT id_usuario, nombre, contraseña, tipo_usuario FROM Usuarios WHERE correo = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("s", $correo);
    $stmt->execute();
    $resultado = $stmt->get_result();

    if ($resultado->num_rows > 0) {
        $usuario = $resultado->fetch_assoc();

        // Comparar la contraseña ingresada con el hash almacenado
        if (password_verify($contraseña, $usuario['contraseña'])) {
            // Contraseña válida, iniciar sesión
            $_SESSION['id_usuario'] = $usuario['id_usuario'];
            $_SESSION['nombre'] = $usuario['nombre'];
            $_SESSION['tipo_usuario'] = $usuario['tipo_usuario'];

            // Redirigir según el tipo de usuario
            if ($usuario['tipo_usuario'] == 'cliente') {
                header("Location: index.php");
            } elseif ($usuario['tipo_usuario'] == 'admin') {
                header("Location: dashboard_admin.php");
            }
            exit();
        } else {
            $mensaje = "Contraseña incorrecta.";
        }
    } else {
        $mensaje = "Usuario no encontrado.";
    }
}
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>
<div class="container mt-5">
    <h2 class="text-center">Iniciar Sesión</h2>
    <?php if (isset($mensaje)) : ?>
        <div class="alert alert-danger text-center"><?php echo $mensaje; ?></div>
    <?php endif; ?>
    <form method="POST" class="mt-4">
        <div class="mb-3">
            <label for="correo" class="form-label">Correo Electrónico</label>
            <input type="email" class="form-control" id="correo" name="correo" required>
        </div>
        <div class="mb-3">
            <label for="contraseña" class="form-label">Contraseña</label>
            <input type="password" class="form-control" id="contraseña" name="contraseña" required>
        </div>
        <button type="submit" class="btn btn-primary w-100">Iniciar Sesión</button>
    </form>
    <div class="text-center mt-3">
        <a href="registro.php">¿No tienes una cuenta? Regístrate</a>
    </div>
</div>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>

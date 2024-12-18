<?php

include 'conexion.php';

// Datos del administrador
$correo = 'L20171583@culiacan.tecnm.mx';
$contraseñaNueva = '123'; // La contraseña que quieras asignar (texto plano)

// Encriptar la nueva contraseña
$contraseñaHash = password_hash($contraseñaNueva, PASSWORD_DEFAULT);

// Actualizar la contraseña en la base de datos
$sql = "UPDATE Usuarios SET contraseña = ? WHERE correo = ?";
$stmt = $conn->prepare($sql);
$stmt->bind_param("ss", $contraseñaHash, $correo);

if ($stmt->execute()) {
    echo "Contraseña del administrador actualizada correctamente.";
} else {
    echo "Error al actualizar la contraseña: " . $conn->error;
}
?>

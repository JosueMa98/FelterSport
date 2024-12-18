<?php
include 'conexion.php';
session_start(); 

// Verificar si el usuario está logueado
if (!isset($_SESSION['id_usuario'])) {
    header("Location: login.php");
    exit();
}

// Verificar si se proporcionó el ID del detalle del carrito a eliminar
if (!isset($_GET['id_detalle'])) {
    echo "Error: No se proporcionó el ID del producto en el carrito.";
    exit();
}

$id_detalle = intval($_GET['id_detalle']);

// Eliminar el producto del carrito
$sql_eliminar = "DELETE FROM detalles_pedidos WHERE id_detalle = ?";
$stmt_eliminar = $conn->prepare($sql_eliminar);
$stmt_eliminar->bind_param("i", $id_detalle);

if ($stmt_eliminar->execute()) {
    header("Location: carrito.php"); 
    exit();
} else {
    echo "Error al eliminar el producto del carrito.";
}
?>

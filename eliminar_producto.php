<?php
include 'conexion.php';
session_start(); 

// Verificar si el usuario está logueado y es administrador 
if (!isset($_SESSION['id_usuario'])) {
    header("Location: login.php");
    exit();
}


if (isset($_POST['id_producto'])) {
    $id_producto = intval($_POST['id_producto']);

    // Eliminar el producto de la base de datos
    $sql_delete = "DELETE FROM productos WHERE id_producto = ?";
    $stmt_delete = $conn->prepare($sql_delete);
    $stmt_delete->bind_param("i", $id_producto);

    if ($stmt_delete->execute()) {
        // Redirigir al dashboard 
        header("Location: dashboard_admin.php?mensaje=Producto eliminado con éxito");
        exit();
    } else {
        echo "<h1 class='text-danger'>Error al eliminar el producto</h1>";
        echo "<a href='dashboard_admin.php' class='btn btn-primary'>Volver al Dashboard</a>";
    }
} else {
    
    header("Location: dashboard_admin.php");
    exit();
}
?>

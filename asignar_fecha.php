<?php
include 'conexion.php';
session_start();

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $id_pedido = intval($_POST['id_pedido']);
    $fecha_entrega = $_POST['fecha_entrega'];

    $sql_update = "UPDATE pedidos SET fecha_entrega = ?, estado = 'enviado' WHERE id_pedido = ?";
    $stmt = $conn->prepare($sql_update);
    $stmt->bind_param("si", $fecha_entrega, $id_pedido);

    if ($stmt->execute()) {
        echo "<h1 class='text-center text-success'>Fecha de entrega asignada correctamente</h1>";
    } else {
        echo "<h1 class='text-center text-danger'>Error al asignar la fecha de entrega</h1>";
    }
    header("Location: dashboard_admin.php");
    exit();
}
?>

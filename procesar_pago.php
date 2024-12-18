<?php
include 'conexion.php';
session_start();

if (!isset($_SESSION['id_usuario'])) {
    header("Location: login.php");
    exit();
}

$id_usuario = $_SESSION['id_usuario'];
$id_pedido = intval($_POST['id_pedido']);

// Verificar que hay un pedido pendiente
$sql_pedido = "SELECT * FROM pedidos WHERE id_pedido = ? AND id_usuario = ? AND estado = 'pendiente'";
$stmt_pedido = $conn->prepare($sql_pedido);
$stmt_pedido->bind_param("ii", $id_pedido, $id_usuario);
$stmt_pedido->execute();
$result_pedido = $stmt_pedido->get_result();

if ($result_pedido->num_rows === 0) {
    echo "<h1>Error: No hay un pedido pendiente</h1>";
    exit();
}

// Obtener la dirección del usuario desde la tabla usuarios
$sql_direccion_usuario = "SELECT direccion FROM usuarios WHERE id_usuario = ?";
$stmt_direccion_usuario = $conn->prepare($sql_direccion_usuario);
$stmt_direccion_usuario->bind_param("i", $id_usuario);
$stmt_direccion_usuario->execute();
$result_direccion_usuario = $stmt_direccion_usuario->get_result();
$direccion_usuario = $result_direccion_usuario->fetch_assoc()['direccion'];

if (!$direccion_usuario) {
    echo "<h1>Error: Dirección del usuario no encontrada</h1>";
    exit();
}

// Actualizar el estado del pedido a "pagado", hacer visible y registrar la dirección
$sql_actualizar_pedido = "UPDATE pedidos SET estado = 'pagado', visible_admin = 1, direccion_entrega = ? WHERE id_pedido = ?";
$stmt_actualizar = $conn->prepare($sql_actualizar_pedido);
$stmt_actualizar->bind_param("si", $direccion_usuario, $id_pedido);

if ($stmt_actualizar->execute()) {
    echo "<h1>Pago realizado con éxito</h1>";
    echo "<a href='index.php' class='btn btn-primary'>Volver al Dashboard</a>";
} else {
    echo "<h1>Error al procesar el pago</h1>";
}

?>

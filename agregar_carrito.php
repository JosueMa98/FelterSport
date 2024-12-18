<?php
include 'conexion.php';

session_start(); 


if (!isset($_SESSION['id_usuario'])) {
    header("Location: login.php");
    exit();
}

// Verificar si se recibe el parámetro 'id_producto'
if (!isset($_GET['id_producto'])) {
    echo "<h1 class='text-center text-danger'>Producto no especificado</h1>";
    exit();
}

// Sanitizar y obtener el id del producto
$id_producto = intval($_GET['id_producto']);

// Validar si el producto existe y obtener su información
$sql_producto = "SELECT * FROM productos WHERE id_producto = ?";
$stmt_producto = $conn->prepare($sql_producto);
$stmt_producto->bind_param("i", $id_producto);
$stmt_producto->execute();
$result_producto = $stmt_producto->get_result();

if ($result_producto->num_rows === 0) {
    echo "<h1 class='text-center text-danger'>Producto no encontrado</h1>";
    exit();
}

$producto = $result_producto->fetch_assoc();

// Verificar si el usuario ya tiene un pedido activo
$id_usuario = $_SESSION['id_usuario'];
$sql_pedido = "SELECT * FROM pedidos WHERE id_usuario = ? AND estado = 'pendiente'";
$stmt_pedido = $conn->prepare($sql_pedido);
$stmt_pedido->bind_param("i", $id_usuario);
$stmt_pedido->execute();
$result_pedido = $stmt_pedido->get_result();

if ($result_pedido->num_rows > 0) {
    // Si ya hay un pedido pendiente, obtener su ID
    $pedido = $result_pedido->fetch_assoc();
    $id_pedido = $pedido['id_pedido'];
} else {
    // Si no hay pedido, crear uno nuevo
    $sql_nuevo_pedido = "INSERT INTO pedidos (id_usuario, fecha_pedido, total, direccion_entrega, estado, visible_admin) 
                         VALUES (?, NOW(), 0, '', 'pendiente', 0)";
    $stmt_nuevo_pedido = $conn->prepare($sql_nuevo_pedido);
    $stmt_nuevo_pedido->bind_param("i", $id_usuario);
    $stmt_nuevo_pedido->execute();

    $id_pedido = $stmt_nuevo_pedido->insert_id;
}

// Verificar si el producto ya está en el carrito 
$sql_detalle = "SELECT * FROM detalles_pedidos WHERE id_pedido = ? AND id_producto = ?";
$stmt_detalle = $conn->prepare($sql_detalle);
$stmt_detalle->bind_param("ii", $id_pedido, $id_producto);
$stmt_detalle->execute();
$result_detalle = $stmt_detalle->get_result();

if ($result_detalle->num_rows > 0) {
    // Si ya está en el carrito, incrementar la cantidad
    $detalle = $result_detalle->fetch_assoc();
    $nueva_cantidad = $detalle['cantidad'] + 1;

    $sql_actualizar = "UPDATE detalles_pedidos SET cantidad = ? WHERE id_detalle = ?";
    $stmt_actualizar = $conn->prepare($sql_actualizar);
    $stmt_actualizar->bind_param("ii", $nueva_cantidad, $detalle['id_detalle']);
    $stmt_actualizar->execute();
} else {
    // Si no está en el carrito, agregarlo
    $cantidad = 1;
    $precio_unitario = $producto['precio'];

    $sql_insertar_detalle = "INSERT INTO detalles_pedidos (id_pedido, id_producto, cantidad, precio_unitario) VALUES (?, ?, ?, ?)";
    $stmt_insertar_detalle = $conn->prepare($sql_insertar_detalle);
    $stmt_insertar_detalle->bind_param("iiid", $id_pedido, $id_producto, $cantidad, $precio_unitario);
    $stmt_insertar_detalle->execute();
}

// Redirigir al carrito con un mensaje de éxito
header("Location: carrito.php?mensaje=Producto añadido al carrito");
exit();
?>

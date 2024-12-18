<?php
include 'conexion.php';

session_start();

if (!isset($_SESSION['id_usuario'])) {
    header("Location: login.php");
    exit();
}

$id_usuario = $_SESSION['id_usuario'];

// Obtener la dirección del usuario
$sql_usuario = "SELECT direccion FROM usuarios WHERE id_usuario = ?";
$stmt_usuario = $conn->prepare($sql_usuario);
$stmt_usuario->bind_param("i", $id_usuario);
$stmt_usuario->execute();
$result_usuario = $stmt_usuario->get_result();
$usuario = $result_usuario->fetch_assoc();
$direccion = $usuario['direccion'];

// Obtener el pedido pendiente
$sql_pedido = "SELECT * FROM pedidos WHERE id_usuario = ? AND estado = 'pendiente'";
$stmt_pedido = $conn->prepare($sql_pedido);
$stmt_pedido->bind_param("i", $id_usuario);
$stmt_pedido->execute();
$result_pedido = $stmt_pedido->get_result();

if ($result_pedido->num_rows === 0) {
    echo "<h1 class='text-center text-danger'>No tienes productos en el carrito</h1>";
    exit();
}

$pedido = $result_pedido->fetch_assoc();
$id_pedido = $pedido['id_pedido'];

// Obtener los detalles del carrito
$sql_detalles = "SELECT dp.id_detalle, dp.cantidad, dp.precio_unitario, p.nombre_producto, p.imagen_url 
                 FROM detalles_pedidos dp
                 INNER JOIN productos p ON dp.id_producto = p.id_producto
                 WHERE dp.id_pedido = ?";
$stmt_detalles = $conn->prepare($sql_detalles);
$stmt_detalles->bind_param("i", $id_pedido);
$stmt_detalles->execute();
$result_detalles = $stmt_detalles->get_result();

$detalles_carrito = [];
$total = 0;

if ($result_detalles->num_rows > 0) {
    while ($detalle = $result_detalles->fetch_assoc()) {
        $total += $detalle['cantidad'] * $detalle['precio_unitario'];
        $detalles_carrito[] = $detalle;
    }
} else {
    echo "<h4 class='text-center text-warning'>Tu carrito está vacío</h4>";
    echo "<a href='index.php' class='btn btn-primary'>Seguir Comprando</a>";
    exit();
}

// Actualizar el total del pedido
$sql_update_total = "UPDATE pedidos SET total = ? WHERE id_pedido = ?";
$stmt_update_total = $conn->prepare($sql_update_total);
$stmt_update_total->bind_param("di", $total, $id_pedido);
$stmt_update_total->execute();
?>


<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Carrito - Felter Sport</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        /* Eliminar subrayado en los enlaces */
        a.text-white, .dropdown-menu a {
            text-decoration: none;
        }
        a.text-white:hover, .dropdown-menu a:hover {
            text-decoration: none;
            background-color: #007bff; /* Color de fondo al pasar el mouse */
            color: #fff; /* Color del texto al pasar el mouse */
        }
        /* Mostrar el menú desplegable al pasar el mouse */
        .dropdown:hover .dropdown-menu {
            display: block;
        }
    </style>
</head>
<body>
    <header class="bg-primary text-white py-3">
        <div class="container d-flex justify-content-between align-items-center">

            <div class="d-flex align-items-center">
                <img src="img/logo.webp" alt="Logo Felter Sport" class="me-2" style="height: 40px;"> 
                <h1 class="h3 mb-0">Felter Sport</h1>
            </div>
            
            <nav class="d-flex align-items-center">
                <a href="index.php" class="text-white me-3">Inicio</a>

                <div class="dropdown">
                    <a href="#" class="text-white me-3 dropdown-toggle" id="categoriasDropdown" data-bs-toggle="dropdown" aria-expanded="false">Categorías</a>
                    <ul class="dropdown-menu" aria-labelledby="categoriasDropdown">
                        <li><a class="dropdown-item" href="productos.php?categoria=gym">Gym</a></li>
                        <li><a class="dropdown-item" href="productos.php?categoria=box">Box</a></li>
                        <li><a class="dropdown-item" href="productos.php?categoria=natacion">Natación</a></li>
                        <li><a class="dropdown-item" href="productos.php?categoria=tenis">Tenis</a></li>
                        <li><a class="dropdown-item" href="productos.php?categoria=futbol">Fútbol</a></li>
                        <li><a class="dropdown-item" href="productos.php?categoria=beisbol">Beisbol</a></li>
                        <li><a class="dropdown-item" href="productos.php?categoria=basquetbol">Basquetbol</a></li>
                    </ul>
                </div>

                <a href="carrito.php" class="text-white me-3">Carrito</a>
                <?php if (isset($_SESSION['id_usuario'])): ?>
                    <a href="logout.php" class="text-white">Cerrar Sesión</a>
                <?php else: ?>
                    <a href="login.php" class="text-white">Iniciar Sesión</a>
                <?php endif; ?>
            </nav>
        </div>
    </header>

    <div class="container mt-5">
        <h2 class="text-center">Tu Carrito</h2>
        <div class="mb-3">
            <h5>Dirección de Entrega:</h5>
            <p><?php echo htmlspecialchars($direccion); ?></p>
        </div>

        <?php if (empty($detalles_carrito)) : ?>
            <h4 class="text-center text-warning">Tu carrito está vacío</h4>
        <?php else : ?>
            <table class="table mt-4">
                <thead>
                    <tr>
                        <th>Producto</th>
                        <th>Imagen</th>
                        <th>Cantidad</th>
                        <th>Precio Unitario</th>
                        <th>Total</th>
                        <th>Acciones</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($detalles_carrito as $detalle) : ?>
                    <tr>
                        <td><?php echo htmlspecialchars($detalle['nombre_producto']); ?></td>
                        <td><img src="<?php echo htmlspecialchars($detalle['imagen_url']); ?>" alt="<?php echo htmlspecialchars($detalle['nombre_producto']); ?>" style="height: 50px;"></td>
                        <td><?php echo htmlspecialchars($detalle['cantidad']); ?></td>
                        <td>$<?php echo htmlspecialchars(number_format($detalle['precio_unitario'], 2)); ?></td>
                        <td>$<?php echo htmlspecialchars(number_format($detalle['cantidad'] * $detalle['precio_unitario'], 2)); ?></td>
                        <td>
                            <a href="eliminar_carrito.php?id_detalle=<?php echo $detalle['id_detalle']; ?>" class="btn btn-danger btn-sm">Eliminar</a>
                        </td>
                    </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>

            <h3 class="text-end">Total: $<?php echo htmlspecialchars(number_format($total, 2)); ?></h3>

            <form action="simular_pago.php" method="POST" class="mt-4">
                <input type="hidden" name="id_pedido" value="<?php echo htmlspecialchars($id_pedido); ?>">
                <input type="hidden" name="total" value="<?php echo htmlspecialchars($total); ?>">
                <button type="submit" class="btn btn-success w-100">Finalizar Pedido</button>
            </form>
        <?php endif; ?>
    </div>

    <footer class="bg-dark text-white text-center py-3 mt-5">
        <p>Felter Sport &copy; 2024 - Todos los derechos reservados</p>
    </footer>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>

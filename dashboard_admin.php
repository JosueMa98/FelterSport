<?php
include 'conexion.php';
session_start(); 

// Obtener los pedidos pendientes 
$sql_pedidos = "SELECT * FROM pedidos WHERE visible_admin = 1";
$result_pedidos = $conn->query($sql_pedidos);


// Obtener todos los productos
$sql_productos = "SELECT * FROM productos";
$result_productos = $conn->query($sql_productos);



?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dashboard Admin - Felter Sport</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>
    <header class="bg-primary text-white py-3">
        <div class="container d-flex justify-content-between align-items-center">
            <div class="d-flex align-items-center">
                <img src="img/logo.webp" alt="Logo Felter Sport" class="me-2" style="height: 40px;">
                <h1 class="h3 mb-0">Felter Sport</h1>
            </div>
            <?php if (isset($_SESSION['id_usuario'])): ?>
                <a href="logout.php" class="text-white">Cerrar Sesión</a>
            <?php else: ?>
                <a href="login.php" class="text-white">Iniciar Sesión</a>
            <?php endif; ?>
        </div>
    </header>

    <div class="container mt-5">
       

        <!-- Gestión de Pedidos -->
        <section class="mt-4">
            <h1>Gestión de Pedidos</h1>
            <table class="table">
                <thead>
                    <tr>
                        <th>ID Pedido</th>
                        <th>Cliente</th>
                        <th>Estado</th>
                        <th>Total</th>
                        <th>Dirección</th>
                        <th>Fecha Entrega</th>
                        <th>Acciones</th>
                    </tr>
                </thead>
                <tbody>
                    <?php while ($pedido = $result_pedidos->fetch_assoc()) : ?>
                        <tr>
                            <td><?php echo $pedido['id_pedido']; ?></td>
                            <td><?php echo $pedido['id_usuario']; ?></td> 
                            <td><?php echo $pedido['estado']; ?></td>
                            <td>$<?php echo number_format($pedido['total'], 2); ?></td>
                            <td><?php echo htmlspecialchars($pedido['direccion_entrega']); ?></td>
                            <td><?php echo $pedido['fecha_entrega'] ? $pedido['fecha_entrega'] : 'Sin asignar'; ?></td>
                            <td>
                                <form action="asignar_fecha.php" method="POST" class="d-inline">
                                    <input type="hidden" name="id_pedido" value="<?php echo $pedido['id_pedido']; ?>">
                                    <input type="date" name="fecha_entrega" class="form-control mb-2" required>
                                    <button type="submit" class="btn btn-success btn-sm">Asignar Fecha</button>
                                </form>
                            </td>
                        </tr>
                    <?php endwhile; ?>
                </tbody>
            </table>
        </section>

        <!-- Gestión de Productos -->
        <section class="mt-4">
            <h2>Gestión de Productos</h2>
            <table class="table">
                <thead>
                    <tr>
                        <th>ID Producto</th>
                        <th>Nombre</th>
                        <th>Categoría</th>
                        <th>Descripción</th>
                        <th>Precio</th>
                        <th>Stock</th>
                        <th>Acciones</th>
                    </tr>
                </thead>
                <tbody>
                    <?php while ($producto = $result_productos->fetch_assoc()) : ?>
                        <tr>
                            <td><?php echo $producto['id_producto']; ?></td>
                            <td><?php echo htmlspecialchars($producto['nombre_producto']); ?></td>
                            <td><?php echo htmlspecialchars($producto['id_categoria']); ?></td>
                            <td><?php echo htmlspecialchars($producto['descripcion']); ?></td>
                            <td>$<?php echo number_format($producto['precio'], 2); ?></td>
                            <td><?php echo htmlspecialchars($producto['stock']); ?></td>
                            <td>
                                <form action="editar_producto.php" method="GET" class="d-inline">
                                    <input type="hidden" name="id_producto" value="<?php echo $producto['id_producto']; ?>">
                                    <button type="submit" class="btn btn-warning btn-sm">Editar</button>
                                </form>
                                <form action="eliminar_producto.php" method="POST" class="d-inline">
                                    <input type="hidden" name="id_producto" value="<?php echo $producto['id_producto']; ?>">
                                    <button type="submit" name="eliminar_producto" class="btn btn-danger btn-sm">Eliminar</button>
                                </form>
                            </td>
                        </tr>
                    <?php endwhile; ?>
                </tbody>
            </table>
            <a href="agregar_producto.php" class="btn btn-success">Agregar Nuevo Producto</a>
        </section>
    </div>
</body>
</html>

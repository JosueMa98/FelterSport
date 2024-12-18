<?php
include 'conexion.php';
session_start(); 
// Verificar si el usuario está logueado
if (isset($_SESSION['id_usuario'])) {
    $id_usuario = $_SESSION['id_usuario'];

    // Obtener la información del pedido más reciente del usuario con fecha de entrega
    $sql_pedido = "SELECT fecha_entrega FROM pedidos WHERE id_usuario = ? AND estado IN ('enviado', 'entregado') ORDER BY fecha_pedido DESC LIMIT 1";
    $stmt_pedido = $conn->prepare($sql_pedido);
    $stmt_pedido->bind_param("i", $id_usuario);
    $stmt_pedido->execute();
    $result_pedido = $stmt_pedido->get_result();
    $pedido = $result_pedido->fetch_assoc();
    $fecha_entrega = $pedido ? $pedido['fecha_entrega'] : null;
}
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dashboard - Felter Sport</title>
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
        <?php if (isset($_SESSION['nombre'])): ?>
            <h2 class="text-center">¡Bienvenido, <?php echo htmlspecialchars($_SESSION['nombre']); ?>!</h2>
        <?php else: ?>
            <h2 class="text-center">¡Bienvenido a Felter Sport!</h2>
        <?php endif; ?>
        <hr>

        <!-- Mostrar fecha de entrega si está asignada -->
        <?php if (isset($fecha_entrega) && $fecha_entrega): ?>
            <div class="alert alert-info text-center">
                Tu pedido llegará el: <strong><?php echo htmlspecialchars($fecha_entrega); ?></strong>
            </div>
        <?php endif; ?>

        <!-- Categorías Destacadas -->
        <section class="categorias my-5">
            <h3 class="text-center">Categorías Destacadas</h3>
            <div class="row text-center">
                <div class="col-md-4">
                    <a href="productos.php?categoria=futbol" class="text-decoration-none">
                        <img src="img/futbol.jpg" alt="Fútbol" class="img-fluid rounded">
                        <h4 class="mt-2">Fútbol</h4>
                    </a>
                </div>
                <div class="col-md-4">
                    <a href="productos.php?categoria=gym" class="text-decoration-none">
                        <img src="img/gym.webp" alt="Gym" class="img-fluid rounded">
                        <h4 class="mt-2">Gym</h4>
                    </a>
                </div>
                <div class="col-md-4">
                    <a href="productos.php?categoria=box" class="text-decoration-none">
                        <img src="img/box.jpeg" alt="Box" class="img-fluid rounded">
                        <h4 class="mt-2">Box</h4>
                    </a>
                </div>
            </div>
        </section>
    </div>
    <footer class="bg-dark text-white text-center py-3">
        <p>Felter Sport &copy; 2024 - Todos los derechos reservados</p>
    </footer>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>

<?php
include 'conexion.php';

session_start();

// Validar que el parámetro 'categoria' exista en la URL
if (!isset($_GET['categoria'])) {
    echo "<h1 class='text-center text-danger'>Categoría no especificada</h1>";
    exit();
}

// Sanitizar el parámetro 'categoria' recibido
$categoria = $_GET['categoria'];

// Obtener la información de la categoría desde la base de datos
$sql_categoria = "SELECT * FROM categorias WHERE nombre_categoria = ?";
$stmt_categoria = $conn->prepare($sql_categoria);
$stmt_categoria->bind_param("s", $categoria);
$stmt_categoria->execute();
$result_categoria = $stmt_categoria->get_result();

if ($result_categoria->num_rows == 0) {
    echo "<h1 class='text-center text-danger'>Categoría no encontrada</h1>";
    exit();
}

$categoria_datos = $result_categoria->fetch_assoc();
$id_categoria = $categoria_datos['id_categoria'];

// Obtener los productos asociados a esta categoría
$sql_productos = "SELECT * FROM productos WHERE id_categoria = ?";
$stmt_productos = $conn->prepare($sql_productos);
$stmt_productos->bind_param("i", $id_categoria);
$stmt_productos->execute();
$result_productos = $stmt_productos->get_result();

?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Productos - <?php echo htmlspecialchars($categoria_datos['nombre_categoria']); ?></title>
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
                <?php if (isset($_SESSION['id_usuario'])) : ?>
                    <a href="logout.php" class="text-white">Cerrar Sesión</a>
                <?php else : ?>
                    <a href="login.php" class="text-white">Iniciar Sesión</a>
                <?php endif; ?>
            </nav>
        </div>
    </header>

    <div class="container mt-5">
        <h2 class="text-center">Productos de <?php echo htmlspecialchars($categoria_datos['nombre_categoria']); ?></h2>
        <div class="row mt-4">
            <?php while ($producto = $result_productos->fetch_assoc()) : ?>
                <div class="col-md-4 mb-4">
                    <div class="card h-100">
                        <img src="<?php echo htmlspecialchars($producto['imagen_url']) ?: 'img/default.jpg'; ?>" class="card-img-top" alt="<?php echo htmlspecialchars($producto['nombre_producto']); ?>">
                        <div class="card-body">
                            <h5 class="card-title"><?php echo htmlspecialchars($producto['nombre_producto']); ?></h5>
                            <p class="card-text"><?php echo htmlspecialchars($producto['descripcion']); ?></p>
                            <p class="card-text fw-bold">Precio: $<?php echo htmlspecialchars($producto['precio']); ?></p>
                            <p class="card-text">Stock: <?php echo htmlspecialchars($producto['stock']); ?></p>
                        </div>
                        <div class="card-footer text-center">
                            <?php if (isset($_SESSION['id_usuario'])) : ?>
                                <a href="agregar_carrito.php?id_producto=<?php echo $producto['id_producto']; ?>" class="btn btn-primary">Añadir al Carrito</a>
                            <?php else : ?>
                                <a href="login.php" class="btn btn-primary">Inicia sesión para comprar</a>
                            <?php endif; ?>
                        </div>
                    </div>
                </div>
            <?php endwhile; ?>
        </div>
    </div>

    <footer class="bg-dark text-white text-center py-3">
        <p>Felter Sport &copy; 2024 - Todos los derechos reservados</p>
    </footer>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>

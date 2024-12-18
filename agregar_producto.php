<?php
include 'conexion.php';
session_start(); 

// Verificar si el formulario fue enviado
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $nombre = $_POST['nombre_producto'];
    $categoria = intval($_POST['id_categoria']);
    $descripcion = $_POST['descripcion'];
    $precio = floatval($_POST['precio']);
    $stock = intval($_POST['stock']);
    
    // Manejo de la imagen cargada
    if (isset($_FILES['imagen']) && $_FILES['imagen']['error'] === UPLOAD_ERR_OK) {
        $nombreArchivo = $_FILES['imagen']['name'];
        $rutaTemporal = $_FILES['imagen']['tmp_name'];
        $rutaDestino = "img/" . basename($nombreArchivo);

        // Mover el archivo cargado a la carpeta "img"
        if (move_uploaded_file($rutaTemporal, $rutaDestino)) {
            $imagen_url = $rutaDestino;
        } else {
            echo "Error al cargar la imagen.";
            exit();
        }
    } else {
        echo "Error en la carga de la imagen.";
        exit();
    }

    // Insertar el nuevo producto en la base de datos
    $sql_insert = "INSERT INTO productos (nombre_producto, id_categoria, descripcion, precio, stock, imagen_url) 
                   VALUES (?, ?, ?, ?, ?, ?)";
    $stmt_insert = $conn->prepare($sql_insert);
    $stmt_insert->bind_param("sisdss", $nombre, $categoria, $descripcion, $precio, $stock, $imagen_url);

    if ($stmt_insert->execute()) {
        header("Location: dashboard_admin.php"); // Redirigir al dashboard
        exit();
    } else {
        echo "Error al agregar el producto.";
    }
}
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Agregar Producto</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>
    <div class="container mt-5">
        <h2>Agregar Nuevo Producto</h2>
        <form action="" method="POST" enctype="multipart/form-data">
            <div class="mb-3">
                <label for="nombre_producto" class="form-label">Nombre del Producto</label>
                <input type="text" class="form-control" id="nombre_producto" name="nombre_producto" required>
            </div>
            <div class="mb-3">
                <label for="id_categoria" class="form-label">Categoría</label>
                <select class="form-select" id="id_categoria" name="id_categoria" required>
                    <?php
                    $sql_categorias = "SELECT * FROM categorias";
                    $result_categorias = $conn->query($sql_categorias);
                    while ($categoria = $result_categorias->fetch_assoc()) {
                        echo "<option value='{$categoria['id_categoria']}'>{$categoria['nombre_categoria']}</option>";
                    }
                    ?>
                </select>
            </div>
            <div class="mb-3">
                <label for="descripcion" class="form-label">Descripción</label>
                <textarea class="form-control" id="descripcion" name="descripcion" rows="3" required></textarea>
            </div>
            <div class="mb-3">
                <label for="precio" class="form-label">Precio</label>
                <input type="number" class="form-control" id="precio" name="precio" step="0.01" required>
            </div>
            <div class="mb-3">
                <label for="stock" class="form-label">Stock</label>
                <input type="number" class="form-control" id="stock" name="stock" required>
            </div>
            <div class="mb-3">
                <label for="imagen" class="form-label">Imagen del Producto</label>
                <input type="file" class="form-control" id="imagen" name="imagen" accept="image/*" required>
            </div>
            <button type="submit" class="btn btn-success">Agregar Producto</button>
            <a href="dashboard_admin.php" class="btn btn-secondary">Cancelar</a>
        </form>
    </div>
</body>
</html>

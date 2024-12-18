<?php
include 'conexion.php';
session_start(); 

// Verificar si se recibió un ID de producto
if (!isset($_GET['id_producto'])) {
    header("Location: dashboard_admin.php");
    exit();
}

$id_producto = intval($_GET['id_producto']);

// Obtener los datos del producto a editar
$sql_producto = "SELECT * FROM productos WHERE id_producto = ?";
$stmt_producto = $conn->prepare($sql_producto);
$stmt_producto->bind_param("i", $id_producto);
$stmt_producto->execute();
$result_producto = $stmt_producto->get_result();

if ($result_producto->num_rows === 0) {
    echo "Producto no encontrado.";
    exit();
}

$producto = $result_producto->fetch_assoc();

// Manejar la actualización del producto
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $nombre = $_POST['nombre_producto'];
    $categoria = intval($_POST['id_categoria']);
    $descripcion = $_POST['descripcion'];
    $precio = floatval($_POST['precio']);
    $stock = intval($_POST['stock']);
    $imagen_url = $_POST['imagen_url'];

    $sql_update = "UPDATE productos SET nombre_producto = ?, id_categoria = ?, descripcion = ?, precio = ?, stock = ?, imagen_url = ? 
                   WHERE id_producto = ?";
    $stmt_update = $conn->prepare($sql_update);
    $stmt_update->bind_param("sisdssi", $nombre, $categoria, $descripcion, $precio, $stock, $imagen_url, $id_producto);

    if ($stmt_update->execute()) {
        header("Location: dashboard_admin.php");
        exit();
    } else {
        echo "Error al actualizar el producto.";
    }
}
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Editar Producto</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>
    <div class="container mt-5">
        <h2>Editar Producto</h2>
        <form action="" method="POST">
            <div class="mb-3">
                <label for="nombre_producto" class="form-label">Nombre del Producto</label>
                <input type="text" class="form-control" id="nombre_producto" name="nombre_producto" value="<?php echo htmlspecialchars($producto['nombre_producto']); ?>" required>
            </div>
            <div class="mb-3">
                <label for="id_categoria" class="form-label">Categoría</label>
                <select class="form-select" id="id_categoria" name="id_categoria" required>
                    <?php
                    $sql_categorias = "SELECT * FROM categorias";
                    $result_categorias = $conn->query($sql_categorias);
                    while ($categoria = $result_categorias->fetch_assoc()) {
                        $selected = $categoria['id_categoria'] === $producto['id_categoria'] ? 'selected' : '';
                        echo "<option value='{$categoria['id_categoria']}' $selected>{$categoria['nombre_categoria']}</option>";
                    }
                    ?>
                </select>
            </div>
            <div class="mb-3">
                <label for="descripcion" class="form-label">Descripción</label>
                <textarea class="form-control" id="descripcion" name="descripcion" rows="3" required><?php echo htmlspecialchars($producto['descripcion']); ?></textarea>
            </div>
            <div class="mb-3">
                <label for="precio" class="form-label">Precio</label>
                <input type="number" class="form-control" id="precio" name="precio" step="0.01" value="<?php echo htmlspecialchars($producto['precio']); ?>" required>
            </div>
            <div class="mb-3">
                <label for="stock" class="form-label">Stock</label>
                <input type="number" class="form-control" id="stock" name="stock" value="<?php echo htmlspecialchars($producto['stock']); ?>" required>
            </div>
            <div class="mb-3">
                <label for="imagen_url" class="form-label">URL de la Imagen</label>
                <input type="text" class="form-control" id="imagen_url" name="imagen_url" value="<?php echo htmlspecialchars($producto['imagen_url']); ?>" required>
            </div>
            <button type="submit" class="btn btn-primary">Guardar Cambios</button>
            <a href="dashboard_admin.php" class="btn btn-secondary">Cancelar</a>
        </form>
    </div>
</body>
</html>

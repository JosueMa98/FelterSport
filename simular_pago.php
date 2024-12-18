<?php
session_start(); 

// Verificar si el usuario está logueado
if (!isset($_SESSION['id_usuario'])) {
    header("Location: login.php");
    exit();
}

// Obtener el total enviado desde el carrito
if (!isset($_POST['total']) || !isset($_POST['id_pedido'])) {
    echo "<h1>Error: Datos del pedido no encontrados</h1>";
    exit();
}

$total = floatval($_POST['total']); // Total real enviado desde el carrito
$id_pedido = intval($_POST['id_pedido']); // ID del pedido enviado desde el carrito
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Pago - Felter Sport</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>
    <header class="bg-primary text-white py-3">
        <div class="container">
            <h1 class="h3 text-center">Felter Sport - Pago</h1>
        </div>
    </header>

    <div class="container mt-5">
        <h2 class="text-center">Simulación de Pago</h2>
        <p class="text-center">Total a pagar: <strong>$<?php echo number_format($total, 2); ?></strong></p>

        <form action="procesar_pago.php" method="POST" class="mt-4">
            <input type="hidden" name="id_pedido" value="<?php echo htmlspecialchars($id_pedido); ?>">
            <input type="hidden" name="total" value="<?php echo htmlspecialchars($total); ?>">
            
            <div class="mb-3">
                <label for="numero_tarjeta" class="form-label">Número de Tarjeta</label>
                <input type="text" class="form-control" id="numero_tarjeta" name="numero_tarjeta" placeholder="1234 5678 9123 4567" maxlength="19" required>
            </div>
            <div class="mb-3">
                <label for="nombre_titular" class="form-label">Nombre del Titular</label>
                <input type="text" class="form-control" id="nombre_titular" name="nombre_titular" placeholder="Como aparece en la tarjeta" required>
            </div>
            <div class="mb-3">
                <label for="fecha_expiracion" class="form-label">Fecha de Expiración</label>
                <input type="text" class="form-control" id="fecha_expiracion" name="fecha_expiracion" placeholder="MM/AA" maxlength="5" required>
            </div>
            <div class="mb-3">
                <label for="cvv" class="form-label">CVV</label>
                <input type="text" class="form-control" id="cvv" name="cvv" placeholder="123" maxlength="3" required>
            </div>

            <button type="submit" class="btn btn-success w-100">Pagar</button>
        </form>
    </div>

    <footer class="bg-dark text-white text-center py-3 mt-5">
        <p>Felter Sport &copy; 2024 - Todos los derechos reservados</p>
    </footer>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>

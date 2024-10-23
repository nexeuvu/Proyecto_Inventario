<?php

require_once __DIR__ . '/../Inventario/config/database.php';
require_once __DIR__ . '/../Inventario/includes/functions.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $producto_id = $_POST['producto_id'] ?? '';
    $cantidad = $_POST['cantidad'] ?? 0;

    
    if (empty($producto_id)) {
        echo "Error: Debes seleccionar un producto.";
        exit;
    }

    
    $resultado = realizarVenta($producto_id, $cantidad);
    
    if ($resultado) {
        $mensaje = "Venta realizada con éxito.";
    } else {
        $mensaje = "Error al realizar la venta.";
    }
}
?>
<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Realizar Venta</title>
    <link rel="stylesheet" href="public/css/styles.css">
</head>

<body>
    <div class="container">
        <h1>Realizar Venta</h1>

        <?php if (isset($mensaje)): ?>
            <div class="<?php echo $resultado ? 'success' : 'error'; ?>">
                <?php echo $mensaje; ?>
            </div>
        <?php endif; ?>

        <form action="realizar_venta.php" method="post">
            <label for="producto_id">Seleccionar Producto:</label>
            <select id="producto_id" name="producto_id" required>
                <?php
                
                $productos = obtenerProductos();
                foreach ($productos as $producto) {
                    echo "<option value=\"{$producto['_id']}\">{$producto['nombre']}</option>";
                }
                ?>
            </select>

            <label for="cantidad">Cantidad:</label>
 <input type="number" id="cantidad" name="cantidad" min="1" required>

            <button type="submit" class="button">Realizar Venta</button>
        </form>

        <a href="index.php" class="button">Volver a la gestión de inventario</a>
    </div>
</body>

</html>
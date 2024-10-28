<?php

require_once __DIR__ . '/../Inventario2/config/database.php';
require_once __DIR__ . '/../Inventario2/includes/functions.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $producto_id = $_POST['producto_id'] ?? '';
    $cantidad = $_POST['cantidad'] ?? '';

    $producto = obtenerProductoPorId($producto_id);
    $precio = $producto['precio'];
    $total = $precio * $cantidad;


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
            <select id="producto_id" name="producto_id" required onchange="updatePrice()">
                <?php
                $productos = obtenerProductos();
                foreach ($productos as $producto) {
                    echo "<option value=\"{$producto['_id']}\" data-precio=\"{$producto['precio']}\">{$producto['nombre']} - Precio: {$producto['precio']}</option>";
                }
                ?>
            </select>

            <label for="cantidad">Cantidad:</label>
            <input type="number" id="cantidad" name="cantidad" min="1" required>

            <label for="total">Total:</label>
            <input type="text" id="total" name="total" value="0" readonly>

            <button type="submit" class="button">Realizar Venta</button>
        </form>

        <script>
            function updatePrice() {
                const select = document.getElementById('producto_id');
                const selectedOption = select.options[select.selectedIndex];
                const precio = selectedOption.getAttribute('data-precio');
                const cantidad = document.getElementById('cantidad').value;
                document.getElementById('total').value = (precio * cantidad).toFixed(2);
            }

            document.getElementById('cantidad').addEventListener('input', updatePrice);
        </script>

        <a href="index.php" class="button">Volver a la gestión de inventario</a>
    </div>
</body>

</html>
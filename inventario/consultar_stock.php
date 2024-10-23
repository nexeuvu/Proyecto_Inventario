<?php
require_once __DIR__ . '/includes/functions.php';

$productos = obtenerProductos();
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Consultar Stock</title>
    <link rel="stylesheet" href="public/css/styles.css">
</head>
<body>
    <div class="container">
        <h1>Consultar Stock</h1>
        <a href="generar_reporte.php" class="button">Generar Reporte de Productos Más Vendidos</a>
        <table>
            <tr>
                <th>Nombre</th>
                <th>Descripción</th>
                <th>Cantidad</th>
                <th>Acciones</th>
            </tr>
            <?php foreach ($productos as $producto): ?>
                <tr>
                    <td><?php echo htmlspecialchars($producto['nombre']); ?></td>
                    <td><?php echo htmlspecialchars($producto['descripcion']); ?></td>
                    <td><?php echo $producto['cantidad']; ?></td>
                    <td class="actions">
                        <a href="editar_inventario.php?id=<?php echo $producto['_id']; ?>" class="button">Editar</a>
                        <a href="index.php?accion=eliminar&id=<?php echo $producto['_id']; ?>" class="button" onclick="return confirm('¿Estás seguro de que quieres eliminar este producto?');">Eliminar</a>
                    </td>
                </tr>
            <?php endforeach; ?>
            <a href="index.php" class="button" method="POST">Volver a la lista de productos</a>
        </table>
    </div>
</body>
</html>
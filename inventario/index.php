<?php

require_once __DIR__ . '/includes/functions.php';
require_once __DIR__ . '/config/database.php';


if (isset($_GET['accion']) && $_GET['accion'] === 'eliminar' && isset($_GET['id'])) {
    $count = eliminarProducto($_GET['id']);
    $mensaje = $count > 0 ? "Producto eliminado con éxito." : "No se pudo eliminar el producto.";
}


$productos = obtenerProductos();
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Gestión de Inventario</title>
    <link rel="stylesheet" href="public/css/styles.css">
</head>
<body>
    <div class="container">
        <h1>Gestión de Inventario</h1>

        <?php if (isset($mensaje)): ?>
            <div class="<?php echo $count > 0 ? 'success' : 'error'; ?>">
                <?php echo $mensaje; ?>
            </div>
        <?php endif; ?>

        <a href="agregar_inventario.php" class="button">Agregar Nuevo Producto</a>
        <a href="generar_reporte.php" class="button">Generar Reporte de Productos Más Vendidos</a>
        <a href="consultar_stock.php" class="button">Consultar Stock</a>
        <a href="realizar_venta.php" class="button">Realizar Venta</a> <!-- Enlace a realizar_venta.php -->

        <h2>Lista de Productos</h2>
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
        </table>
    </div>
</body>
</html>
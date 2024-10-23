<?php
require_once __DIR__ . '/../inventario/includes/functions.php';


$mongoClient = new MongoDB\Client("mongodb+srv://nexeu:v6tQsSab1hne0a8w@cursosbd.m90ik.mongodb.net/?retryWrites=true&w=majority&appName=CursosBD");
$database = $mongoClient->selectDatabase('inventario');
$ventasCollection = $database->selectCollection('ventas');

$productosMasVendidos = obtenerProductosMasVendidos();
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Reporte de Productos Más Vendidos</title>
    <link rel="stylesheet" href="public/css/styles.css">
</head>
<body>
    <div class="container">
        <h1>Reporte de Productos Más Vendidos</h1>
        <table>
            <tr>
                <th>Nombre</th>
                <th>Descripción</th>
                <th>Cantidad Vendida</th>
            </tr>
            <?php foreach ($productosMasVendidos as $producto): ?>
                <tr>
                    <td><?php echo htmlspecialchars($producto['nombre']); ?></td>
                    <td><?php echo htmlspecialchars($producto['descripcion']); ?></td>
                    <td><?php echo isset($producto['cantidad']) ? $producto['cantidad'] : 0; ?></td>
                </tr>
            <?php endforeach; ?>
        </table>
        <a href="index.php" class="button">Volver a la lista de productos</a>
    </div>
</body>
</html>
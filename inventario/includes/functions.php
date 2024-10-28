<?php
require_once __DIR__ . '/../config/database.php';

function sanitizeInput($input) {
    return htmlspecialchars(strip_tags(trim($input)));
}

function agregarProducto($nombre, $descripcion, $cantidad, $precio) {
    global $productosCollection;
    $resultado = $productosCollection->insertOne([
        'nombre' => sanitizeInput($nombre),
        'descripcion' => sanitizeInput($descripcion),
        'cantidad' => (int)$cantidad,
        'precio' => (float)$precio
    ]);
    return $resultado->getInsertedId();
}

function obtenerProductos() {
    global $productosCollection;
    if ($productosCollection === null) {
        throw new Exception("La colección de productos no está inicializada.");
    }
    return $productosCollection->find();
}

function obtenerProductoPorId($id) {
    global $productosCollection;
    return $productosCollection->findOne(['_id' => new MongoDB\BSON\ObjectId($id)]);
}

function actualizarProducto($id, $nombre, $descripcion, $cantidad, $precio) {
    global $productosCollection;
    $resultado = $productosCollection->updateOne(
        ['_id' => new MongoDB\BSON\ObjectId($id)],
        ['$set' => [
            'nombre' => sanitizeInput($nombre),
            'descripcion' => sanitizeInput($descripcion),
            'cantidad' => (int)$cantidad,
            'precio' => (float)$precio
        ]]
    );
    return $resultado->getModifiedCount();
}

function eliminarProducto($id) {
    global $productosCollection;
    $resultado = $productosCollection->deleteOne(['_id' => new MongoDB\BSON\ObjectId($id)]);
    return $resultado->getDeletedCount();
}

function obtenerProductosMasVendidos() {
    global $productosCollection;
    return $productosCollection->find([], [
        'sort' => ['ventas' => -1],
        'limit' => 10000,
        'precio'  => 1

    ]);
}

function realizarVenta($producto_id, $cantidad) {
    global $productosCollection, $database;

   
    $producto = $productosCollection->findOne(['_id' => new MongoDB\BSON\ObjectId($producto_id)]);
    if (!$producto) {
        throw new Exception("Producto no encontrado.");
    }

    $cantidadStockAntesDeLaVenta = $producto['cantidad'];

    
    usleep(100000);

    
    $productoDespuesDelRetraso = $productosCollection->findOne(['_id' => new MongoDB\BSON\ObjectId($producto_id)]);
    $cantidadStockDespuesDelRetraso = $productoDespuesDelRetraso['cantidad'];

    
    if ($cantidadStockAntesDeLaVenta != $cantidadStockDespuesDelRetraso) {
        throw new Exception("No hay suficiente stock para realizar la venta.");
    }

    
    if ($cantidadStockDespuesDelRetraso >= $cantidad) {
        
        $productosCollection->updateOne(
            ['_id' => new MongoDB\BSON\ObjectId($producto_id)],
            ['$set' => ['cantidad' => $cantidadStockDespuesDelRetraso - $cantidad]]
        );

        
        $ventasCollection = $database->selectCollection('ventas');
        $resultadoVenta = $ventasCollection->insertOne([
            'producto_id' => $producto_id,
            'cantidad' => $cantidad,
            'fecha' => new MongoDB\BSON\UTCDateTime()
        ]);

        
        return $cantidad; 
    } else {
        throw new Exception("No hay suficiente stock para realizar la venta.");
    }
}
?>
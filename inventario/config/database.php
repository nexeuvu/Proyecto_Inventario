<?php

require_once __DIR__ . '/../vendor/autoload.php';

$mongoClient = new MongoDB\Client("mongodb+srv://nexeu:v6tQsSab1hne0a8w@cursosbd.m90ik.mongodb.net/?retryWrites=true&w=majority&appName=CursosBD");

$database = $mongoClient->selectDatabase('inventario');

$productosCollection = $database->selectCollection('productos');
?>
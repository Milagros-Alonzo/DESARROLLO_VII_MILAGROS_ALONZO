<?php
include 'config_sesion.php';

$id = intval($_GET['id']); // Asegurarse de que el ID sea un entero
$productos = [
    1 => ['nombre' => 'Producto 1', 'precio' => 10],
    2 => ['nombre' => 'Producto 2', 'precio' => 20],
    3 => ['nombre' => 'Producto 3', 'precio' => 30],
    4 => ['nombre' => 'Producto 4', 'precio' => 40],
    5 => ['nombre' => 'Producto 5', 'precio' => 50],
];

if (isset($productos[$id])) {
    if (!isset($_SESSION['carrito'])) {
        $_SESSION['carrito'] = [];
    }

    // Añadir producto al carrito o incrementar su cantidad
    if (isset($_SESSION['carrito'][$id])) {
        $_SESSION['carrito'][$id]['cantidad']++;
    } else {
        $_SESSION['carrito'][$id] = [
            'nombre' => $productos[$id]['nombre'],
            'precio' => $productos[$id]['precio'],
            'cantidad' => 1
        ];
    }
}

header('Location: ver_carrito.php');
?>

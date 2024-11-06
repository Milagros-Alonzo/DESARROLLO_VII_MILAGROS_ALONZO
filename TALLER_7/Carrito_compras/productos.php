<?php
include 'config_sesion.php';

$productos = [
    1 => ['nombre' => 'Producto 1', 'precio' => 10],
    2 => ['nombre' => 'Producto 2', 'precio' => 20],
    3 => ['nombre' => 'Producto 3', 'precio' => 30],
    4 => ['nombre' => 'Producto 4', 'precio' => 40],
    5 => ['nombre' => 'Producto 5', 'precio' => 50],
];
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Productos</title>
    <link rel="stylesheet" href="style.css">
</head>
<body>
    <div class="container">
        <h1>Lista de Productos</h1>
        <div>
            <?php foreach ($productos as $id => $producto): ?>
                <div class="producto">
                    <h5><?php echo htmlspecialchars($producto['nombre']); ?></h5>
                    <p>Precio: $<?php echo htmlspecialchars($producto['precio']); ?></p>
                    <a href="agregar_al_carrito.php?id=<?php echo $id; ?>">Añadir al carrito</a>
                </div>
            <?php endforeach; ?>
        </div>
        <a href="ver_carrito.php">Ver Carrito</a>
    </div>
</body>
</html>

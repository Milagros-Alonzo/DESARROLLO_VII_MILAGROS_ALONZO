<?php
require_once "config_mysqli.php";

// 1. Productos que tienen un precio mayor al promedio de su categoría
$sql = "SELECT p.nombre, p.precio, c.nombre as categoria,
        (SELECT AVG(precio) FROM productos WHERE categoria_id = p.categoria_id) as promedio_categoria
        FROM productos p
        JOIN categorias c ON p.categoria_id = c.id
        WHERE p.precio > (
            SELECT AVG(precio)
            FROM productos p2
            WHERE p2.categoria_id = p.categoria_id
        )";

$result = mysqli_query($conn, $sql);

if ($result) {
    echo "<h3>Productos con precio mayor al promedio de su categoría:</h3>";
    while ($row = mysqli_fetch_assoc($result)) {
        // Corrige el uso de variables para mostrar precios correctamente
        echo "Producto: {$row['nombre']}, Precio: $" . number_format($row['precio'], 2) . ", ";
        echo "Categoría: {$row['categoria']}, Promedio categoría: $" . number_format($row['promedio_categoria'], 2) . "<br>";
    }
    mysqli_free_result($result);
}

// 2. Clientes con compras superiores al promedio
$sql = "SELECT c.nombre, c.email,
        (SELECT SUM(total) FROM ventas WHERE cliente_id = c.id) as total_compras,
        (SELECT AVG(total) FROM ventas) as promedio_ventas
        FROM clientes c
        WHERE (
            SELECT SUM(total)
            FROM ventas
            WHERE cliente_id = c.id
        ) > (
            SELECT AVG(total)
            FROM ventas
        )";

$result = mysqli_query($conn, $sql);

if ($result) {
    echo "<h3>Clientes con compras superiores al promedio:</h3>";
    while ($row = mysqli_fetch_assoc($result)) {
        echo "Cliente: {$row['nombre']}, Total compras: $" . number_format($row['total_compras'], 2) . ", ";
        echo "Promedio general: $" . number_format($row['promedio_ventas'], 2) . "<br>";
    }
    mysqli_free_result($result);
}

mysqli_close($conn);
?>

   
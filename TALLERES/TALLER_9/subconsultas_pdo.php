<?php
require_once "config_pdo.php";

try {
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

    $stmt = $pdo->query($sql);
    
    echo "<h3>Productos con precio mayor al promedio de su categoría:</h3>";
    while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
        // Usar directamente las variables y formatearlas
        echo "Producto: {$row['nombre']}, Precio: $" . number_format($row['precio'], 2) . ", ";
        echo "Categoría: {$row['categoria']}, Promedio categoría: $" . number_format($row['promedio_categoria'], 2) . "<br>";
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

    $stmt = $pdo->query($sql);
    
    echo "<h3>Clientes con compras superiores al promedio:</h3>";
    while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
        echo "Cliente: {$row['nombre']}, Total compras: $" . number_format($row['total_compras'], 2) . ", ";
        echo "Promedio general: $" . number_format($row['promedio_ventas'], 2) . "<br>";
    }

}catch(PDOException $e) {
    echo "Error: " . $e->getMessage();
}

try{
//consulta uno de tarea
$sql = "SELECT p.nombre, p.precio, c.nombre AS categoria
FROM productos p
LEFT JOIN detalles_venta v ON p.id = v.producto_id
JOIN categorias c ON p.categoria_id = c.id
WHERE v.producto_id IS NULL";

$stmt = $pdo->query($sql);
echo "<h3>Producto no vendido:</h3>";
while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
    echo "Producto: {$row['nombre']}, Precio: $" . number_format($row['precio'], 2) . ", ";
    echo "Categoría: {$row['categoria']}<br>";
}

}catch(PDOException $e) {
echo "Error: " . $e->getMessage();
}

// consulta dos de la tarea 
try{
    $sql = "SELECT c.nombre AS categoria, 
    COUNT(p.id) AS numero_productos, 
    SUM(p.precio) AS valor_total_inventario
FROM categorias c
LEFT JOIN productos p ON c.id = p.categoria_id
GROUP BY c.nombre";

$stmt = $pdo->query($sql);
echo "<h3>Listar las categorías con el número de productos y el valor total del inventario:</h3>";
while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
    echo "Categoría: {$row['categoria']}, ";
    echo "Número de productos: {$row['numero_productos']}, ";
    echo "Valor total del inventario: $" . number_format($row['valor_total_inventario'], 2) . "<br>";
}

}catch(PDOException $e) {
echo "Error: " . $e->getMessage();
}
$pdo = null;
?>

     
<?php
require_once "config_pdo.php";
try {
    // 1. Productos con precio mayor al promedio de su categoría
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
    foreach ($stmt as $row) {
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
    foreach ($stmt as $row) {
        echo "Cliente: {$row['nombre']}, Total compras: $" . number_format($row['total_compras'], 2) . ", ";
        echo "Promedio general: $" . number_format($row['promedio_ventas'], 2) . "<br>";
    }

    // 3. Productos que nunca se han vendido
    $sql = "SELECT p.nombre, p.precio, c.nombre AS categoria
            FROM productos p
            LEFT JOIN detalles_venta v ON p.id = v.producto_id
            JOIN categorias c ON p.categoria_id = c.id
            WHERE v.producto_id IS NULL";

    $stmt = $pdo->query($sql);

    echo "<h3>Productos que nunca se han vendido:</h3>";
    if ($stmt->rowCount() > 0) {
        foreach ($stmt as $row) {
            echo "Producto: {$row['nombre']}, Precio: $" . number_format($row['precio'], 2) . ", ";
            echo "Categoría: {$row['categoria']}<br>";
        }
    } else {
        echo "No hay productos sin ventas registradas.<br>";
    }

    // 4. Categorías con el número de productos y valor total del inventario
    $sql = "SELECT c.nombre AS categoria, 
                   COUNT(p.id) AS numero_productos, 
                   COALESCE(SUM(p.precio * p.stock), 0) AS valor_inventario,
                   COALESCE(AVG(p.precio), 0) AS promedio_categoria
            FROM categorias c
            LEFT JOIN productos p ON c.id = p.categoria_id
            GROUP BY c.id";

    $stmt = $pdo->query($sql);

    echo "<h3>Categorías con el número de productos y valor total del inventario:</h3>";
    foreach ($stmt as $row) {
        echo "Categoría: " . $row['categoria'] . "<br>";
        echo "Número de productos: " . $row['numero_productos'] . "<br>";
        echo "Valor total del inventario: $" . number_format($row['valor_inventario'], 2) . "<br>";
        echo "Promedio de precio en la categoría: $" . number_format($row['promedio_categoria'], 2) . "<br><br>";
    }

    // 5. Clientes que han comprado todos los productos de una categoría específica
    $category_id = 1; // Reemplaza por el ID de la categoría que desees

    $sql = "SELECT c.nombre, c.email
            FROM clientes c
            WHERE NOT EXISTS (
                SELECT p.id
                FROM productos p
                WHERE p.categoria_id = :category_id
                AND p.id NOT IN (
                    SELECT dp.producto_id
                    FROM detalles_venta dp
                    JOIN ventas v ON dp.venta_id = v.id
                    WHERE v.cliente_id = c.id
                )
            )";

    $stmt = $pdo->prepare($sql);
    $stmt->execute(['category_id' => $category_id]);

    echo "<h3>Clientes que han comprado todos los productos de la categoría:</h3>";
    foreach ($stmt as $row) {
        echo "Cliente: {$row['nombre']}, Email: {$row['email']}<br>";
    }

    // 6. Calcular el porcentaje de ventas de cada producto respecto al total de ventas
    $sql = "SELECT p.nombre, SUM(dp.subtotal) AS total_producto, 
                   (SUM(dp.subtotal) / (SELECT SUM(total) FROM ventas)) * 100 AS porcentaje_ventas
            FROM detalles_venta dp
            JOIN productos p ON dp.producto_id = p.id
            GROUP BY p.id";

    $stmt = $pdo->query($sql);

    echo "<h3>Porcentaje de ventas de cada producto respecto al total de ventas:</h3>";
    foreach ($stmt as $row) {
        echo "Producto: {$row['nombre']}, Total ventas: $" . number_format($row['total_producto'], 2) . ", ";
        echo "Porcentaje de ventas: " . number_format($row['porcentaje_ventas'], 2) . "%<br>";
    }

} catch (PDOException $e) {
    echo "Error en la consulta: " . $e->getMessage();
}

$pdo = null; // Cerrar la conexión
?>
     
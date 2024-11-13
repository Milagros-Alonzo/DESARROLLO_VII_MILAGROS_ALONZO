
<?php
require_once "config_pdo.php";

function analizarConsulta($pdo, $sql) {
    try {
        // Ejecutar EXPLAIN
        $stmt = $pdo->prepare("EXPLAIN FORMAT=JSON " . $sql);
        $stmt->execute();
        $explain = $stmt->fetch(PDO::FETCH_ASSOC);

        echo "<h3>Análisis de la consulta:</h3>";
        echo "<pre>" . print_r(json_decode($explain['EXPLAIN'], true), true) . "</pre>";

        // Ejecutar la consulta y medir el tiempo
        $inicio = microtime(true);
        $stmt = $pdo->prepare($sql);
        $stmt->execute();
        $fin = microtime(true);

        echo "Tiempo de ejecución: " . number_format($fin - $inicio, 4) . " segundos<br>";
        echo "Filas afectadas: " . $stmt->rowCount() . "<br>";

    } catch (PDOException $e) {
        echo "Error: " . $e->getMessage();
    }
}

// Ejemplos de consultas para analizar
$consultas = [
    "Búsqueda por categoría" => "
        SELECT p.* 
        FROM productos p 
        WHERE p.categoria_id = 1
    ",
    "Búsqueda por rango de precios" => "
        SELECT p.* 
        FROM productos p 
        WHERE p.precio BETWEEN 100 AND 500
    ",
    "Ventas por período" => "
        SELECT v.*, c.nombre 
        FROM ventas v 
        JOIN clientes c ON v.cliente_id = c.id 
        WHERE v.fecha_venta BETWEEN '2023-01-01' AND '2023-12-31'
    ",
    "Búsqueda de texto completo" => "
        SELECT * 
        FROM productos 
        WHERE MATCH(nombre, descripcion) AGAINST('laptop' IN NATURAL LANGUAGE MODE)
    "
];

foreach ($consultas as $descripcion => $sql) {
    echo "<h2>$descripcion</h2>";
    analizarConsulta($pdo, $sql);
}

$pdo = null;
?>
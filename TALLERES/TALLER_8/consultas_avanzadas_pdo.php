<?php
require_once "config_pdo.php";

try {
    // 1. Mostrar las últimas 5 publicaciones con el nombre del autor y la fecha de publicación
    $sql = "SELECT p.titulo, u.nombre AS autor, p.fecha_publicacion 
            FROM publicaciones p 
            INNER JOIN usuarios u ON p.usuario_id = u.id 
            ORDER BY p.fecha_publicacion DESC 
            LIMIT 5";

    $stmt = $pdo->query($sql);

    echo "<h3>Últimas 5 publicaciones:</h3>";
    while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
        echo "Título: " . $row['titulo'] . ", Autor: " . $row['autor'] . ", Fecha: " . $row['fecha_publicacion'] . "<br>";
    }

    // 2. Listar los usuarios que no han realizado ninguna publicación
    $sql = "SELECT u.id, u.nombre 
            FROM usuarios u 
            LEFT JOIN publicaciones p ON u.id = p.usuario_id 
            WHERE p.id IS NULL";

    $stmt = $pdo->query($sql);

    echo "<h3>Usuarios sin publicaciones:</h3>";
    while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
        echo "Usuario: " . $row['nombre'] . "<br>";
    }

 // 3. Calcular el promedio de publicaciones por usuario
$sql = "SELECT COALESCE(AVG(num_publicaciones), 0) AS promedio 
FROM (SELECT COUNT(*) AS num_publicaciones 
      FROM publicaciones 
      GROUP BY usuario_id) AS subquery";

$stmt = $pdo->query($sql);
$row = $stmt->fetch(PDO::FETCH_ASSOC);

echo "<h3>Promedio de publicaciones por usuario:</h3>";
echo "Promedio: " . round($row['promedio'], 2);

    // 4. Encontrar la publicación más reciente de cada usuario
    $sql = "SELECT p.titulo, u.nombre AS autor, p.fecha_publicacion 
            FROM publicaciones p 
            INNER JOIN usuarios u ON p.usuario_id = u.id 
            WHERE p.fecha_publicacion = (SELECT MAX(fecha_publicacion) 
                                         FROM publicaciones 
                                         WHERE usuario_id = u.id)";

    $stmt = $pdo->query($sql);

    echo "<h3>Publicación más reciente de cada usuario:</h3>";
    while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
        echo "Título: " . $row['titulo'] . ", Autor: " . $row['autor'] . ", Fecha: " . $row['fecha_publicacion'] . "<br>";
    }

} catch(PDOException $e) {
    echo "Error: " . $e->getMessage();
}

$pdo = null;
?>
   
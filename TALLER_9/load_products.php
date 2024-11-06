<?php
require_once 'database_connection.php'; // Conexión a la base de datos

$page = isset($_GET['page']) ? (int)$_GET['page'] : 1;
$perPage = 10; // Define cuántos productos por página
$offset = ($page - 1) * $perPage;

// Consulta de productos
$stmt = $pdo->prepare("SELECT productos.*, categorias.nombre AS categoria 
                       FROM productos 
                       LEFT JOIN categorias ON productos.categoria_id = categorias.id 
                       ORDER BY productos.id ASC 
                       LIMIT :limit OFFSET :offset");
$stmt->bindValue(':limit', $perPage, PDO::PARAM_INT);
$stmt->bindValue(':offset', $offset, PDO::PARAM_INT);
$stmt->execute();
$products = $stmt->fetchAll(PDO::FETCH_ASSOC);

// Verifica si hay más productos
$hasMore = count($products) === $perPage;

// Envía la respuesta en JSON
echo json_encode(['products' => $products, 'has_more' => $hasMore]);

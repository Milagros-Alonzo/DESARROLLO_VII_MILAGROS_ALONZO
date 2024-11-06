<?php
require_once 'config.php';

// Listar todos los libros
function listarLibros($pdo) {
    $sql = "SELECT * FROM libros";
    $stmt = $pdo->query($sql);

    while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
        echo "Título: " . $row['titulo'] . ", Autor: " . $row['autor'] . "<br>";
    }
}

// Añadir un libro
function añadirLibro($pdo, $titulo, $autor, $isbn, $anio, $cantidad) {
    $sql = "INSERT INTO libros (titulo, autor, isbn, anio, cantidad) VALUES (:titulo, :autor, :isbn, :anio, :cantidad)";
    $stmt = $pdo->prepare($sql);
    $stmt->execute([
        ':titulo' => $titulo,
        ':autor' => $autor,
        ':isbn' => $isbn,
        ':anio' => $anio,
        ':cantidad' => $cantidad
    ]);
}
?>

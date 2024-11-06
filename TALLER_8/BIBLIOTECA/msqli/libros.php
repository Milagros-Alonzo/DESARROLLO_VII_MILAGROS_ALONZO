<?php
require_once 'config.php';

// Listar todos los libros
function listarLibros($conn) {
    $sql = "SELECT * FROM libros";
    $result = mysqli_query($conn, $sql);

    while ($row = mysqli_fetch_assoc($result)) {
        echo "Título: " . $row['titulo'] . ", Autor: " . $row['autor'] . "<br>";
    }
}

// Añadir un libro
function añadirLibro($conn, $titulo, $autor, $isbn, $anio, $cantidad) {
    $sql = "INSERT INTO libros (titulo, autor, isbn, anio_publicacion, cantidad_disponible) VALUES (?, ?, ?, ?, ?)";
    $stmt = mysqli_prepare($conn, $sql);
    mysqli_stmt_bind_param($stmt, "sssii", $titulo, $autor, $isbn, $anio, $cantidad);
    mysqli_stmt_execute($stmt);
}
?>

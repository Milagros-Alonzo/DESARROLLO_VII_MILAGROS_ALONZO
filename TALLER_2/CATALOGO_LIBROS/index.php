<?php
require_once 'includes/funciones.php';
include 'includes/header.php';

$libros = obtenerLibros();

echo '<h1>Catálogo de Libros</h1>';
echo '<div class="catalogo">';

foreach ($libros as $libro) {
    echo mostrarDetallesLibro($libro);
}

echo '</div>';

include 'includes/prac.php';

echo '</div>';
include 'includes/footer.php';
?>
<?php
$paginaActual = 'contacto'; // Cambia esto según el archivo
require_once 'plantillas/funciones.php';
$tituloPagina = obtenerTituloPagina($paginaActual);
include 'plantillas/encabezado.php';
?>

<h2>contacto</h2>
<p>Este es el contenido específico de la página de inicio.</p>

<?php
include 'plantillas/pie_pagina.php';
?>
<?php
function obtenerLibros() {
    return [
        [
            'titulo' => 'El Quijote',
            'autor' => 'Miguel de Cervantes',
            'anio_publicacion' => 1605,
            'genero' => 'Novela',
            'descripcion' => 'La historia del ingenioso hidalgo Don Quijote de la Mancha.'
        ],
        [
            'titulo' => 'Cien Años de Soledad',
            'autor' => 'Gabriel García Márquez',
            'anio_publicacion' => 1967,
            'genero' => 'Novela',
            'descripcion' => 'Una de las obras más significativas del realismo mágico.'
        ],
        [
            'titulo' => 'Moby Dick',
            'autor' => 'Herman Melville',
            'anio_publicacion' => 1851,
            'genero' => 'Aventura',
            'descripcion' => 'La narración épica de la caza del gran cachalote blanco.'
        ],
        [
            'titulo' => 'La Odisea',
            'autor' => 'Homero',
            'anio_publicacion' => 'c. siglo VIII a.C.',
            'genero' => 'Épica',
            'descripcion' => 'El legendario viaje de regreso a casa de Odiseo.'
        ],
        [
            'titulo' => 'Orgullo y Prejuicio',
            'autor' => 'Jane Austen',
            'anio_publicacion' => 1813,
            'genero' => 'Novela',
            'descripcion' => 'Un análisis social y romántico de las diferencias de clase.'
        ],
    ];
}

function mostrarDetallesLibro($libro) {
    return "
    <div class='libro'>
        <h2>{$libro['titulo']}</h2>
        <p><strong>Autor:</strong> {$libro['autor']}</p>
        <p><strong>Año de Publicación:</strong> {$libro['anio_publicacion']}</p>
        <p><strong>Género:</strong> {$libro['genero']}</p>
        <p>{$libro['descripcion']}</p>
    </div>
    ";
}
?>

<?php

// Sanitizar el campo 'nombre'
function sanitizarNombre($nombre) {
    return filter_var($nombre, FILTER_SANITIZE_SPECIAL_CHARS); // Evita caracteres peligrosos
}

function sanitizarEmail($email) {
    return filter_var(trim($email), FILTER_SANITIZE_EMAIL);
}

function sanitizarEdad($edad) {
    return filter_var($edad, FILTER_SANITIZE_NUMBER_INT);
}

function sanitizarSitioWeb($sitio_Web) {
    return filter_var(trim($sitio_Web), FILTER_SANITIZE_URL);
}

function sanitizarGenero($genero) {
    return filter_var(trim($genero), FILTER_SANITIZE_SPECIAL_CHARS);
}

function sanitizarIntereses($intereses) {
    return array_map(function($interes) {
        return filter_var(trim($interes), FILTER_SANITIZE_SPECIAL_CHARS);
    }, $intereses);
}

function sanitizarComentarios($comentarios) {
    return htmlspecialchars(trim($comentarios), ENT_QUOTES, 'UTF-8');
}

//agregar funcion de sanatizacion
function sanitizarFechaNacimiento($fechaNacimiento) {
    return filter_var($fechaNacimiento, FILTER_SANITIZE_SPECIAL_CHARS);
}
?>
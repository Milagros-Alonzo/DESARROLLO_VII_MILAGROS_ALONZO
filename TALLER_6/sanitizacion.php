<?php

// Sanitizar el campo 'nombre'
function sanitizarNombre($nombre) {
    return filter_var($nombre, FILTER_SANITIZE_SPECIAL_CHARS); // Evita caracteres peligrosos
}

function sanitizarEmail($email) {
    return filter_var(trim($email), FILTER_SANITIZE_EMAIL);
}

//agregar funcion de sanatizacion
function sanitizarFechaNacimiento($fechaNacimiento) {
    return filter_var($fechaNacimiento, FILTER_SANITIZE_SPECIAL_CHARS);
}

function sanitizarSitioWeb($sitioWeb) {
    return filter_var(trim($sitioWeb), FILTER_SANITIZE_URL);
}

function sanitizarGenero($genero) {
    return filter_var(trim($genero), FILTER_SANITIZE_SPECIAL_CHARS);
}

function sanitizarIntereses($intereses) {
    return array_map(function($interes) {
        return filter_var(trim($interes), FILTER_SANITIZE_SPECIAL_CHARS);
    }, $intereses);//S
}

function sanitizarComentarios($comentarios) {
    return htmlspecialchars(trim($comentarios), ENT_QUOTES, 'UTF-8');
}

?>
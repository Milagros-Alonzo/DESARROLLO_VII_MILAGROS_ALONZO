<?php 
session_start([
    'cookie_lifetime' => 86400, // Tiempo de vida de la cookie de sesión (24 horas)
    'cookie_secure' => true, // Solo enviar cookies por HTTPS
    'cookie_httponly' => true, // Evitar acceso a la cookie desde JavaScript
    'cookie_samesite' => 'Strict', // Protección contra ataques CSRF
]);

?>
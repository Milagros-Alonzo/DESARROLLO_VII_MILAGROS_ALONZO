<?php
if(isset($_COOKIE['usuario'])) {
    echo "Bienvenido, " . htmlspecialchars($_COOKIE['usuario']) . "!";
} else {
    echo "No se ha encontrado la cookie 'usuario'.";
}
?>
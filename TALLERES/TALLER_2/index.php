
<?php
// Tu código PHP irá aquí
$nombre = "Juan";
$edad = 25;

// Concatenación usando el operador .
$presentacion1 = "Hola, mi nombre es " . $nombre . " y tengo " . $edad . " años.";

// Concatenación dentro de comillas dobles
$presentacion2 = "Hola, mi nombre es $nombre y tengo $edad años.";

// Definición de una constante
define("SALUDO", "¡Bienvenido!");

// Concatenación con constante
$mensaje = SALUDO . " " . $nombre;

echo $presentacion1 . "<br>";
echo $presentacion2 . "<br>";
echo $mensaje . "<br>";

?>
                        

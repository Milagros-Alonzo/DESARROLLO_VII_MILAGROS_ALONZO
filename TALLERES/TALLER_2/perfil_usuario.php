<?php
$nombre_completo = "Milagros Alonzo";
$edad = 21;
$correo = "alonzomilagros24@gmail.com";
$telefono = 69727247;

//creacion de constante 
define("OCUPACION", "Estudiante")

//impresiones 
echo "Mi nombre es $nombre_completo<br>";

print "Tengo $edad años<br>";

echo "mi correo electronico es $correo<br>"

print "Mi numero de telefono es $telefono <br>";


// Usando printf (permite formateo)
printf("Me llamo %s y tengo %d años<br>", $nombre_completo, $edad);

printf("Mi correo es  %s y mi telefono es %d <br>", $correo, $telefono);

// Usando var_dump (útil para debugging)
var_dump(OCUPACION);
var_dump($nombre_completo);
var_dump($edad);
var_dump($correo)
var_dump($telefono)
?>

<?php
// Ejemplo básico de strtolower()
$textoMixto = "HoLa MuNdO";
$textoMinusculas = strtolower($textoMixto);
echo "Texto original: $textoMixto</br>";
echo "Texto en minúsculas: $textoMinusculas</br>";

// Ejemplo con una frase
$frase = "PHP Es Un LenGuAjE De PrOgRaMaCiÓn";
$fraseMinusculas = strtolower($frase);
echo "</br>Frase original: $frase</br>";
echo "Frase en minúsculas: $fraseMinusculas</br>";

// Ejercicio: Convierte tu nombre completo a minúsculas
$tuNombre = "MILAGROS MASSIEL ALONZO MARISCAL";
$tuNombreMinusculas = strtolower($tuNombre);
echo "</br>Tu nombre original: $tuNombre</br>";
echo "Tu nombre en minúsculas: $tuNombreMinusculas</br>";

// Bonus: Comparación de cadenas sin distinción de mayúsculas y minúsculas
function compararSinMayusculas($cadena1, $cadena2) {
    return strtolower($cadena1) === strtolower($cadena2);
}

$palabra1 = "PHP";
$palabra2 = "php";
echo "</br>¿'$palabra1' y '$palabra2' son iguales? " . 
    (compararSinMayusculas($palabra1, $palabra2) ? "Sí" : "No") . "</br>";

// Extra: Convertir un array de strings a minúsculas
$lenguajes = ["PHP", "JAVA", "PYTHON", "JavaScript"];
$lenguajesMinusculas = array_map('strtolower', $lenguajes);
echo "</br>Lenguajes originales:</br>";
print_r($lenguajes);
echo "Lenguajes en minúsculas:</br>";
print_r($lenguajesMinusculas);

// Desafío: Crea una función que convierta a minúsculas solo la primera letra de cada palabra
function primerLetraMinuscula($frase) {
    $palabras = explode(" ", $frase);
    $palabrasModificadas = array_map(function($palabra) {
        return strtolower(substr($palabra, 0, 1)) . substr($palabra, 1);
    }, $palabras);
    return implode(" ", $palabrasModificadas);
}

$fraseOriginal = "ESTA ES UNA FRASE DE PRUEBA";
$fraseModificada = primerLetraMinuscula($fraseOriginal);
echo "</br>Frase original: $fraseOriginal</br>";
echo "Frase modificada: $fraseModificada</br>";
?>
      


<?php
// Ejemplo básico de trim()
$textoConEspacios = "   Hola, mundo!   ";
$textoLimpio = trim($textoConEspacios);
echo "Texto original: '$textoConEspacios'
";
echo "Texto limpio: '$textoLimpio'
";

// Ejemplo con caracteres específicos
$textoConCaracteres = "...Hola, mundo!...";
$textoSinPuntos = trim($textoConCaracteres, ".");
echo "
Texto con puntos: '$textoConCaracteres'
";
echo "Texto sin puntos: '$textoSinPuntos'
";

// Ejercicio: Limpia el siguiente texto eliminando espacios y guiones bajos al inicio y al final
$textoParaLimpiar = "___   Mi nombre es Juan   ___";
$textoLimpiado = trim($textoParaLimpiar, " _");
echo "
Texto original para limpiar: '$textoParaLimpiar'
";
echo "Texto limpiado: '$textoLimpiado'
";

// Bonus: Uso de ltrim() y rtrim()
$textoIzquierda = "   Izquierda  ";
$textoDerecha = "  Derecha   ";
echo "
Trim izquierdo: '" . ltrim($textoIzquierda) . "'
";
echo "Trim derecho: '" . rtrim($textoDerecha) . "'
";

// Extra: Limpieza de un array de strings
$arrayConEspacios = [
    "   Primer elemento   ",
    "  Segundo elemento  ",
    " Tercer elemento "
];
$arrayLimpio = array_map('trim', $arrayConEspacios);
echo "
Array original:
";
print_r($arrayConEspacios);
echo "Array limpio:
";
print_r($arrayLimpio);

// Desafío: Crea una función que limpie una cadena de caracteres no deseados al inicio y al final
function limpiarCadena($cadena, $caracteresNoDeseados = " 	

") {
    return trim($cadena, $caracteresNoDeseados);
}

$cadenaSucia = "	
Hola, esto es una prueba!@#@";
$cadenaLimpia = limpiarCadena($cadenaSucia, " 	

@#");
echo "
Cadena sucia: '$cadenaSucia'
";
echo "Cadena limpia: '$cadenaLimpia'
";
?>
      


<?php
// Función simple sin parámetros
function saludar() {
    echo "Hola, bienvenido a PHP!<br>";
}

// Función con parámetros
function saludarPersona($nombre) {
    echo "Hola, $nombre!<br>";
}

// Función con parámetros por defecto
function presentar($nombre, $edad = 25) {
    echo "$nombre tiene $edad años.<br>";
}

// Función que retorna un valor
function sumar($a, $b) {
    return $a + $b;
}

// Función con parámetros por referencia
function incrementar(&$numero) {
    $numero++;
}

// Llamadas a las funciones
saludar();
saludarPersona("Juan");
presentar("María");
presentar("Carlos", 30);
echo "La suma de 5 y 3 es: " . sumar(5, 3) . "<br>";

$x = 5;
incrementar($x);
echo "El valor de x después de incrementar es: $x<br>";

// Función con número variable de argumentos
function sumarTodos(...$numeros) {
    return array_sum($numeros);
}

echo "La suma de 1, 2, 3, 4 es: " . sumarTodos(1, 2, 3, 4) . "<br>";

// Función anónima
$multiplicar = function($a, $b) {
    return $a * $b;
};

echo "5 x 3 = " . $multiplicar(5, 3) . "<br>";

?>
            


<?php
echo "<h2>Operadores de Asignación</h2>";

$x = 10;
echo "Valor inicial de x: $x<br>";

$x += 5;  // Equivalente a: $x = $x + 5
echo "Después de x += 5: $x<br>";

$x -= 3;  // Equivalente a: $x = $x - 3
echo "Después de x -= 3: $x<br>";

$x *= 2;  // Equivalente a: $x = $x * 2
echo "Después de x *= 2: $x<br>";

$x /= 4;  // Equivalente a: $x = $x / 4
echo "Después de x /= 4: $x<br>";

$x %= 3;  // Equivalente a: $x = $x % 3
echo "Después de x %= 3: $x<br>";

// Operador de asignación con concatenación
$str = "Hola";
$str .= " Mundo";  // Equivalente a: $str = $str . " Mundo"
echo "Concatenación con .=: $str<br>";

// Operador de asignación con exponenciación (PHP 5.6+)
$y = 2;
$y **= 3;  // Equivalente a: $y = $y ** 3
echo "Después de y **= 3: $y<br>";

// Operador de fusión de null (PHP 7+)
$z = null;
$z ??= 5;  // Asigna 5 a $z solo si $z es null
echo "Después de z ??= 5: $z<br>";

// Demostración de asignación por referencia
$a = 1;
$b = &$a;  // $b es una referencia a $a
$b = 2;    // Cambia tanto $a como $b
echo "a: $a, b: $b<br>";
?>
    

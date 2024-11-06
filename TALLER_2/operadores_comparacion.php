
<?php
echo "<h2>Operadores de Comparación</h2>";

$a = 5;
$b = '5';
$c = 10;

echo "Variables: a = $a (integer), b = '$b' (string), c = $c (integer)<br><br>";

echo "Igual (==): ";
var_dump($a == $b);
echo "<br>";

echo "Idéntico (===): ";
var_dump($a === $b);
echo "<br>";

echo "Diferente (!=): ";
var_dump($a != $c);
echo "<br>";

echo "No idéntico (!==): ";
var_dump($a !== $b);
echo "<br>";

echo "Menor que (<): ";
var_dump($a < $c);
echo "<br>";

echo "Mayor que (>): ";
var_dump($a > $c);
echo "<br>";

echo "Menor o igual que (<=): ";
var_dump($a <= $b);
echo "<br>";

echo "Mayor o igual que (>=): ";
var_dump($a >= $c);
echo "<br>";

// Operador de nave espacial (PHP 7+)
echo "Operador de nave espacial (<=>): ";
var_dump($a <=> $c);
echo "<br>";

// Operador de fusión de null (PHP 7+)
$d = null;
$e = $d ?? 'valor por defecto';
echo "Operador de fusión de null (??): $e<br>";

?>
    
							


<?php
echo "<h2>Operadores Lógicos</h2>";

$verdadero = true;
$falso = false;

echo "Variables: verdadero = " . var_export($verdadero, true) . ", falso = " . var_export($falso, true) . "<br><br>";

// Operador AND (&&)
echo "AND (&&):<br>";
echo "verdadero && verdadero = " . var_export($verdadero && $verdadero, true) . "<br>";
echo "verdadero && falso = " . var_export($verdadero && $falso, true) . "<br>";
echo "falso && falso = " . var_export($falso && $falso, true) . "<br><br>";

// Operador OR (||)
echo "OR (||):<br>";
echo "verdadero || verdadero = " . var_export($verdadero || $verdadero, true) . "<br>";
echo "verdadero || falso = " . var_export($verdadero || $falso, true) . "<br>";
echo "falso || falso = " . var_export($falso || $falso, true) . "<br><br>";

// Operador NOT (!)
echo "NOT (!):<br>";
echo "!verdadero = " . var_export(!$verdadero, true) . "<br>";
echo "!falso = " . var_export(!$falso, true) . "<br><br>";

// Operador XOR
echo "XOR:<br>";
echo "verdadero XOR verdadero = " . var_export($verdadero xor $verdadero, true) . "<br>";
echo "verdadero XOR falso = " . var_export($verdadero xor $falso, true) . "<br>";
echo "falso XOR falso = " . var_export($falso xor $falso, true) . "<br><br>";

// Ejemplo práctico
$edad = 25;
$tieneLicencia = true;

$puedeConducir = ($edad >= 18) && $tieneLicencia;
echo "Ejemplo práctico:<br>";
echo "Edad: $edad, Tiene licencia: " . var_export($tieneLicencia, true) . "<br>";
echo "¿Puede conducir? " . var_export($puedeConducir, true) . "<br><br>";

// Demostración de cortocircuito
echo "Demostración de cortocircuito:<br>";
$x = false;
$y = true;
$result = $x && $y; // $y no se evalúa porque $x es falso
echo "false && true = " . var_export($result, true) . " (y no se evalúa)<br>";

$result = $x || $y; // $y se evalúa porque $x es falso
echo "false || true = " . var_export($result, true) . " (y se evalúa)<br>";
?>
    

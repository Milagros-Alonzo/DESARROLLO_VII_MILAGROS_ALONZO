
<?php
echo "<h2>Bucle for</h2>";

// Ejemplo básico de bucle for
echo "Contando del 1 al 5:<br>";
for ($i = 1; $i <= 5; $i++) {
    echo "$i ";
}
echo "<br><br>";

// Bucle for con paso diferente
echo "Números pares del 2 al 10:<br>";
for ($i = 2; $i <= 10; $i += 2) {
    echo "$i ";
}
echo "<br><br>";

// Bucle for decreciente
echo "Cuenta regresiva del 5 al 1:<br>";
for ($i = 5; $i >= 1; $i--) {
    echo "$i ";
}
echo "<br><br>";

// Bucle for con múltiples expresiones
echo "Usando múltiples variables en el bucle:<br>";
for ($i = 0, $j = 5; $i < 5; $i++, $j--) {
    echo "i: $i, j: $j<br>";
}
echo "<br>";

// Bucle for para iterar sobre un array
$frutas = ["manzana", "banana", "naranja", "uva", "pera"];
echo "Lista de frutas:<br>";
for ($i = 0; $i < count($frutas); $i++) {
    echo ($i + 1) . ". " . $frutas[$i] . "<br>";
}
?>
            
							

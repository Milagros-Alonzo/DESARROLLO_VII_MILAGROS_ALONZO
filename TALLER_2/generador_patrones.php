<?php
// Patrón de triángulo rectángulo con asteriscos usando un bucle for
for ($i = 1; $i <= 5; $i++) {
    for ($j = 1; $j <= $i; $j++) {
        echo "*";
    }
    echo "<br>";
}

echo "<br>"; 

// Secuencia de números impares del 1 al 20 usando un bucle while
$numero = 1;
while ($numero <= 20) {
    if ($numero % 2 != 0) {
        echo $numero . " ";
    }
    $numero++;
}

echo "<br><br>"; 

$contador = 10;
do {
    if ($contador != 5) {
        echo $contador . " ";
    }
    $contador--;
} while ($contador >= 1);
?>

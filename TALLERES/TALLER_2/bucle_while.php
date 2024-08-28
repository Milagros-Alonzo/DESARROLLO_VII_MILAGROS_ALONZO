
<?php
echo "<h2>Bucle while</h2>";

// Ejemplo básico de bucle while
$contador = 1;
echo "Contando del 1 al 5 con while:<br>";
while ($contador <= 5) {
    echo "$contador ";
    $contador++;
}
echo "<br><br>";

// Bucle while con condición compleja
$numero = 20;
echo "Dividiendo $numero por 2 hasta que sea menor que 1:<br>";
while ($numero >= 1) {
    echo "$numero ";
    $numero /= 2;
}
echo "<br><br>";

// Uso de break en un bucle while
$i = 0;
echo "Usando break para salir del bucle:<br>";
while (true) {
    if ($i >= 5) {
        break;
    }
    echo "$i ";
    $i++;
}
echo "<br><br>";

// Uso de continue en un bucle while
$j = 0;
echo "Números impares menores que 10 usando continue:<br>";
while ($j < 10) {
    $j++;
    if ($j % 2 == 0) {
        continue;
    }
    echo "$j ";
}
echo "<br><br>";

// Ejemplo de bucle while para leer un archivo (simulado)
$lineas = ["Línea 1", "Línea 2", "Línea 3", "Línea 4", "Línea 5"];
$indice = 0;
echo "Leyendo líneas de un archivo (simulado):<br>";
while (isset($lineas[$indice])) {
    echo $lineas[$indice] . "<br>";
    $indice++;
}
?>
            
							

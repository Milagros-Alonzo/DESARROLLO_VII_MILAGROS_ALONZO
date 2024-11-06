
<?php
echo "<h2>Bucle do-while</h2>";

// Ejemplo básico de bucle do-while
$contador = 1;
echo "Contando del 1 al 5 con do-while:<br>";
do {
    echo "$contador ";
    $contador++;
} while ($contador <= 5);
echo "<br><br>";

// Ejemplo de do-while que se ejecuta solo una vez
$numero = 10;
echo "Ejemplo con condición falsa desde el inicio:<br>";
do {
    echo "Este mensaje se imprimirá una vez aunque la condición sea falsa.<br>";
} while ($numero < 5);
echo "<br>";

// Uso de do-while para validar entrada de usuario (simulado)
$entrada = "";
$intentos = 0;
echo "Simulación de validación de entrada de usuario:<br>";
do {
    $intentos++;
    // Simulamos la entrada del usuario alternando entre valores válidos e inválidos
    $entrada = ($intentos % 2 == 0) ? "válido" : "inválido";
    echo "Intento $intentos: Entrada $entrada<br>";
} while ($entrada != "válido" && $intentos < 5);

if ($entrada == "válido") {
    echo "Entrada válida recibida.<br>";
} else {
    echo "Número máximo de intentos alcanzado.<br>";
}
echo "<br>";

// Ejemplo de do-while con break
echo "Generando números aleatorios hasta obtener un 5:<br>";
do {
    $random = rand(1, 10);
    echo "$random ";
    if ($random == 5) {
        break;
    }
} while (true);
echo "<br>Se encontró el 5, fin del bucle.<br>";
?>
    
							

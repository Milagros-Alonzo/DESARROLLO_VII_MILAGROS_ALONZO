
<?php
// Ejemplo básico de round()
$numero = 3.14159;
echo "Número original: $numero</br>";
echo "Redondeado: " . round($numero) . "</br>";

// Redondeo con precisión específica
echo "Redondeado a 2 decimales: " . round($numero, 2) . "</br>";
echo "Redondeado a 4 decimales: " . round($numero, 4) . "</br>";

// Redondeo de números negativos
$negativo = -5.7;
echo "</br>Número negativo: $negativo</br>";
echo "Redondeado: " . round($negativo) . "</br>";

// Ejercicio: Calcular el promedio de calificaciones y redondear
$calificaciones = [85.5, 92.3, 78.8, 89.9, 95.2];
$promedio = array_sum($calificaciones) / count($calificaciones);
echo "</br>Promedio de calificaciones: $promedio</br>";
echo "Promedio redondeado: " . round($promedio, 1) . "</br>";

// Bonus: Usar diferentes modos de redondeo
$numero = 5.5;
echo "</br>Número: $numero</br>";
echo "Redondeo normal: " . round($numero) . "</br>";
echo "Redondeo hacia abajo: " . round($numero, 0, PHP_ROUND_HALF_DOWN) . "</br>";
echo "Redondeo hacia arriba: " . round($numero, 0, PHP_ROUND_HALF_UP) . "</br>";
echo "Redondeo hacia par: " . round($numero, 0, PHP_ROUND_HALF_EVEN) . "</br>";
echo "Redondeo hacia impar: " . round($numero, 0, PHP_ROUND_HALF_ODD) . "</br>";

// Extra: Función para redondear precios
function redondearPrecio($precio) {
    return round($precio * 20) / 20;
}

$precios = [9.99, 10.49, 20.05, 5.75];
echo "</br>Precios originales y redondeados:</br>";
foreach ($precios as $precio) {
    echo "Original: $precio, Redondeado: " . redondearPrecio($precio) . "</br>";
}

// Desafío: Crear una función de redondeo personalizada
function redondeoPersonalizado($numero, $incremento = 0.5) {
    return round($numero / $incremento) * $incremento;
}

$valores = [3.2, 3.8, 4.3, 4.7];
echo "</br>Redondeo personalizado (incremento de 0.5):</br>";
foreach ($valores as $valor) {
    echo "Original: $valor, Redondeado: " . redondeoPersonalizado($valor) . "</br>";
}

// Ejemplo adicional: Redondeo en cálculos financieros
$cantidad = 10/3; // Esto resulta en un número periódico
echo "</br>División de 10/3:</br>";
echo "Resultado exacto: " . $cantidad . "</br>";
echo "Redondeado a 2 decimales (para moneda): " . round($cantidad, 2) . "</br>";
echo "Redondeado a 4 decimales (para cálculos más precisos): " . round($cantidad, 4) . "</br>";
?>
      

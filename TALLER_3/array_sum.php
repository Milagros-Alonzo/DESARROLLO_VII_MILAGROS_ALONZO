
<?php
// Ejemplo básico de array_sum()
$numeros = [1, 2, 3, 4, 5];
$suma = array_sum($numeros);
echo "La suma de " . implode(", ", $numeros) . " es: $suma</br>";

// Suma de números decimales
$decimales = [1.5, 2.3, 3.7, 4.1, 5.8];
$sumaDecimales = array_sum($decimales);
echo "</br>La suma de los decimales es: " . round($sumaDecimales, 2) . "</br>";

// Ejercicio: Calcular el total de ventas
$ventas = [
    "Lunes" => 100.50,
    "Martes" => 200.75,
    "Miércoles" => 50.25,
    "Jueves" => 300.00,
    "Viernes" => 250.50
];
$totalVentas = array_sum($ventas);
echo "</br>Total de ventas de la semana: $" . number_format($totalVentas, 2) . "</br>";

// Bonus: Calcular el promedio de calificaciones
$calificaciones = [85, 92, 78, 95, 88];
$promedio = array_sum($calificaciones) / count($calificaciones);
echo "</br>Calificaciones: " . implode(", ", $calificaciones);
echo "</br>Promedio de calificaciones: " . round($promedio, 2) . "</br>";

// Extra: Suma de valores en un array multidimensional
$gastosMensuales = [
    "Enero" => ["Comida" => 300, "Transporte" => 100, "Entretenimiento" => 150],
    "Febrero" => ["Comida" => 280, "Transporte" => 90, "Entretenimiento" => 120],
    "Marzo" => ["Comida" => 310, "Transporte" => 110, "Entretenimiento" => 140]
];

$totalGastos = array_sum(array_map('array_sum', $gastosMensuales));
echo "</br>Total de gastos en el trimestre: $" . number_format($totalGastos, 2) . "</br>";

// Desafío: Función para sumar solo valores pares
function sumaPares($array) {
    return array_sum(array_filter($array, function($num) {
        return $num % 2 == 0;
    }));
}

$numeros = [1, 2, 3, 4, 5, 6, 7, 8, 9, 10];
echo "</br>Números: " . implode(", ", $numeros);
echo "</br>Suma de números pares: " . sumaPares($numeros) . "</br>";

// Ejemplo adicional: Cálculo de impuestos
$productos = [
    ["nombre" => "Laptop", "precio" => 1000, "impuesto" => 0.16],
    ["nombre" => "Teléfono", "precio" => 500, "impuesto" => 0.10],
    ["nombre" => "Tablet", "precio" => 300, "impuesto" => 0.08]
];

$totalImpuestos = array_sum(array_map(function($producto) {
    return $producto['precio'] * $producto['impuesto'];
}, $productos));

echo "</br>Total de impuestos a pagar: $" . number_format($totalImpuestos, 2) . "</br>";
?>
      

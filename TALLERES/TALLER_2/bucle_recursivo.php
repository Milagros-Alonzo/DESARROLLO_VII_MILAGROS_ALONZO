
<?php
echo "<h2>Bucles Recursivos</h2>";

// Ejemplo 1: Factorial de un número
function factorial($n) {
    if ($n <= 1) {
        return 1;
    } else {
        return $n * factorial($n - 1);
    }
}

$numero = 5;
echo "Factorial de $numero es: " . factorial($numero) . "<br><br>";

// Ejemplo 2: Secuencia de Fibonacci
function fibonacci($n) {
    if ($n <= 1) {
        return $n;
    } else {
        return fibonacci($n - 1) + fibonacci($n - 2);
    }
}

echo "Los primeros 10 números de la secuencia de Fibonacci son: ";
for ($i = 0; $i < 10; $i++) {
    echo fibonacci($i) . " ";
}
echo "<br><br>";

// Ejemplo 3: Recorrido recursivo de un array multidimensional
$menu = [
    'Inicio' => [],
    'Productos' => [
        'Electrónicos' => [
            'Teléfonos' => [],
            'Tablets' => [],
            'Laptops' => []
        ],
        'Ropa' => [
            'Hombre' => [],
            'Mujer' => [],
            'Niños' => []
        ]
    ],
    'Acerca de' => [],
    'Contacto' => []
];

function imprimirMenu($menu, $nivel = 0) {
    foreach ($menu as $item => $subitems) {
        echo str_repeat('--', $nivel) . $item . "<br>";
        if (!empty($subitems)) {
            imprimirMenu($subitems, $nivel + 1);
        }
    }
}

echo "Estructura del menú:<br>";
imprimirMenu($menu);
echo "<br>";

// Ejemplo 4: Cálculo del máximo común divisor (MCD)
function mcd($a, $b) {
    if ($b == 0) {
        return $a;
    } else {
        return mcd($b, $a % $b);
    }
}

$num1 = 48;
$num2 = 18;
echo "El MCD de $num1 y $num2 es: " . mcd($num1, $num2) . "<br>";

?>
    
							

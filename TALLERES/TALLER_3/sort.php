
<?php
// Ejemplo básico de sort()
$numeros = [5, 2, 8, 1, 9];
echo "Array original: " . implode(", ", $numeros) . "</br>";
sort($numeros);
echo "Array ordenado: " . implode(", ", $numeros) . "</br>";

// Ordenar strings
$frutas = ["naranja", "manzana", "plátano", "uva"];
echo "</br>Frutas originales: " . implode(", ", $frutas) . "</br>";
sort($frutas);
echo "Frutas ordenadas: " . implode(", ", $frutas) . "</br>";

// Ejercicio: Ordenar calificaciones de estudiantes
$calificaciones = [
    "Juan" => 85,
    "María" => 92,
    "Carlos" => 78,
    "Ana" => 95
];
echo "</br>Calificaciones originales:</br>";
print_r($calificaciones);

asort($calificaciones);  // Ordena por valor manteniendo la asociación de índices
echo "Calificaciones ordenadas por nota:</br>";
print_r($calificaciones);

ksort($calificaciones);  // Ordena por clave (nombre del estudiante)
echo "Calificaciones ordenadas por nombre:</br>";
print_r($calificaciones);

// Bonus: Ordenar en orden descendente
$numeros = [5, 2, 8, 1, 9];
rsort($numeros);
echo "</br>Números en orden descendente: " . implode(", ", $numeros) . "</br>";

// Extra: Ordenar array multidimensional
$estudiantes = [
    ["nombre" => "Juan", "edad" => 20, "promedio" => 8.5],
    ["nombre" => "María", "edad" => 22, "promedio" => 9.2],
    ["nombre" => "Carlos", "edad" => 19, "promedio" => 7.8],
    ["nombre" => "Ana", "edad" => 21, "promedio" => 9.5]
];

// Ordenar por promedio
usort($estudiantes, function($a, $b) {
    return $b['promedio'] <=> $a['promedio'];
});

echo "</br>Estudiantes ordenados por promedio (descendente):</br>";
foreach ($estudiantes as $estudiante) {
    echo "{$estudiante['nombre']}: {$estudiante['promedio']}</br>";
}

// Desafío: Implementar ordenamiento personalizado
function ordenarPorLongitud($a, $b) {
    return strlen($b) - strlen($a);
}

$palabras = ["PHP", "JavaScript", "Python", "Java", "C++", "Ruby"];
usort($palabras, 'ordenarPorLongitud');
echo "</br>Palabras ordenadas por longitud (descendente):</br>";
print_r($palabras);

// Ejemplo adicional: Ordenar preservando claves
$datos = [
    "z" => "Último",
    "a" => "Primero",
    "m" => "Medio"
];

ksort($datos);  // Ordena por clave
echo "</br>Datos ordenados por clave:</br>";
print_r($datos);

arsort($datos);  // Ordena por valor en orden descendente
echo "Datos ordenados por valor (descendente):</br>";
print_r($datos);
?>
      

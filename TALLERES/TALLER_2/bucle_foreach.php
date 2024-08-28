
<?php
echo "<h2>Bucle foreach</h2>";

// Ejemplo básico con un array indexado
$frutas = ["manzana", "banana", "naranja", "uva", "pera"];
echo "Lista de frutas:<br>";
foreach ($frutas as $fruta) {
    echo "$fruta <br>";
}
echo "<br>";

// Ejemplo con un array asociativo
$persona = [
    "nombre" => "Juan",
    "edad" => 30,
    "ciudad" => "Madrid",
    "profesion" => "Desarrollador"
];
echo "Información de la persona:<br>";
foreach ($persona as $clave => $valor) {
    echo "$clave: $valor<br>";
}
echo "<br>";

// Ejemplo con un array multidimensional
$estudiantes = [
    ["nombre" => "Ana", "notas" => [85, 92, 78]],
    ["nombre" => "Luis", "notas" => [90, 87, 93]],
    ["nombre" => "Carlos", "notas" => [76, 88, 82]]
];
echo "Notas de los estudiantes:<br>";
foreach ($estudiantes as $estudiante) {
    echo "Nombre: " . $estudiante["nombre"] . "<br>";
    echo "Notas: ";
    foreach ($estudiante["notas"] as $nota) {
        echo "$nota ";
    }
    echo "<br><br>";
}

// Ejemplo de modificación de elementos del array
$numeros = [1, 2, 3, 4, 5];
echo "Números originales: " . implode(", ", $numeros) . "<br>";
foreach ($numeros as &$numero) {
    $numero *= 2;
}
unset($numero); // Desvincula la referencia
echo "Números duplicados: " . implode(", ", $numeros) . "<br><br>";

// Ejemplo con break y continue
$datos = [1, 2, "tres", 4, "cinco", 6, 7, "ocho", 9];
echo "Procesando datos hasta encontrar el primer string:<br>";
foreach ($datos as $item) {
    if (is_string($item)) {
        echo "Primer string encontrado: $item<br>";
        break;
    }
    echo "$item ";
}
echo "<br>Mostrando solo números:<br>";
foreach ($datos as $item) {
    if (!is_numeric($item)) {
        continue;
    }
    echo "$item ";
}
?>
    

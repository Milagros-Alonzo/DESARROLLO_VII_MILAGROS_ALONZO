
<?php
// Ejemplo de uso de count()
$frutas = ["Manzana", "Naranja", "Plátano", "Uva", "Pera"];
$numFrutas = count($frutas);

echo "Array de frutas:
";
print_r($frutas);
echo "Número de frutas: $numFrutas
";

// Ejercicio: Crea un array con los nombres de tus 5 canciones favoritas
// y usa count() para mostrar cuántas canciones hay en tu lista
$misCanciones = ["supereroi", "unice quel filo", "el bambino que contaba la stela", "dont love in the dark", "bongiorno vita", "solo"]; // Reemplaza esto con tu array de canciones
$numCanciones = count($misCanciones);

echo "
Número de canciones en mi lista: $numCanciones
";

// Bonus: Usa count() con un array multidimensional
$playlist = [
    "Rock" => ["Bohemian Rhapsody", "Stairway to Heaven"],
    "Pop" => ["Thriller", "Billie Jean", "Beat It"],
    "Jazz" => ["Take Five", "So What"]
];

$totalCanciones = 0;
foreach ($playlist as $genero => $canciones) {
    $numCancionesGenero = count($canciones);
    $totalCanciones += $numCancionesGenero;
    echo "Canciones de $genero: $numCancionesGenero
";
}

echo "Total de canciones en la playlist: $totalCanciones
";
?>
      

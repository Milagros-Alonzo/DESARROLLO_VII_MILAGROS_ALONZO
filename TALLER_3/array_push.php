
<?php
// Ejemplo de uso de array_push()
$frutas = ["Manzana", "Naranja", "Plátano"];
echo "Array original de frutas:
";
print_r($frutas);

array_push($frutas, "Uva", "Pera");
echo "
Array de frutas después de array_push():
";
print_r($frutas);

// Ejercicio: Crea un array con los nombres de 3 de tus amigos
// y usa array_push() para añadir 2 amigos más
$misAmigos = ["Ana", "Brayan", "Ram"]; // Reemplaza esto con tu array de amigos
array_push($misAmigos, "Javier", "Maria"); // Reemplaza las comillas vacías con los nombres de tus amigos

echo "
Mi lista de amigos:
";
print_r($misAmigos);

// Bonus: Usa array_push() con un array de arrays
$playlist = [
    ["Bohemian Rhapsody", "Queen"],
    ["Imagine", "John Lennon"]
];
array_push($playlist, ["Billie Jean", "Michael Jackson"], ["Like a Rolling Stone", "Bob Dylan"]);

echo "
Mi playlist:
";
foreach ($playlist as $cancion) {
    echo "- {$cancion[0]} por {$cancion[1]}
";
}
?>
      



<?php
// Ejemplo de uso de json_encode() con un array simple
$frutas = ["manzana", "banana", "naranja"];
$jsonFrutas = json_encode($frutas);
echo "Array de frutas en JSON:
$jsonFrutas
";

// Ejemplo con un array asociativo
$persona = [
    "nombre" => "Juan",
    "edad" => 30,
    "ciudad" => "Madrid"
];
$jsonPersona = json_encode($persona);
echo "
Array asociativo de persona en JSON:
$jsonPersona
";

// Ejercicio: Crea un array con información sobre tu película favorita
// (título, director, año, actores principales) y conviértelo a JSON
$peliculaFavorita = [
    "titulo" => "juegos del hambre",
    "director" => "ni idea",
    "año" => 2010,
    "actores" => ["jannifer", "Chris algo", "nose"]
];
$jsonPelicula = json_encode($peliculaFavorita);
echo "
Información de tu película favorita en JSON:
$jsonPelicula
";

// Bonus: Usa json_encode() con un objeto de clase personalizada
class Libro {
    public $titulo;
    public $autor;
    public $año;
    
    public function __construct($titulo, $autor, $año) {
        $this->titulo = $titulo;
        $this->autor = $autor;
        $this->año = $año;
    }
}

$miLibro = new Libro("Cien años de soledad", "Gabriel García Márquez", 1967);
$jsonLibro = json_encode($miLibro);
echo "
Objeto Libro en JSON:
$jsonLibro
";

// Extra: Uso de opciones en json_encode()
$datosConCaracteresEspeciales = [
    "nombre" => "María José",
    "descripción" => "Le gusta el café y el té"
];
$jsonConOpciones = json_encode($datosConCaracteresEspeciales, JSON_UNESCAPED_UNICODE | JSON_PRETTY_PRINT);
echo "
JSON con opciones (caracteres Unicode y formato bonito):
$jsonConOpciones
";
?>
      

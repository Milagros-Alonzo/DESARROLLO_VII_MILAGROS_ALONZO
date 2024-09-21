<?php
class Libro {
    public $titulo;
    public $autor;
    public $anioPublicacion;

    public function __construct($titulo, $autor, $anioPublicacion) {
        $this->titulo = $titulo;
        $this->autor = $autor;
        $this->anioPublicacion = $anioPublicacion;
    }

    public function obtenerInformacion() {
        return "'{$this->titulo}' por {$this->autor}, publicado en {$this->anioPublicacion}";
    }
}

// Ejemplo de uso
$miLibro = new Libro("Cien años de soledad", "Gabriel García Márquez", 1967);
echo $miLibro->obtenerInformacion();
        
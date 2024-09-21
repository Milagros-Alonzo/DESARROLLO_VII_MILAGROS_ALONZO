<?php
class Libro {
    private $titulo;
    private $autor;
    private $anioPublicacion;

    public function __construct($titulo, $autor, $anioPublicacion) {
        $this->setTitulo($titulo);
        $this->setAutor($autor);
        $this->setAnioPublicacion($anioPublicacion);
    }

    public function getTitulo() {
        return $this->titulo;
    }

    public function setTitulo($titulo) {
        $this->titulo = trim($titulo);
    }

    public function getAutor() {
        return $this->autor;
    }

    public function setAutor($autor) {
        $this->autor = trim($autor);
    }

    public function getAnioPublicacion() {
        return $this->anioPublicacion;
    }

    public function setAnioPublicacion($anio) {
        $this->anioPublicacion = intval($anio);
    }

    public function obtenerInformacion() {
        return "'{$this->getTitulo()}' por {$this->getAutor()}, publicado en {$this->getAnioPublicacion()}";
    }
}

// Ejemplo de uso
$miLibro = new Libro("  El Quijote  ", "Miguel de Cervantes", "1605");
echo $miLibro->obtenerInformacion();
echo "\nTítulo: " . $miLibro->getTitulo();
        
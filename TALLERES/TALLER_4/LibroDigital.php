<?php
require_once 'Libro.php';

class LibroDigital extends Libro {
    private $formatoArchivo;
    private $tamanoMB;

    public function __construct($titulo, $autor, $anioPublicacion, $formatoArchivo, $tamanoMB) {
        parent::__construct($titulo, $autor, $anioPublicacion);
        $this->formatoArchivo = $formatoArchivo;
        $this->tamanoMB = $tamanoMB;
    }

    public function obtenerInformacion() {
        return parent::obtenerInformacion() . ", Formato: {$this->formatoArchivo}, Tamaño: {$this->tamanoMB}MB";
    }
}

// Ejemplo de uso
$libroDigital = new LibroDigital("1984", "George Orwell", 1949, "PDF", 2.5);
echo $libroDigital->obtenerInformacion();
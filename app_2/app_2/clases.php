<?php
 interface Prestable{
  public function obtenerDetallesPrestamo(): string;
}
abstract class RecursoBiblioteca {
    public $id;
    public $titulo;
    public $autor;
    public $anioPublicacion;
    public $estado;
    public $fechaAdquisicion;
    public $tipo;

    public function __construct($datos) {
        foreach ($datos as $key => $value) {
            if (property_exists($this, $key)) {
                $this->$key = $value;
            }
        }
    }
}
    class libro extends RecursoBiblioteca{

    }
    class Revista extends RecursoBiblioteca{

    }
    class DVD extends RecursoBiblioteca{

    }


// Implementar las clases Libro, Revista y DVD aquí

class GestorBiblioteca {
    private $recursos = [];

    public function cargarRecursos() {
        $json = file_get_contents('biblioteca.json');
        $data = json_decode($json, true);
        
        foreach ($data as $recursoData) {
            $recurso = new RecursoBiblioteca($recursoData['Tipo']);
            $this->recursos[] = $recurso;
            switch($recursoData){
                case 'LIBRO':
                    $recurso = new Libro($recursoData);

                case 'Revista':
                        $recurso = new Revista($recursoData);

                 case 'DVD':
                     $recurso = new DVD($recursoData);
                     // $recurso = new $recursoData($recursoData); otra forma de hacerlo, probarlo despues 
            }
        }
        
        
        return $this->recursos;
    }

    // Implementar los demás métodos aquí

    public function agregarRecurso(RecursoBiblioteca $recurso) {
        
    }
}
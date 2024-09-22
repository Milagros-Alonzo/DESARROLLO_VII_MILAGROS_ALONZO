<?php
require_once 'Empleado.php';

class Gerente extends Empleado {
    private $departamento;
    private $bono;

    public function __construct($nombre, $idEmpleado, $salarioBase, $departamento) {
        parent::__construct($nombre, $idEmpleado, $salarioBase);
        $this->departamento = $departamento;
        $this->bono = 0; // Inicialmente sin bono
    }

    // Getter y Setter para departamento
    public function getDepartamento() {
        return $this->departamento;
    }

    public function setDepartamento($departamento) {
        $this->departamento = $departamento;
    }

    // Método para asignar bono
    public function asignarBono($bono) {
        $this->bono = $bono;
    }

    // Obtener salario total con bono
    public function getSalarioTotal() {
        return $this->salarioBase + $this->bono;
    }
}
?>

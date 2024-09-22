<?php
require_once 'Empleado.php';
require_once 'Evaluable.php';

class Gerente extends Empleado implements Evaluable {
    private $departamento;
    private $bono;

    public function __construct($nombre, $idEmpleado, $salarioBase, $departamento) {
        parent::__construct($nombre, $idEmpleado, $salarioBase);
        $this->departamento = $departamento;
        $this->bono = 0;
    }

    // Método de la interfaz Evaluable
    public function evaluarDesempenio() {
        // Lógica de evaluación para Gerente (simple ejemplo)
        return "Evaluación de desempeño del Gerente $this->nombre: Excelente gestión del departamento $this->departamento.";
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

<?php
require_once 'Gerente.php';
require_once 'Desarrollador.php';

class Empresa {
    private $empleados = [];

    // Agregar empleados (Gerentes o Desarrolladores)
    public function agregarEmpleado(Empleado $empleado) {
        $this->empleados[] = $empleado;
    }

    // Listar todos los empleados
    public function listarEmpleados() {
        foreach ($this->empleados as $empleado) {
            echo "Empleado: " . $empleado->getNombre() . " - ID: " . $empleado->getIdEmpleado() . "\n";
        }
    }

    // Calcular la nómina total
    public function calcularNominaTotal() {
        $nominaTotal = 0;
        foreach ($this->empleados as $empleado) {
            if ($empleado instanceof Gerente) {
                $nominaTotal += $empleado->getSalarioTotal();
            } elseif ($empleado instanceof Desarrollador) {
                $nominaTotal += $empleado->getSalarioBase();
            }
        }
        return $nominaTotal;
    }

    // Evaluar desempeño de todos los empleados que sean evaluables
    public function evaluarDesempenio() {
        foreach ($this->empleados as $empleado) {
            if ($empleado instanceof Evaluable) {
                echo $empleado->evaluarDesempenio() . "\n";
            }
        }
    }
}
?>

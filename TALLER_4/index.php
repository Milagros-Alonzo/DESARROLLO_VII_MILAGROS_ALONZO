<?php
require_once 'Empresa.php';

// Crear una instancia de la empresa
$miEmpresa = new Empresa();

// Crear empleados (Gerentes y Desarrolladores)
$gerente1 = new Gerente("Alice", 1, 5000, "Ventas");
$desarrollador1 = new Desarrollador("Bob", 2, 3000, "PHP", "Senior");
$desarrollador2 = new Desarrollador("Charlie", 3, 3500, "JavaScript", "Junior");

// Asignar bonos
$gerente1->asignarBono(1000);

// Agregar empleados a la empresa
$miEmpresa->agregarEmpleado($gerente1);
$miEmpresa->agregarEmpleado($desarrollador1);
$miEmpresa->agregarEmpleado($desarrollador2);

// Listar empleados
echo "Lista de empleados:\n";
$miEmpresa->listarEmpleados();

// Calcular y mostrar la nómina total
echo "\nNómina total: " . $miEmpresa->calcularNominaTotal() . "\n";

// Evaluar el desempeño de todos los empleados evaluables
echo "\nEvaluación de desempeño:\n";
$miEmpresa->evaluarDesempenio();
?>

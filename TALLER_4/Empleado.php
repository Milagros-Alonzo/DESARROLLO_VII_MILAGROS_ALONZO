<?php
class Empleado{
    protected $nombre;
    protected $idEmpleado;
    protected $salarioBase;

    public function __construct($nombre, $idEmpleado, $salarioBase){
        $this->setNombre($nombre);
        $this->setIdEmpleado($idEmpleado);
        $this->setSalarioBase($salarioBase);
    }

    public function getNombre(){
        return $this->nombre;
    }
    public function setNombre($nombre) {
        $this->nombre = trim($nombre);
    }
    public function getIdEmpleado(){
        return $this->idEmpleado;
    }
    public function setIdEmpleado($idEmpleado) {
        $this->idEmpleado = trim($idEmpleado);
    }
    public function getSalarioBase(){
        return $this->salarioBase;
    }
    public function setSalarioBase($salarioBase) {
        $this->salarioBase = trim($salarioBase);
    }
}
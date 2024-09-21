<?php

class Estudiante {
    private int $id;
    private string $nombre;
    private int $edad;
    private string $carrera;
    private array $materias; // ["materia" => calificacion]

    public function __construct(int $id, string $nombre, int $edad, string $carrera) {
        $this->id = $id;
        $this->nombre = $nombre;
        $this->edad = $edad;
        $this->carrera = $carrera;
        $this->materias = [];
    }

    public function agregarMateria(string $materia, float $calificacion): void {
        $this->materias[$materia] = $calificacion;
    }

    public function obtenerPromedio(): float {
        return array_sum($this->materias) / count($this->materias);
    }

    public function obtenerDetalles(): array {
        return [
            'id' => $this->id,
            'nombre' => $this->nombre,
            'edad' => $this->edad,
            'carrera' => $this->carrera,
            'materias' => $this->materias
        ];
    }

    public function __toString(): string {
        return "{$this->nombre} ({$this->carrera}): Promedio: " . number_format($this->obtenerPromedio(), 2);
    }

    // Flags
    public function enRiesgoAcademico(): bool {
        return $this->obtenerPromedio() < 60; // Puedes ajustar el umbral
    }

    public function honorRoll(): bool {
        return $this->obtenerPromedio() >= 90; // Puedes ajustar el umbral
    }
}

class SistemaGestionEstudiantes {
    private array $estudiantes = [];
    private array $graduados = [];

    public function agregarEstudiante(Estudiante $estudiante): void {
        $this->estudiantes[$estudiante->obtenerDetalles()['id']] = $estudiante;
    }

    public function obtenerEstudiante(int $id): ?Estudiante {
        return $this->estudiantes[$id] ?? null;
    }

    public function listarEstudiantes(): array {
        return $this->estudiantes;
    }

    public function calcularPromedioGeneral(): float {
        return array_sum(array_map(fn($est) => $est->obtenerPromedio(), $this->estudiantes)) / count($this->estudiantes);
    }

    public function obtenerEstudiantesPorCarrera(string $carrera): array {
        return array_filter($this->estudiantes, fn($est) => $est->obtenerDetalles()['carrera'] === $carrera);
    }

    public function obtenerMejorEstudiante(): ?Estudiante {
        return array_reduce($this->estudiantes, fn($mejor, $actual) => $actual->obtenerPromedio() > ($mejor ? $mejor->obtenerPromedio() : 0) ? $actual : $mejor);
    }

    public function graduarEstudiante(int $id): void {
        if (isset($this->estudiantes[$id])) {
            $this->graduados[$id] = $this->estudiantes[$id];
            unset($this->estudiantes[$id]);
        }
    }

    public function generarRanking(): array {
        usort($this->estudiantes, fn($a, $b) => $b->obtenerPromedio() <=> $a->obtenerPromedio());
        return $this->estudiantes;
    }

    public function buscarEstudiantes(string $termino): array {
        return array_filter($this->estudiantes, function($est) use ($termino) {
            return stripos($est->obtenerDetalles()['nombre'], $termino) !== false || stripos($est->obtenerDetalles()['carrera'], $termino) !== false;
        });
    }

    public function generarEstadisticasPorCarrera(): array {
        $estadisticas = [];
        foreach ($this->estudiantes as $est) {
            $carrera = $est->obtenerDetalles()['carrera'];
            if (!isset($estadisticas[$carrera])) {
                $estadisticas[$carrera] = ['cantidad' => 0, 'promedio' => 0, 'mejorEstudiante' => null];
            }
            $estadisticas[$carrera]['cantidad']++;
            $estadisticas[$carrera]['promedio'] += $est->obtenerPromedio();
            if ($estadisticas[$carrera]['mejorEstudiante'] === null || $est->obtenerPromedio() > $estadisticas[$carrera]['mejorEstudiante']->obtenerPromedio()) {
                $estadisticas[$carrera]['mejorEstudiante'] = $est;
            }
        }
        foreach ($estadisticas as &$info) {
            $info['promedio'] /= $info['cantidad'];
        }
        return $estadisticas;
    }
}

// Ejemplo de uso
$sistema = new SistemaGestionEstudiantes();

// Crear estudiantes
$sistema->agregarEstudiante(new Estudiante(1, "Ana López", 20, "Ingeniería"));
$sistema->agregarEstudiante(new Estudiante(2, "Carlos Gómez", 22, "Medicina"));
$sistema->agregarEstudiante(new Estudiante(3, "María Rodríguez", 19, "Ingeniería"));
$sistema->agregarEstudiante(new Estudiante(4, "Pedro Sánchez", 21, "Derecho"));
$sistema->agregarEstudiante(new Estudiante(5, "Laura Martínez", 23, "Medicina"));
$sistema->agregarEstudiante(new Estudiante(6, "José Pérez", 24, "Ingeniería"));

// Agregar materias
$sistema->obtenerEstudiante(1)->agregarMateria("Matemáticas", 95);
$sistema->obtenerEstudiante(1)->agregarMateria("Física", 85);
$sistema->obtenerEstudiante(2)->agregarMateria("Anatomía", 78);
$sistema->obtenerEstudiante(2)->agregarMateria("Bioquímica", 88);
$sistema->obtenerEstudiante(3)->agregarMateria("Cálculo", 90);
$sistema->obtenerEstudiante(3)->agregarMateria("Estadística", 82);
$sistema->obtenerEstudiante(4)->agregarMateria("Derecho Civil", 92);
$sistema->obtenerEstudiante(5)->agregarMateria("Cirugía", 75);
$sistema->obtenerEstudiante(5)->agregarMateria("Pediatría", 80);
$sistema->obtenerEstudiante(6)->agregarMateria("Estructuras", 88);

// Demostraciones de funcionalidades
echo "Mejor estudiante: " . $sistema->obtenerMejorEstudiante() . "\n";
print_r($sistema->generarEstadisticasPorCarrera());
$sistema->graduarEstudiante(1);
echo "Estudiantes después de graduar a Ana:\n";
print_r($sistema->listarEstudiantes());

?>

<?php 
class Estudiante {
    public $id;
    public $nombre;
    public $edad;
    public $carrera;
    public $materias;

    public function __construct($id, $nombre, $edad, $carrera) {
        $this->id = $id;
        $this->nombre = $nombre;
        $this->edad = $edad;
        $this->carrera = $carrera;
        $this->materias = [];
    }

    public function agregarMateria($materia, $calificacion) {
        $this->materias[$materia] = $calificacion;
    }

    public function obtenerPromedio() {
        if (count($this->materias) === 0) {
            return 0; // Si no hay materias, el promedio es 0
        }
        return array_sum($this->materias) / count($this->materias);
    }

    public function obtenerDetalles() {
        return [
            'id' => $this->id,
            'nombre' => $this->nombre,
            'edad' => $this->edad,
            'carrera' => $this->carrera,
            'promedio' => $this->obtenerPromedio()
        ];
    }

    public function __toString() {
        return $this->nombre . ' (' . $this->carrera . ') - Promedio: ' . $this->obtenerPromedio();
    }
}

class SistemaGestionEstudiantes {
    private $estudiantes = [];

    public function agregarEstudiante(Estudiante $estudiante) {
        $this->estudiantes[] = $estudiante;
    }

    public function listarEstudiantes() {
        return $this->estudiantes;
    }

    public function generarEstadisticasPorCarrera() {
        $estadisticas = [];

        foreach ($this->estudiantes as $est) {
            $carrera = $est->carrera;

            // Inicializamos el arreglo de estadísticas para la carrera si no existe
            if (!isset($estadisticas[$carrera])) {
                $estadisticas[$carrera] = [
                    'numeroEstudiantes' => 0,
                    'promedioGeneral' => 0,
                    'mejorEstudiante' => null, // Inicializamos como null
                ];
            }

            // Actualizamos el número de estudiantes y el promedio general
            $estadisticas[$carrera]['numeroEstudiantes']++;
            $estadisticas[$carrera]['promedioGeneral'] += $est->obtenerPromedio();

            // Verificamos si el estudiante actual tiene un mejor promedio que el mejor estudiante registrado
            if ($estadisticas[$carrera]['mejorEstudiante'] === null || 
                $est->obtenerPromedio() > $estadisticas[$carrera]['mejorEstudiante']->obtenerPromedio()) {
                $estadisticas[$carrera]['mejorEstudiante'] = $est; // Asignamos el estudiante como el mejor de la carrera
            }
        }

        // Calculamos el promedio general de cada carrera
        foreach ($estadisticas as $carrera => &$data) {
            if ($data['numeroEstudiantes'] > 0) {
                $data['promedioGeneral'] /= $data['numeroEstudiantes'];
            }
        }

        return $estadisticas;
    }
}

// Instancia del sistema
$sistema = new SistemaGestionEstudiantes();

// Añadir algunos estudiantes
$est1 = new Estudiante(1, "Ana", 20, "Ingeniería");
$est1->agregarMateria("Matemáticas", 85);
$est1->agregarMateria("Física", 90);

$est2 = new Estudiante(2, "Carlos", 22, "Ingeniería");
$est2->agregarMateria("Matemáticas", 78);
$est2->agregarMateria("Física", 88);

$est3 = new Estudiante(3, "María", 21, "Derecho");
$est3->agregarMateria("Derecho Civil", 95);
$est3->agregarMateria("Derecho Penal", 92);

$sistema->agregarEstudiante($est1);
$sistema->agregarEstudiante($est2);
$sistema->agregarEstudiante($est3);

// Generar estadísticas por carrera
$estadisticas = $sistema->generarEstadisticasPorCarrera();

echo "Estadísticas por carrera:\n";
foreach ($estadisticas as $carrera => $data) {
    echo "\nCarrera: $carrera\n";
    echo "Número de estudiantes: " . $data['numeroEstudiantes'] . "\n";
    echo "Promedio general: " . number_format($data['promedioGeneral'], 2) . "\n";
    echo "Mejor estudiante: " . $data['mejorEstudiante']->nombre . " con promedio " . $data['mejorEstudiante']->obtenerPromedio() . "\n";
}

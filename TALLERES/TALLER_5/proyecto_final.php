<?php

class Estudiante {
    public $id; // Identificador único del estudiante
    public $nombre; // Nombre del estudiante
    public $edad; // Edad del estudiante
    public $carrera; // Carrera que estudia el estudiante
    public $materias; // Arreglo para guardar las materias y sus calificaciones

    // Constructor que se llama al crear un nuevo estudiante
    public function __construct($id, $nombre, $edad, $carrera) {
        $this->id = $id;
        $this->nombre = $nombre;
        $this->edad = $edad;
        $this->carrera = $carrera;
        $this->materias = []; // Inicializamos las materias como un arreglo vacío
    }

    // Método para agregar una materia con su calificación
    public function agregarMateria($materia, $calificacion) {
        $this->materias[$materia] = $calificacion; // Guardamos la materia y su calificación
    }

    // Método para calcular el promedio de las calificaciones
    public function obtenerPromedio() {
        if (count($this->materias) === 0) { // Si no tiene materias, el promedio es 0
            return 0;
        }
        // Sumamos las calificaciones y dividimos entre el número de materias
        return array_sum($this->materias) / count($this->materias);
    }

    // Método para obtener los detalles del estudiante
    public function obtenerDetalles() {
        return [
            'id' => $this->id,
            'nombre' => $this->nombre,
            'edad' => $this->edad,
            'carrera' => $this->carrera,
            'promedio' => $this->obtenerPromedio(), // Calculamos y añadimos el promedio
        ];
    }

    // Método que permite imprimir directamente la información del estudiante con echo
    public function __toString() {
        return "{$this->nombre} (ID: {$this->id}), Promedio: {$this->obtenerPromedio()}\n";
    }
}


class SistemaGestionEstudiantes {
    public $estudiantes = []; // Arreglo donde se almacenan los estudiantes
    public $graduados = []; // Arreglo para guardar a los estudiantes graduados

    // Método para agregar un estudiante al sistema
    public function agregarEstudiante(Estudiante $estudiante) {
        $this->estudiantes[$estudiante->id] = $estudiante; // Guardamos al estudiante usando su ID como clave
    }

    // Método para obtener un estudiante por su ID
    public function obtenerEstudiante($id) {
        return $this->estudiantes[$id] ?? null; // Retorna el estudiante si existe o null si no
    }

    // Método para listar todos los estudiantes
    public function listarEstudiantes() {
        return $this->estudiantes; // Devuelve el arreglo de estudiantes
    }

    // Método para calcular el promedio general de todos los estudiantes
    public function calcularPromedioGeneral() {
        if (count($this->estudiantes) === 0) { // Si no hay estudiantes, el promedio es 0
            return 0;
        }
        // Sumamos los promedios de todos los estudiantes y calculamos el promedio general
        $totalPromedios = array_sum(array_map(function($estudiante) {
            return $estudiante->obtenerPromedio();
        }, $this->estudiantes));
        return $totalPromedios / count($this->estudiantes);
    }

    // Método para obtener estudiantes de una carrera específica
    public function obtenerEstudiantesPorCarrera($carrera) {
        return array_filter($this->estudiantes, function($estudiante) use ($carrera) {
            return $estudiante->carrera === $carrera; // Solo devolvemos estudiantes de esa carrera
        });
    }

    // Método para encontrar al estudiante con mejor promedio
    public function obtenerMejorEstudiante() {
        if (empty($this->estudiantes)) { // Si no hay estudiantes, no retornamos nada
            return null;
        }
        // Comparamos los promedios para encontrar al estudiante con mejor calificación
        return array_reduce($this->estudiantes, function($mejor, $estudiante) {
            return ($mejor === null || $estudiante->obtenerPromedio() > $mejor->obtenerPromedio()) ? $estudiante : $mejor;
        });
    }

    // Método para generar un reporte de rendimiento de cada materia
    public function generarReporteRendimiento() {
        $materiaReporte = []; // Aquí almacenamos los datos de cada materia
        foreach ($this->estudiantes as $estudiante) {
            foreach ($estudiante->materias as $materia => $calificacion) {
                // Si la materia no está en el reporte, la inicializamos
                if (!isset($materiaReporte[$materia])) {
                    $materiaReporte[$materia] = [
                        'total' => 0,
                        'count' => 0,
                        'max' => $calificacion, // Inicializamos con la primera calificación
                        'min' => $calificacion
                    ];
                }
                // Actualizamos los datos de la materia
                $materiaReporte[$materia]['total'] += $calificacion;
                $materiaReporte[$materia]['count']++;
                $materiaReporte[$materia]['max'] = max($materiaReporte[$materia]['max'], $calificacion);
                $materiaReporte[$materia]['min'] = min($materiaReporte[$materia]['min'], $calificacion);
            }
        }
        // Mostramos los datos calculados para cada materia
        foreach ($materiaReporte as $materia => $datos) {
            $promedio = $datos['total'] / $datos['count'];
            echo "Materia: $materia - Promedio: $promedio, Máxima: {$datos['max']}, Mínima: {$datos['min']}\n";
        }
    }

    // Método para graduar a un estudiante, quitándolo del sistema
    public function graduarEstudiante($id) {
        if (isset($this->estudiantes[$id])) {
            $this->graduados[] = $this->estudiantes[$id]; // Lo agregamos al arreglo de graduados
            unset($this->estudiantes[$id]); // Lo quitamos del arreglo de estudiantes activos
        }
    }

    // Método para generar un ranking de los estudiantes basado en su promedio
    public function generarRanking() {
        usort($this->estudiantes, function($a, $b) {
            return $b->obtenerPromedio() <=> $a->obtenerPromedio(); // Ordenamos de mayor a menor promedio
        });
        return $this->estudiantes; // Devolvemos el arreglo ordenado
    }

    // Método para buscar estudiantes por nombre o carrera
    public function buscarEstudiante($query) {
        $query = strtolower($query); // Convertimos la consulta a minúsculas para que no importe si hay mayúsculas
        return array_filter($this->estudiantes, function($estudiante) use ($query) {
            // Buscamos coincidencias en el nombre o carrera
            return (strpos(strtolower($estudiante->nombre), $query) !== false ||
                    strpos(strtolower($estudiante->carrera), $query) !== false);
        });
    }

    // Método para generar estadísticas por carrera
    public function generarEstadisticasPorCarrera() {
        $estadisticas = []; // Aquí almacenamos las estadísticas por carrera

        foreach ($this->estudiantes as $est) {
            $carrera = $est->carrera;

            // Si la carrera no está en las estadísticas, la inicializamos
            if (!isset($estadisticas[$carrera])) {
                $estadisticas[$carrera] = [
                    'numeroEstudiantes' => 0,
                    'promedioGeneral' => 0,
                    'mejorEstudiante' => null, // Inicializamos como null el mejor estudiante
                ];
            }

            // Actualizamos el número de estudiantes y el promedio general
            $estadisticas[$carrera]['numeroEstudiantes']++;
            $estadisticas[$carrera]['promedioGeneral'] += $est->obtenerPromedio();

            // Verificamos si el estudiante actual es mejor que el que ya está registrado
            if ($estadisticas[$carrera]['mejorEstudiante'] === null || 
                $est->obtenerPromedio() > $estadisticas[$carrera]['mejorEstudiante']->obtenerPromedio()) {
                $estadisticas[$carrera]['mejorEstudiante'] = $est;
            }
        }

        // Calculamos el promedio general para cada carrera
        foreach ($estadisticas as $carrera => &$data) {
            if ($data['numeroEstudiantes'] > 0) {
                $data['promedioGeneral'] /= $data['numeroEstudiantes'];
            }
        }

        return $estadisticas; // Devolvemos las estadísticas finales
    }
}



// Código de prueba

$sistema = new SistemaGestionEstudiantes();

// Lista inicial de estudiantes con sus materias y calificaciones
$estudiantes = [
    new Estudiante(1, "Ana López", 21, "Ingeniería"),
    new Estudiante(2, "Carlos Gómez", 22, "Derecho"),
    new Estudiante(3, "María Rodríguez", 23, "Medicina"),
    new Estudiante(4, "Luis Martínez", 20, "Ingeniería"),
    new Estudiante(5, "Jorge Hernández", 24, "Ingeniería"),
    new Estudiante(6, "Laura Sánchez", 22, "Arquitectura"),
    new Estudiante(7, "Pedro Díaz", 21, "Arquitectura"),
    new Estudiante(8, "Lucía Pérez", 23, "Medicina"),
    new Estudiante(9, "Elena Morales", 20, "Ingeniería"),
    new Estudiante(10, "José Ramírez", 25, "Derecho")
];

// Agregar calificaciones a las materias de cada estudiante
$estudiantes[0]->agregarMateria("Matemáticas", 95);
$estudiantes[0]->agregarMateria("Física", 90);

$estudiantes[1]->agregarMateria("Derecho Civil", 85);
$estudiantes[1]->agregarMateria("Derecho Penal", 80);

$estudiantes[2]->agregarMateria("Anatomía", 92);
$estudiantes[2]->agregarMateria("Fisiología", 88);

$estudiantes[3]->agregarMateria("Matemáticas", 99);
$estudiantes[3]->agregarMateria("Física", 98);

$estudiantes[4]->agregarMateria("Matemáticas", 85);
$estudiantes[4]->agregarMateria("Física", 82);

$estudiantes[5]->agregarMateria("Diseño", 95);
$estudiantes[5]->agregarMateria("Historia del Arte", 91);

$estudiantes[6]->agregarMateria("Diseño", 87);
$estudiantes[6]->agregarMateria("Historia del Arte", 84);

$estudiantes[7]->agregarMateria("Anatomía", 100);
$estudiantes[7]->agregarMateria("Fisiología", 99);

$estudiantes[8]->agregarMateria("Matemáticas", 90);
$estudiantes[8]->agregarMateria("Física", 88);

$estudiantes[9]->agregarMateria("Derecho Civil", 78);
$estudiantes[9]->agregarMateria("Derecho Penal", 75);

// Agregar los estudiantes al sistema
foreach ($estudiantes as $estudiante) {
    $sistema->agregarEstudiante($estudiante);
}

// Reporte de rendimiento
echo "\nReporte de Rendimiento:\n";
$sistema->generarReporteRendimiento();

// Estadísticas por carrera
echo "\nEstadísticas por carrera:\n";
$estadisticas = $sistema->generarEstadisticasPorCarrera();
foreach ($estadisticas as $carrera => $data) {
    echo "$carrera: Estudiantes: {$data['numeroEstudiantes']}, Promedio General: {$data['promedioGeneral']}, Mejor Estudiante: {$data['mejorEstudiante']->nombre}\n";
}

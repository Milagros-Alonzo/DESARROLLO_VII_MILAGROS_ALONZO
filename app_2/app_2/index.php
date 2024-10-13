<?php
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

require_once 'clases.php';

$estadosLegibles = [
    "disponible" => "DISPONIBLE",
    "prestado" => "PRESTADO",
    "en>_reparacion" => "EN REPARACION"
];

// Obtener la acción del query string, 'list' por defecto
$action = isset($_GET['action']) ? $_GET['action'] : 'list';

// Variables para ordenamiento y filtrado
$sortField = isset($_GET['field']) ? $_GET['field'] : 'id';
$sortDirection = isset($_GET['direction']) ? $_GET['direction'] : 'ASC';
$filterEstado = isset($_GET['filterEstado']) ? $_GET['filterEstado'] : '';

$gestorBiblioteca = new GestorBiblioteca();
$recursos = $gestorBiblioteca->cargarRecursos();

// Variable para almacenar el recurso en edición
$recursoEnEdicion = null;

// Procesar la acción
switch ($action) {
    case 'add':
        if (isset($_GET['titulo']) && isset($_GET['autor']) && isset($_GET['anioPublicacion']) && isset($_GET['estado']) && isset($_GET['fechaAdquisicion']) && isset($_GET['tipo'])) {
            $titulo = $_GET['titulo'];
            $autor = $_GET['autor'];
            $anioPublicacion = intval($_GET['anioPublicacion']);
            $estado = $_GET['estado'];
            $fechaAdquisicion = $_GET['fechaAdquisicion'];
            $tipo = $_GET['tipo'];

            // Implementar la lógica para agregar el recurso al gestor
        }
        break;

    case 'edit':
        if (isset($_GET['id']) && isset($_GET['titulo']) && isset($_GET['autor']) && isset($_GET['anioPublicacion']) && isset($_GET['estado']) && isset($_GET['fechaAdquisicion']) && isset($_GET['tipo'])) {
            $id = intval($_GET['id']);
            $titulo = $_GET['titulo'];
            $autor = $_GET['autor'];
            $anioPublicacion = intval($_GET['anioPublicacion']);
            $estado = $_GET['estado'];
            $fechaAdquisicion = $_GET['fechaAdquisicion'];
            $tipo = $_GET['tipo'];

            // Implementar la lógica para actualizar el recurso en el gestor
        }
        break;

    case 'delete':
        if (isset($_GET['id'])) {
            $id = intval($_GET['id']);
            // Implementar la lógica para eliminar el recurso
        }
        break;

    case 'status':
        if (isset($_GET['id']) && isset($_GET['estado'])) {
            $id = intval($_GET['id']);
            $nuevoEstado = $_GET['estado'];
            // Implementar la lógica para cambiar el estado del recurso
        }
        break;

    case 'filter':
        if (isset($_GET['filterEstado'])) {
            $filterEstado = $_GET['filterEstado'];
            // Implementar la lógica para filtrar los recursos por estado
        }
        break;

    case 'sort':
        if (isset($_GET['field']) && isset($_GET['direction'])) {
            $sortField = $_GET['field'];
            $sortDirection = $_GET['direction'];
            // Implementar la lógica para ordenar los recursos
        }
        break;

    case 'list':
    default:
        // Implementar la lógica para listar todos los recursos
        break;
}
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Gestor de Biblioteca</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css" rel="stylesheet">
</head>
<body>
    <div class="container mt-5">
        <h1 class="mb-4">Gestor de Biblioteca</h1>
        
        <?php if (isset($mensaje)): ?>
            <div class="alert alert-success" role="alert">
                <?php echo $mensaje; ?>
            </div>
        <?php endif; ?>

        <form action="index.php" method="GET" class="row g-3 mb-4 align-items-end">
            <input type="hidden" name="action" value="<?php echo $recursoEnEdicion ? 'edit' : 'add'; ?>">
            <?php if ($recursoEnEdicion): ?>
                <input type="hidden" name="id" value="<?php echo $recursoEnEdicion->id; ?>">
            <?php endif; ?>
            
            <div class="col">
                <input type="text" class="form-control" name="titulo" placeholder="Título" required
                       value="<?php echo $recursoEnEdicion ? $recursoEnEdicion->titulo : ''; ?>">
            </div>
            <div class="col">
                <input type="text" class="form-control" name="autor" placeholder="Autor" required
                       value="<?php echo $recursoEnEdicion ? $recursoEnEdicion->autor : ''; ?>">
            </div>
            <div class="col">
                <input type="number" class="form-control" name="anioPublicacion" placeholder="Año" required
                       value="<?php echo $recursoEnEdicion ? $recursoEnEdicion->anioPublicacion : ''; ?>">
            </div>
            <div class="col">
                <select class="form-select" name="estado" required>
                    <option value="">Estado</option>
                    <option value="disponible" <?php echo ($recursoEnEdicion && $recursoEnEdicion->estado == 'disponible') ? 'selected' : ''; ?>>Disponible</option>
                    <option value="prestado" <?php echo ($recursoEnEdicion && $recursoEnEdicion->estado == 'prestado') ? 'selected' : ''; ?>>Prestado</option>
                    <option value="en_reparacion" <?php echo ($recursoEnEdicion && $recursoEnEdicion->estado == 'en_reparacion') ? 'selected' : ''; ?>>En Reparación</option>
                </select>
            </div>
            <div class="col">
                <input type="date" class="form-control" name="fechaAdquisicion" required
                       value="<?php echo $recursoEnEdicion ? $recursoEnEdicion->fechaAdquisicion : ''; ?>">
            </div>
            <div class="col">
                <select class="form-select" name="tipo" required id="tipoRecurso">
                    <option value="">Tipo de Recurso</option>
                    <option value="Libro" <?php echo ($recursoEnEdicion && $recursoEnEdicion->tipo == 'Libro') ? 'selected' : ''; ?>>Libro</option>
                    <option value="Revista" <?php echo ($recursoEnEdicion && $recursoEnEdicion->tipo == 'Revista') ? 'selected' : ''; ?>>Revista</option>
                    <option value="DVD" <?php echo ($recursoEnEdicion && $recursoEnEdicion->tipo == 'DVD') ? 'selected' : ''; ?>>DVD</option>
                </select>
            </div>
            <div class="col" id="columnaLibro" style="display:none;">
                <input type="text" class="form-control" id="campoLibro" name="isbn" placeholder="ISBN">
            </div>
            <div class="col" id="columnaRevista" style="display:none;">
                <input type="number" class="form-control" id="campoRevista" name="numeroEdicion" placeholder="Número de Edición">
            </div>
            <div class="col" id="columnaDVD" style="display:none;">
                <input type="number" class="form-control" id="campoDVD" name="duracion" placeholder="Duración (minutos)">
            </div>
            <div class="col">
                <button type="submit" class="btn btn-primary w-100">
                    <?php echo $recursoEnEdicion ? 'Actualizar' : 'Agregar'; ?>
                </button>
            </div>
        </form>

        <!-- Filtro por estado -->
        <form action="index.php" method="GET" class="row g-3 mb-4 align-items-end">
            <input type="hidden" name="action" value="filter">
            <div class="col-auto">
                <select name="filterEstado" class="form-select">
                    <option value="">Todos los estados</option>
                    <?php foreach ($estadosLegibles as $valor => $texto): ?>
                        <option value="<?php echo $valor; ?>" <?php echo $filterEstado == $valor ? 'selected' : ''; ?>><?php echo $texto; ?></option>
                    <?php endforeach; ?>
                </select>
            </div>
            <div class="col-auto">
                <button type="submit" class="btn btn-primary">Filtrar</button>
            </div>
        </form>

<!-- Tabla de recursos -->
<table class="table table-striped table-hover">
            <thead>
                <tr>
                    <th><a href="index.php?action=sort&field=id&direction=<?php echo $sortField == 'id' && $sortDirection == 'ASC' ? 'DESC' : 'ASC'; ?>&filterEstado=<?php echo $filterEstado; ?>">ID <?php echo $sortField == 'id' ? ($sortDirection == 'ASC' ? '▲' : '▼') : ''; ?></a></th>
                    <th><a href="index.php?action=sort&field=titulo&direction=<?php echo $sortField == 'titulo' && $sortDirection == 'ASC' ? 'DESC' : 'ASC'; ?>&filterEstado=<?php echo $filterEstado; ?>">Título <?php echo $sortField == 'titulo' ? ($sortDirection == 'ASC' ? '▲' : '▼') : ''; ?></a></th>
                    <th><a href="index.php?action=sort&field=autor&direction=<?php echo $sortField == 'autor' && $sortDirection == 'ASC' ? 'DESC' : 'ASC'; ?>&filterEstado=<?php echo $filterEstado; ?>">Autor <?php echo $sortField == 'autor' ? ($sortDirection == 'ASC' ? '▲' : '▼') : ''; ?></a></th>
                    <th><a href="index.php?action=sort&field=anioPublicacion&direction=<?php echo $sortField == 'anioPublicacion' && $sortDirection == 'ASC' ? 'DESC' : 'ASC'; ?>&filterEstado=<?php echo $filterEstado; ?>">Año <?php echo $sortField == 'anioPublicacion' ? ($sortDirection == 'ASC' ? '▲' : '▼') : ''; ?></a></th>
                    <th><a href="index.php?action=sort&field=estado&direction=<?php echo $sortField == 'estado' && $sortDirection == 'ASC' ? 'DESC' : 'ASC'; ?>&filterEstado=<?php echo $filterEstado; ?>">Estado <?php echo $sortField == 'estado' ? ($sortDirection == 'ASC' ? '▲' : '▼') : ''; ?></a></th>
                    <th><a href="index.php?action=sort&field=fechaAdquisicion&direction=<?php echo $sortField == 'fechaAdquisicion' && $sortDirection == 'ASC' ? 'DESC' : 'ASC'; ?>&filterEstado=<?php echo $filterEstado; ?>">Fecha Adquisición <?php echo $sortField == 'fechaAdquisicion' ? ($sortDirection == 'ASC' ? '▲' : '▼') : ''; ?></a></th>
                    <th>Tipo</th>
                    <th>Detalle</th>
                    <th>Acciones</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($recursos as $recurso): ?>
                    <tr>
                        <td><?php echo $recurso->id; ?></td>
                        <td><?php echo $recurso->titulo; ?></td>
                        <td><?php echo $recurso->autor; ?></td>
                        <td><?php echo $recurso->anioPublicacion; ?></td>
                        <td><?php echo $estadosLegibles[$recurso->estado]; ?></td>
                        <td><?php echo $recurso->fechaAdquisicion; ?></td>
                        <td><?php echo $recurso->tipo; ?></td>
                        <td><?php echo $recurso->obtenerDetallesPrestamo(); ?></td>

                        <td>
                            <a href='index.php?action=edit&id=<?php echo $recurso->id; ?>' class='btn btn-sm btn-warning'><i class='fas fa-edit'></i></a>
                            <a href='index.php?action=delete&id=<?php echo $recurso->id; ?>' class='btn btn-sm btn-danger' onclick="return confirm('¿Está seguro de que desea eliminar este recurso?');"><i class='fas fa-trash'></i></a>
                            <select class='form-select form-select-sm d-inline-block w-auto' onchange="cambiarEstado(this, <?php echo $recurso->id; ?>)">
                                <option value=''>Cambiar estado</option>
                                <?php if ($recurso->estado !== 'disponible'): ?>
                                    <option value='disponible'>Disponible</option>
                                <?php endif; ?>
                                <?php if ($recurso->estado !== 'prestado'): ?>
                                    <option value='prestado'>Prestado</option>
                                <?php endif; ?>
                                <?php if ($recurso->estado !== 'en_reparacion'): ?>
                                    <option value='en_reparacion'>En reparación</option>
                                <?php endif; ?>
                            </select>
                        </td>
                    </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js"></script>
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const tipoRecurso = document.getElementById('tipoRecurso');
            const columnaLibro = document.getElementById('columnaLibro');
            const columnaRevista = document.getElementById('columnaRevista');
            const columnaDVD = document.getElementById('columnaDVD');

            function actualizarCamposEspecificos() {
                columnaLibro.style.display = 'none';
                columnaRevista.style.display = 'none';
                columnaDVD.style.display = 'none';

                switch(tipoRecurso.value) {
                    case 'Libro':
                        columnaLibro.style.display = 'block';
                        break;
                    case 'Revista':
                        columnaRevista.style.display = 'block';
                        break;
                    case 'DVD':
                        columnaDVD.style.display = 'block';
                        break;
                }
            }

            tipoRecurso.addEventListener('change', actualizarCamposEspecificos);
            actualizarCamposEspecificos();
        });

        function cambiarEstado(selectElement, recursoId) {
            if (selectElement.value) {
                window.location.href = 'index.php?action=status&id=' + recursoId + '&estado=' + selectElement.value;
            }
        }        
    </script>
</body>
</html>
<?php

require_once 'clases.php';

$gestorBlog = new GestorBlog();
$gestorBlog->cargarEntradas();

$action = $_GET['action'] ?? 'list';
$mensaje = '';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    if (isset($_POST['action'])) {
        switch ($_POST['action']) {
            case 'add':
            case 'edit':
                // Asegurarse de que el tipo esté definido
                if (!isset($_POST['tipo'])) {
                    $mensaje = "Error: Tipo de entrada no especificado.";
                    break;
                }

                // Implementar la lógica

                break;
        }
    }
}

if ($action === 'delete' && isset($_GET['id'])) {
    // Implementar la lógica
    $mensaje = "Entrada eliminada con éxito.";
    $action = "list";
}

if (($action === 'move_up' || $action === 'move_down') && isset($_GET['id'])) {
    // Implementar la lógica
    $mensaje = "Entrada reordenada con éxito.";
    $action = "list";
}

$entradas = $gestorBlog->obtenerEntradas();
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Gestor de Blog</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>
    <div class="container mt-5">
        <h1 class="mb-4">Gestor de Blog</h1>
        
        <?php if ($mensaje): ?>
            <div class="alert alert-success" role="alert">
                <?php echo $mensaje; ?>
            </div>
        <?php endif; ?>

        <nav class="mb-4">
            <a href="index.php?action=list" class="btn btn-primary">Listar Entradas</a>
            <a href="index.php?action=add" class="btn btn-success">Agregar Entrada</a>
            <a href="index.php?action=view" class="btn btn-info">Ver Blog</a>
        </nav>

        <?php if ($action === 'list'): ?>
            <table class="table table-striped">
                <thead>
                    <tr>
                        <th>ID</th>
                        <th>Título</th>
                        <th>Tipo</th>
                        <th>Fecha de Creación</th>
                        <th>Acciones</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($entradas as $entrada): ?>
                        <tr>
                            <td><?php echo $entrada->id; ?></td>
                            <td><?php echo $entrada->titulo ?? $entrada->titulo1; ?></td>
                            <td><?php echo $entrada->tipo; ?> columna(s)</td>
                            <td><?php echo $entrada->fecha_creacion; ?></td>
                            <td>
                                <a href="index.php?action=edit&id=<?php echo $entrada->id; ?>" class="btn btn-warning btn-sm">Editar</a>
                                <a href="index.php?action=delete&id=<?php echo $entrada->id; ?>" class="btn btn-danger btn-sm" onclick="return confirm('¿Está seguro de eliminar esta entrada?')">Eliminar</a>
                                <a href="index.php?action=move_up&id=<?php echo $entrada->id; ?>" class="btn btn-secondary btn-sm">▲</a>
                                <a href="index.php?action=move_down&id=<?php echo $entrada->id; ?>" class="btn btn-secondary btn-sm">▼</a>
                            </td>
                        </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
            <a href="index.php?action=view" class="btn btn-primary">Ver Blog</a>
            <?php elseif ($action === 'add' || $action === 'edit'): ?>
    <?php
    $entradaEditar = null;
    if ($action === 'edit' && isset($_GET['id'])) {
        $entradaEditar = $gestorBlog->obtenerEntrada($_GET['id']);
    }
    ?>
    <form action="index.php" method="post">
        <input type="hidden" name="action" value="<?php echo $action; ?>">
        <?php if ($entradaEditar): ?>
            <input type="hidden" name="id" value="<?php echo $entradaEditar->id; ?>">
        <?php endif; ?>
        
        <div class="mb-3">
            <label for="tipo" class="form-label">Tipo de Entrada</label>
            <select class="form-select" id="tipo" name="tipo" required>
                <option value="1" <?php echo $entradaEditar && $entradaEditar->tipo == 1 ? 'selected' : ''; ?>>1 Columna</option>
                <option value="2" <?php echo $entradaEditar && $entradaEditar->tipo == 2 ? 'selected' : ''; ?>>2 Columnas</option>
                <option value="3" <?php echo $entradaEditar && $entradaEditar->tipo == 3 ? 'selected' : ''; ?>>3 Columnas</option>
            </select>
        </div>

        <div id="campos-dinamicos">
            <!-- Los campos se generarán dinámicamente con JavaScript -->
        </div>

        <button type="submit" class="btn btn-primary"><?php echo $action === 'add' ? 'Agregar' : 'Actualizar'; ?> Entrada</button>
        <a href="index.php?action=list" class="btn btn-secondary">Volver al Listado</a>
    </form>

    <script>
    document.addEventListener('DOMContentLoaded', function() {
        const tipoSelect = document.getElementById('tipo');
        const camposDinamicos = document.getElementById('campos-dinamicos');

        const entradaEditar = <?php echo $entradaEditar ? json_encode($entradaEditar) : 'null'; ?>;

        function generarCampos() {
            const tipo = parseInt(tipoSelect.value);
            let campos = '';

            for (let i = 1; i <= tipo; i++) {
                const tituloKey = tipo === 1 ? 'titulo' : `titulo${i}`;
                const descripcionKey = tipo === 1 ? 'descripcion' : `descripcion${i}`;

                const tituloValue = entradaEditar ? (entradaEditar[tituloKey] || '') : '';
                const descripcionValue = entradaEditar ? (entradaEditar[descripcionKey] || '') : '';

                campos += `
                    <div class="mb-3">
                        <label for="${tituloKey}" class="form-label">Título ${i}</label>
                        <input type="text" class="form-control" id="${tituloKey}" name="${tituloKey}" required value="${tituloValue.replace(/"/g, '&quot;')}">
                    </div>
                    <div class="mb-3">
                        <label for="${descripcionKey}" class="form-label">Descripción ${i}</label>
                        <textarea class="form-control" id="${descripcionKey}" name="${descripcionKey}" rows="3" required>${descripcionValue.replace(/</g, '&lt;').replace(/>/g, '&gt;')}</textarea>
                    </div>
                `;
            }

            camposDinamicos.innerHTML = campos;
        }

        tipoSelect.addEventListener('change', generarCampos);
        generarCampos(); // Generar campos iniciales
    });
    </script>
            <?php elseif ($action === 'view'): ?>
                <div class="row">
                    <?php foreach ($entradas as $entrada): ?>
                        <?php switch ($entrada->tipo):
                            case 1: ?>
                                <div class="col-12 mb-4">
                                    <div class="card">
                                        <img src="https://picsum.photos/800/400?random=<?php echo $entrada->id; ?>" class="card-img-top" alt="Imagen aleatoria">
                                        <div class="card-body">
                                            <h5 class="card-title"><?php echo $entrada->titulo; ?></h5>
                                            <p class="card-text"><?php echo $entrada->descripcion; ?></p>
                                            <p class="card-text"><small class="text-muted"><?php echo $entrada->fecha_creacion; ?></small></p>
                                        </div>
                                    </div>
                                </div>
                            <?php break;
                            case 2: ?>
                                <div class="col-md-6 mb-4">
                                    <div class="card">
                                        <img src="https://picsum.photos/400/300?random=<?php echo $entrada->id; ?>-1" class="card-img-top" alt="Imagen aleatoria">
                                        <div class="card-body">
                                            <h5 class="card-title"><?php echo $entrada->titulo1; ?></h5>
                                            <p class="card-text"><?php echo $entrada->descripcion1; ?></p>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-6 mb-4">
                                    <div class="card">
                                        <img src="https://picsum.photos/400/300?random=<?php echo $entrada->id; ?>-2" class="card-img-top" alt="Imagen aleatoria">
                                        <div class="card-body">
                                            <h5 class="card-title"><?php echo $entrada->titulo2; ?></h5>
                                            <p class="card-text"><?php echo $entrada->descripcion2; ?></p>
                                        </div>
                                    </div>
                                </div>
                            <?php break;
                            case 3: ?>
                                <div class="col-md-4 mb-4">
                                    <div class="card">
                                        <img src="https://picsum.photos/300/200?random=<?php echo $entrada->id; ?>-1" class="card-img-top" alt="Imagen aleatoria">
                                        <div class="card-body">
                                            <h5 class="card-title"><?php echo $entrada->titulo1; ?></h5>
                                            <p class="card-text"><?php echo $entrada->descripcion1; ?></p>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-4 mb-4">
                                    <div class="card">
                                        <img src="https://picsum.photos/300/200?random=<?php echo $entrada->id; ?>-2" class="card-img-top" alt="Imagen aleatoria">
                                        <div class="card-body">
                                            <h5 class="card-title"><?php echo $entrada->titulo2; ?></h5>
                                            <p class="card-text"><?php echo $entrada->descripcion2; ?></p>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-4 mb-4">
                                    <div class="card">
                                        <img src="https://picsum.photos/300/200?random=<?php echo $entrada->id; ?>-3" class="card-img-top" alt="Imagen aleatoria">
                                        <div class="card-body">
                                            <h5 class="card-title"><?php echo $entrada->titulo3; ?></h5>
                                            <p class="card-text"><?php echo $entrada->descripcion3; ?></p>
                                        </div>
                                    </div>
                                </div>
                            <?php break;
                        endswitch; ?>
                    <?php endforeach; ?>
                </div>
                <a href="index.php?action=list" class="btn btn-primary">Volver al Listado</a>
            <?php endif; ?>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
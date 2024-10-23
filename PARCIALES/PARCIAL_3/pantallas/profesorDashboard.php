<?php
session_start();
include '../include/data.php';
if ($_SESSION['role'] !== 'profesor') {
    header('Location: ../index.php');
    exit();
}
?>
<!DOCTYPE html>
<html lang="es">
<head>
<meta charset="UTF-8">
    <title>Aplicación de Calificaciones</title>
</head>
<body>
        <h2 class="text-center">Biemvenido, Profesor</h2>
        <table class="table table-striped mt-4">
            <thead>
                <tr>
                    <th>Estudiante</th>
                    <th>Calificación</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($usuarios as $key => $user): ?>
                    <?php if ($user['role'] === 'estudiante'): ?>
                        <tr>
                            <td><?php echo $key; ?></td>
                            <td><?php echo $user['calificacion']; ?></td>
                        </tr>
                    <?php endif; ?>
                <?php endforeach; ?>
            </tbody>
        </table>
        <div class="text-center">
            <a href="../include/logout.php" class="btn btn-danger">Cerrar Sesión</a>
        </div>
    </div>
</body>
</html>

<?php
session_start();
include '../include/data.php';
if ($_SESSION['role'] !== 'estudiante') {
    header('Location: ../index.php');
    exit();
}
$estudiante = $_SESSION['username'];
?>
<!DOCTYPE html>
<html lang="es">
<meta charset="UTF-8">
    <title>Aplicación de Calificaciones</title>
</head>
<body>

        <h2 class="text-center">Bienvenido, <?php echo $estudiante; ?></h2>

                <p class="h4">Tu calificación es:</p>
                <p class="display-3"><?php echo $usuarios[$estudiante]['calificacion']; ?></p>

            <a href="../include/logout.php" class="btn btn-danger">Cerrar Sesión</a>
</body>
</html>

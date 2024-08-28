
<?php
// Configuración
define('APP_NAME', 'Mi Aplicación PHP');
define('VERSION', '1.0.0');

// Funciones de utilidad
function formatearFecha($fecha) {
    return date('d/m/Y', strtotime($fecha));
}

function limpiarTexto($texto) {
    return htmlspecialchars(trim($texto), ENT_QUOTES, 'UTF-8');
}

function calcularEdad($fechaNacimiento) {
    $hoy = new DateTime();
    $fechaNac = new DateTime($fechaNacimiento);
    $edad = $hoy->diff($fechaNac);
    return $edad->y;
}

// Datos de ejemplo (en una aplicación real, esto podría venir de una base de datos)
$usuario = [
    'nombre' => 'Juan Pérez',
    'email' => 'juan@example.com',
    'fechaNacimiento' => '1990-05-15'
];

// Inclusión de archivos externos (simulado)
// include_once 'config.php';
// require_once 'funciones.php';

// Lógica para procesar datos
$nombreUsuario = limpiarTexto($usuario['nombre']);
$emailUsuario = limpiarTexto($usuario['email']);
$edadUsuario = calcularEdad($usuario['fechaNacimiento']);

// Inicio de la salida HTML
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?= APP_NAME ?> - Buenas Prácticas</title>
    <style>
        body { font-family: Arial, sans-serif; line-height: 1.6; padding: 20px; }
        .info { background-color: #e7f3fe; border-left: 6px solid #2196F3; margin-bottom: 15px; padding: 10px; }
    </style>
</head>
<body>
    <h1>Buenas Prácticas en PHP</h1>
    <p>Versión de la aplicación: <?= VERSION ?></p>
    
    <h2>Información del Usuario</h2>
    <div class="info">
        <p>Nombre: <?= $nombreUsuario ?></p>
        <p>Email: <?= $emailUsuario ?></p>
        <p>Edad: <?= $edadUsuario ?> años</p>
    </div>
    
    <p>Fecha actual: <?= formatearFecha(date('Y-m-d')) ?></p>

    <?php
    // Ejemplo de uso de estructuras de control
    $horaActual = date('H');
    if ($horaActual < 12) {
        echo "<p>Buenos días, $nombreUsuario!</p>";
    } elseif ($horaActual < 18) {
        echo "<p>Buenas tardes, $nombreUsuario!</p>";
    } else {
        echo "<p>Buenas noches, $nombreUsuario!</p>";
    }
    ?>
</body>
</html>
    
							

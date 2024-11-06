<?php
// Declara la variable $calificacion y asígnale un valor numérico entre 0 y 100.
$calificacion = 85; // Puedes cambiar este valor para probar diferentes resultados

// Usa una estructura if-elseif-else para determinar la letra correspondiente a la calificación
if ($calificacion >= 90 && $calificacion <= 100) {
    $letra = 'A';
} elseif ($calificacion >= 80 && $calificacion <= 89) {
    $letra = 'B';
} elseif ($calificacion >= 70 && $calificacion <= 79) {
    $letra = 'C';
} elseif ($calificacion >= 60 && $calificacion <= 69) {
    $letra = 'D';
} else {
    $letra = 'F';
}

// Imprime el mensaje con la calificación y si es "Aprobado" o "Reprobado"
echo "Tu calificación es $letra. ";
echo ($letra == 'F') ? "Reprobado" : "Aprobado";

// Usa un switch para imprimir un mensaje adicional basado en la letra de la calificación
switch ($letra) {
    case 'A':
        echo " - Excelente trabajo.";
        break;
    case 'B':
        echo " - Buen trabajo.";
        break;
    case 'C':
        echo " - Trabajo aceptable.";
        break;
    case 'D':
        echo " - Necesitas mejorar.";
        break;
    case 'F':
        echo " - Debes esforzarte más.";
        break;
    default:
        echo " - Calificación no válida.";
        break;
}
?>

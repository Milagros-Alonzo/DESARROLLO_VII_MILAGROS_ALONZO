
<?php
echo "<h2>Estructura Condicional: switch</h2>";

// Ejemplo básico de switch
$diaSemana = "Miércoles";
switch ($diaSemana) {
    case "Lunes":
        echo "Hoy es el primer día de la semana laboral.<br>";
        break;
    case "Martes":
    case "Miércoles":
    case "Jueves":
        echo "Estamos a mitad de semana.<br>";
        break;
    case "Viernes":
        echo "¡Por fin es viernes!<br>";
        break;
    case "Sábado":
    case "Domingo":
        echo "¡Es fin de semana!<br>";
        break;
    default:
        echo "Día no válido.<br>";
}
echo "<br>";

// Ejemplo de switch con valores numéricos
$mes = 7;
switch ($mes) {
    case 12:
    case 1:
    case 2:
        echo "Es invierno.<br>";
        break;
    case 3:
    case 4:
    case 5:
        echo "Es primavera.<br>";
        break;
    case 6:
    case 7:
    case 8:
        echo "Es verano.<br>";
        break;
    case 9:
    case 10:
    case 11:
        echo "Es otoño.<br>";
        break;
    default:
        echo "Mes no válido.<br>";
}
echo "<br>";

// Ejemplo de switch con expresiones
$puntuacion = 85;
switch (true) {
    case ($puntuacion >= 90):
        echo "Excelente desempeño.<br>";
        break;
    case ($puntuacion >= 80):
        echo "Buen desempeño.<br>";
        break;
    case ($puntuacion >= 70):
        echo "Desempeño aceptable.<br>";
        break;
    case ($puntuacion >= 60):
        echo "Necesita mejorar.<br>";
        break;
    default:
        echo "Desempeño insuficiente.<br>";
}
echo "<br>";

// Ejemplo de switch sin break (fall-through)
$opcion = 2;
switch ($opcion) {
    case 1:
        echo "Has seleccionado la opción 1.<br>";
    case 2:
        echo "Has seleccionado la opción 2.<br>";
    case 3:
        echo "Has seleccionado la opción 3.<br>";
        break;
    default:
        echo "Opción no válida.<br>";
}

?>
    

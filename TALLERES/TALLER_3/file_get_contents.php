
<?php
// Ejemplo de uso de file_get_contents() con un archivo local
$contenidoArchivo = file_get_contents("archivo.txt");
echo "Contenido del archivo ejemplo.txt:
$contenidoArchivo
";

// Ejercicio: Usa file_get_contents() para leer el contenido de tu propio archivo PHP
// Por ejemplo, lee el contenido de "strlen.php" que creaste anteriormente
$nombreArchivo = "strlen.php"; // Asegúrate de que este archivo existe
$contenidoPhp = file_get_contents($nombreArchivo);
echo "
Contenido del archivo $nombreArchivo:
$contenidoPhp
";

// Bonus: Usa file_get_contents() para obtener el contenido de una página web
$url = "https://fedoraproject.org";
$contenidoWeb = file_get_contents($url);
echo "
Contenido de $url:
" . substr($contenidoWeb, 0, 500) . "...
"; // Mostramos solo los primeros 500 caracteres

// Extra: Manejo de errores al usar file_get_contents()
$archivoInexistente = "archivo_que_no_existe.txt";
$contenido = @file_get_contents($archivoInexistente); // El @ suprime los warnings

if ($contenido === false) {
    echo "
Error: No se pudo leer el archivo '$archivoInexistente'.
";
} else {
    echo "
Contenido del archivo '$archivoInexistente':
$contenido
";
}
?>
      

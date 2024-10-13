<?php
$archivoJson = 'registros.json';
if (file_exists($archivoJson)) {
    $registros = json_decode(file_get_contents($archivoJson), true);

    echo "<h2>Registros Procesados:</h2>";
    echo "<table border='1'>";
    echo "<tr><th>Nombre</th><th>Email</th><th>Edad</th><th>Género</th><th>Intereses</th><th>Foto</th></tr>";
    foreach ($registros as $registro) {
        echo "<tr>";
        echo "<td>{$registro['nombre']}</td>";
        echo "<td>{$registro['email']}</td>";
        echo "<td>{$registro['edad']}</td>";
        echo "<td>{$registro['genero']}</td>";
        echo "<td>" . implode(", ", $registro['intereses']) . "</td>";
        echo "<td><img src='{$registro['foto_perfil']}' width='50'></td>";
        echo "</tr>";
    }
    echo "</table>";
} else {
    echo "<p>No hay registros procesados aún.</p>";
}
?>

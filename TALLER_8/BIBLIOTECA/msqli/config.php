<?php
$host = 'localhost';
$db   = 'biblioteca';
$user = 'root';
$pass = '';
$conn = mysqli_connect($host, $user, $pass, $db);

if (!$conn) {
    die("Error en la conexión: " . mysqli_connect_error());
}
?>

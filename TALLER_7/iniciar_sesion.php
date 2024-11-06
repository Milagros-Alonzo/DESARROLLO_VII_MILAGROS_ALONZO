<?php
session_start();

$_SESSION['usuario'] = "María";
$_SESSION['rol'] = "admin";

echo "Sesión iniciada para " . $_SESSION['usuario'];
?>
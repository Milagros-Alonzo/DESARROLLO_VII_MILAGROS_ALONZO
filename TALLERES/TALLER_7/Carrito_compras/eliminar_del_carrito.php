<?php
include 'config_sesion.php';

$id = intval($_GET['id']);
if (isset($_SESSION['carrito'][$id])) {
    unset($_SESSION['carrito'][$id]);
}

header('Location: ver_carrito.php');
?>

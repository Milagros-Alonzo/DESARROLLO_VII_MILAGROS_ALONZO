<?php
include 'config_sesion.php';

if (!isset($_SESSION['carrito']) || empty($_SESSION['carrito'])) {
    $_SESSION['error'] = "Tu carrito está vacío, no puedes realizar el checkout.";
    header('Location: productos.php');
    exit();
}

$total = 0;
foreach ($_SESSION['carrito'] as $producto) {
    $total += $producto['precio'] * $producto['cantidad'];
}

setcookie('usuario', 'Nombre del Usuario', time() + 86400, "/", "", true, true);

$_SESSION['carrito'] = [];
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Checkout</title>
    <link rel="stylesheet" href="style.css">
</head>
<body>
    <div class="container">
        <h1>Compra Finalizada</h1>
        <p class="alert alert-success">Gracias por tu compra.</p>
        <p><strong>Total pagado: </strong>$<?php echo $total; ?></p>
        <a href="productos.php">Volver a productos</a>
    </div>
</body>
</html>

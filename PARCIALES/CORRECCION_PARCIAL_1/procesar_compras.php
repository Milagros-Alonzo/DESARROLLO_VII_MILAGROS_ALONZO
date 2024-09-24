<?php

include_once 'funiones_tienda.php';

$productos = [
    'camisa' => 50,
    'pantalon' => 70,
    'zapatos' => 80,
    'calcetines' => 10,
    'gorra' => 25
];

$carrito = [
    'camisa' => 2,
    'pantalon' => 1,
    'zapatos' => 1,
    'calcetines' => 3,
    'gorra' => 0
];

$subtotal = 0;
foreach ($carrito as $producto => $cantidad) {
    $subtotal += $productos[$producto] * $cantidad;
}

$descuento = calcular_descuento($subtotal);
$impuesto = aplicar_impuesto($subtotal);
$total = calcular_total($subtotal, $descuento, $impuesto);

?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Resumen de Compra</title>
</head>
<body>
    <h1>Resumen de la Compra</h1>
    <table border="1">
        <tr>
            <th>Producto</th>
            <th>Cantidad</th>
            <th>Precio Unitario</th>
            <th>Total</th>
        </tr>
        <?php foreach ($carrito as $producto => $cantidad): ?>
            <?php if ($cantidad > 0): ?>
            <tr>
                <td><?= ucfirst($producto) ?></td>
                <td><?= $cantidad ?></td>
                <td>$<?= number_format($productos[$producto], 2) ?></td>
                <td>$<?= number_format($productos[$producto] * $cantidad, 2) ?></td>
            </tr>
            <?php endif; ?>
        <?php endforeach; ?>
    </table>

    <p><strong>Subtotal:</strong> $<?= number_format($subtotal, 2) ?></p>
    <p><strong>Descuento:</strong> $<?= number_format($descuento, 2) ?></p>
    <p><strong>Impuesto:</strong> $<?= number_format($impuesto, 2) ?></p>
    <p><strong>Total a pagar:</strong> $<?= number_format($total, 2) ?></p>
</body>
</html>
